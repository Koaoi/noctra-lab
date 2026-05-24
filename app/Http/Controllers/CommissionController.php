<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CommissionController extends Controller
{
    public function index()
    {
        return view('commission.index');
    }

    public function create()
    {
        return view('commission.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['required', 'string', 'max:3000'],
            'budget'           => ['nullable', 'numeric', 'min:0'],
            'size_preference'  => ['nullable', 'string', 'max:100'],
            'color_preference' => ['nullable', 'string', 'max:100'],
            'reference_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('reference_image')) {
            $imagePath = $request->file('reference_image')
                ->store('commissions', 'public');
        }

        Commission::create([
            'user_id'          => auth()->id(),
            'title'            => $validated['title'],
            'description'      => $validated['description'],
            'budget'           => $validated['budget'] ?? null,
            'size_preference'  => $validated['size_preference'] ?? null,
            'color_preference' => $validated['color_preference'] ?? null,
            'reference_image'  => $imagePath,
            'status'           => 'pending',
        ]);

        return redirect()
            ->route('commission.index')
            ->with('success', 'Commission request berhasil dikirim! Tim kami akan menghubungi kamu segera.');
    }

    public function show(Commission $commission)
    {
        abort_if($commission->user_id !== auth()->id(), 403);

        return view('commission.show', compact('commission'));
    }
}