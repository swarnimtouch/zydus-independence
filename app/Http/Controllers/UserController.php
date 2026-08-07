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
            'name'         => 'required|string|max:255',
            'bo_code'      => 'required|string|max:255',
            'doctor_code'  => 'required|string|max:255',
            'photo'        => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Upload Photo
        if ($request->hasFile('photo')) {

            $file = $request->file('photo');

            $fileName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('uploads/users'), $fileName);

            $validated['photo'] = 'uploads/users/'.$fileName;
        }

        $user = User::create($validated);

        session(['user_id' => $user->id]);

        return redirect()->route('second')
            ->with('success', 'Form submitted successfully!');
    }

    public function second()
    {
        return view('second');
    }

    public function third()
    {
        return view('third');
    }

    public function activity()
    {
        return view('activity');
    }


    public function atorvaGold()
    {
        return view('atorva_gold');
    }
    public function certificate()
    {
        $user = User::findOrFail(session('user_id'));

        // Certificate image
        $imagePath = public_path('images/certificate.jpg');
        $image = imagecreatefromjpeg($imagePath);

        // Text color
        $black = imagecolorallocate($image, 0, 0, 0);

        // Font
        $font = public_path('fonts/Poppins-Bold.ttf');

        // User name
        $name = $user->name;

        // Font size
        $fontSize = 40;

        // Center text at X = 500
        $bbox = imagettfbbox($fontSize, 0, $font, $name);
        $textWidth = $bbox[2] - $bbox[0];

        $x = 500 - ($textWidth / 2);
        $y = 500;

        // Write name
        imagettftext(
            $image,
            $fontSize,
            0,
            $x,
            $y,
            $black,
            $font,
            $name
        );

        // Output image
        ob_start();
        imagejpeg($image, null, 100);
        $imageData = ob_get_clean();

        imagedestroy($image);

        return response($imageData)
            ->header('Content-Type', 'image/jpeg');
    }
}
