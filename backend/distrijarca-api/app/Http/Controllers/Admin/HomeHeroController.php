<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HomeHero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeHeroController extends Controller
{
    public function edit()
    {
        $hero = HomeHero::first();

        return view('admin.home-hero.edit', compact('hero'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'texto' => 'required|string|max:500',
            'imagen_fondo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $hero = HomeHero::first();

        if ($request->hasFile('imagen_fondo')) {
            if ($hero && $hero->imagen_fondo) {
                Storage::disk('public')->delete($hero->imagen_fondo);
            }
            $validated['imagen_fondo'] = $request->file('imagen_fondo')->store('home-hero', 'public');
        }

        if ($hero) {
            $hero->update($validated);
        } else {
            $hero = HomeHero::create($validated);
        }

        ActivityLog::log('update_home_hero', 'Hero principal actualizado', HomeHero::class, $hero->id);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Hero principal actualizado correctamente');
    }
}
