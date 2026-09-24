<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'source' => ['nullable', 'string', 'max:32'],
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32'],
            'area' => ['nullable', 'string', 'max:32'],
            'message' => ['nullable', 'string', 'max:2000'],
            // honeypot: обычный посетитель это поле не видит и не заполняет
            'website' => ['nullable', 'max:0'],
        ]);

        Lead::create([
            'source' => $data['source'] ?? 'contacts',
            'name' => $data['name'] ?? null,
            'phone' => $data['phone'],
            'area' => $data['area'] ?? null,
            'message' => $data['message'] ?? null,
        ]);

        return response()->json(['ok' => true]);
    }
}
