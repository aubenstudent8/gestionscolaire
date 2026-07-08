<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function change(Request $request)
    {
        $data = $request->validate([
            'locale' => 'required|string|in:en,fr,es',
        ]);

        // Persist in session
        session()->put('locale', $data['locale']);

        // If user is authenticated, save preference to database for cross-device persistence
        if ($request->user()) {
            $request->user()->update(['locale' => $data['locale']]);
        }

        return redirect()->back();
    }
}
