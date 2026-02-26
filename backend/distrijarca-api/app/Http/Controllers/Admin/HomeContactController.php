<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HomeContact;
use Illuminate\Http\Request;

class HomeContactController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:50',
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:500',
            'address_title' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'phone_title' => 'required|string|max:50',
            'phone_1' => 'required|string|max:50',
            'phone_2' => 'nullable|string|max:50',
            'email_title' => 'required|string|max:50',
            'email_1' => 'required|email|max:100',
            'email_2' => 'nullable|email|max:100',
            'hours_title' => 'required|string|max:50',
            'hours_weekday' => 'required|string|max:100',
            'hours_saturday' => 'required|string|max:100',
        ]);

        $contact = HomeContact::first();

        if ($contact) {
            $contact->update($validated);
        } else {
            $contact = HomeContact::create($validated);
        }

        ActivityLog::log('update_home_contact', 'Sección Contacto actualizada', HomeContact::class, $contact->id);

        return redirect()->route('admin.home-sections.index')
            ->with('success', 'Sección Contacto actualizada correctamente');
    }
}
