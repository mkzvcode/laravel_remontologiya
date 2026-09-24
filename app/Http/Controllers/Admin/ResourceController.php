<?php

namespace App\Http\Controllers\Admin;

use App\Admin\ResourceRegistry;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Один контроллер обслуживает ~18 однотипных справочников контента
 * (услуги, отзывы, кейсы портфолио, FAQ и т.д.) — их описание лежит
 * в App\Admin\ResourceRegistry, а тут только универсальная механика:
 * список, форма, сохранение с загрузкой картинок, публикация, порядок.
 */
class ResourceController extends Controller
{
    protected function resourceOrAbort(string $slug): array
    {
        $resource = ResourceRegistry::find($slug);
        abort_if($resource === null, 404);

        return $resource;
    }

    public function index(string $resource): View
    {
        $def = $this->resourceOrAbort($resource);
        /** @var Model $model */
        $model = new $def['model'];

        $query = $model->newQuery();
        if ($def['orderable'] ?? false) {
            if ($scope = $def['order_scope'] ?? null) {
                $query->orderBy($scope);
            }
            $query->orderBy('sort_order');
        } else {
            $query->latest();
        }

        return view('admin.resources.index', [
            'slug' => $resource,
            'def' => $def,
            'items' => $query->get(),
        ]);
    }

    public function create(string $resource): View
    {
        $def = $this->resourceOrAbort($resource);

        return view('admin.resources.form', [
            'slug' => $resource,
            'def' => $def,
            'item' => new $def['model'],
            'selectOptions' => $this->selectOptions($def),
        ]);
    }

    public function edit(string $resource, int $id): View
    {
        $def = $this->resourceOrAbort($resource);
        $item = $def['model']::findOrFail($id);

        return view('admin.resources.form', [
            'slug' => $resource,
            'def' => $def,
            'item' => $item,
            'selectOptions' => $this->selectOptions($def),
        ]);
    }

    public function store(Request $request, string $resource): RedirectResponse
    {
        $def = $this->resourceOrAbort($resource);
        $data = $this->validated($request, $def);

        if ($def['orderable'] ?? false) {
            $scope = $def['order_scope'] ?? null;
            $query = $def['model']::query();
            if ($scope && isset($data[$scope])) {
                $query->where($scope, $data[$scope]);
            }
            $data['sort_order'] = ((int) $query->max('sort_order')) + 1;
        }

        $item = $def['model']::create($data);

        return redirect()
            ->route('admin.resource.edit', ['resource' => $resource, 'id' => $item->id])
            ->with('status', 'Запись создана.');
    }

    public function update(Request $request, string $resource, int $id): RedirectResponse
    {
        $def = $this->resourceOrAbort($resource);
        $item = $def['model']::findOrFail($id);
        $data = $this->validated($request, $def, $item);

        $item->update($data);

        return redirect()
            ->route('admin.resource.edit', ['resource' => $resource, 'id' => $item->id])
            ->with('status', 'Изменения сохранены.');
    }

    public function destroy(string $resource, int $id): RedirectResponse
    {
        $def = $this->resourceOrAbort($resource);
        $item = $def['model']::findOrFail($id);

        foreach ($def['fields'] as $field) {
            if ($field['type'] === 'image' && $item->{$field['name']}) {
                $this->deleteUploadedImage($item->{$field['name']});
            }
        }

        $item->delete();

        return redirect()
            ->route('admin.resource.index', $resource)
            ->with('status', 'Запись удалена.');
    }

    public function toggle(string $resource, int $id): RedirectResponse
    {
        $def = $this->resourceOrAbort($resource);
        $column = $def['toggle_column'] ?? null;
        abort_if($column === null, 404);

        $item = $def['model']::findOrFail($id);
        $item->update([$column => ! $item->{$column}]);

        return back()->with('status', 'Статус обновлён.');
    }

    public function move(string $resource, int $id, string $direction): RedirectResponse
    {
        $def = $this->resourceOrAbort($resource);
        abort_unless($def['orderable'] ?? false, 404);

        /** @var Model $model */
        $model = $def['model'];
        $item = $model::findOrFail($id);
        $scope = $def['order_scope'] ?? null;

        $scoped = fn () => $scope
            ? $model::where($scope, $item->{$scope})
            : $model::query();

        $neighbor = $direction === 'up'
            ? $scoped()->where('sort_order', '<', $item->sort_order)->orderByDesc('sort_order')->first()
            : $scoped()->where('sort_order', '>', $item->sort_order)->orderBy('sort_order')->first();

        if ($neighbor) {
            [$a, $b] = [$item->sort_order, $neighbor->sort_order];
            $item->update(['sort_order' => $b]);
            $neighbor->update(['sort_order' => $a]);
        }

        return back()->with('status', 'Порядок обновлён.');
    }

    /** @return array<string, mixed> */
    protected function validated(Request $request, array $def, ?Model $item = null): array
    {
        $rules = [];
        foreach ($def['fields'] as $field) {
            if ($field['type'] === 'image') {
                continue; // валидируем и обрабатываем отдельно ниже
            }
            $rules[$field['name']] = $field['rules'] ?? 'nullable';
        }

        $data = $request->validate($rules);

        foreach ($def['fields'] as $field) {
            $name = $field['name'];

            if ($field['type'] === 'checkbox') {
                $data[$name] = $request->boolean($name);
            }

            if ($field['type'] === 'repeater') {
                $values = collect($request->input($name, []))
                    ->map(fn ($v) => trim((string) $v))
                    ->filter()
                    ->values()
                    ->all();
                $data[$name] = $values;
            }

            if ($field['type'] === 'image') {
                $request->validate([$name => $field['rules'] ?? 'nullable|image|max:5120']);

                if ($request->hasFile($name)) {
                    if ($item && $item->{$name}) {
                        $this->deleteUploadedImage($item->{$name});
                    }
                    $data[$name] = '/storage/'.$request->file($name)->store('uploads', 'public');
                } elseif ($request->boolean($name.'_remove') && $item) {
                    if ($item->{$name}) {
                        $this->deleteUploadedImage($item->{$name});
                    }
                    $data[$name] = null;
                }
            }
        }

        return $data;
    }

    protected function deleteUploadedImage(?string $path): void
    {
        if (! $path || ! str_starts_with($path, '/storage/')) {
            return; // не трогаем изображения из seed-комплекта (/img/...)
        }
        Storage::disk('public')->delete(Str::after($path, '/storage/'));
    }

    protected function selectOptions(array $def): array
    {
        $options = [];
        foreach ($def['fields'] as $field) {
            if ($field['type'] === 'select_model') {
                $options[$field['name']] = $field['model']::query()
                    ->orderBy('id')
                    ->pluck($field['option_label'], 'id');
            }
        }

        return $options;
    }
}
