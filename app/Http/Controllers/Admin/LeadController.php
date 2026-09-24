<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(): View
    {
        return view('admin.leads.index', [
            'leads' => Lead::newest()->paginate(30),
        ]);
    }

    public function markRead(Lead $lead): RedirectResponse
    {
        $lead->update(['is_read' => true]);

        return back()->with('status', 'Отмечено как прочитанное.');
    }

    public function destroy(Lead $lead): RedirectResponse
    {
        $lead->delete();

        return back()->with('status', 'Заявка удалена.');
    }
}
