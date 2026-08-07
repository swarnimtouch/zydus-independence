<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Show the form (Create page).
     */
    public function create(): View
    {
        return view('form.create');
    }

    /**
     * Handle form submission and save the data.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'city'       => ['required', 'string', 'max:255'],
            'speciality' => ['required', 'string', 'max:255'],
        ]);



        User::create($validated);

        return redirect()
            ->route('form.create')
            ->with('success', 'Form submitted successfully!');
    }
}
