<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HomeAbout;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeAboutController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:100',
            'title_before' => 'required|string|max:100',
            'title_highlight' => 'required|string|max:100',
            'title_after' => 'required|string|max:150',
            'paragraph_1' => 'required|string|max:1000',
            'paragraph_2' => 'nullable|string|max:1000',
            'stat_1_value' => 'required|string|max:20',
            'stat_1_label' => 'required|string|max:60',
            'stat_2_value' => 'required|string|max:20',
            'stat_2_label' => 'required|string|max:60',
            'stat_3_value' => 'required|string|max:20',
            'stat_3_label' => 'required|string|max:60',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'image_alt' => 'required|string|max:150',
            'badge_text' => 'required|string|max:50',
        ]);

        $about = HomeAbout::first();

        if ($request->hasFile('image')) {
            if ($about && $about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $validated['image'] = $request->file('image')->store('home-about', 'public');
        }

        if ($about) {
            $about->update($validated);
        } else {
            $about = HomeAbout::create($validated);
        }

        ActivityLog::log('update_home_about', 'Sección Nosotros actualizada', HomeAbout::class, $about->id);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Sección Nosotros actualizada correctamente');
    }
}
