<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
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
            'cropped_photo'=> 'required|string',
        ]);

        unset($validated['cropped_photo']);

        $croppedPhoto = $request->input('cropped_photo');

        if (!preg_match('/^data:image\/png;base64,/', $croppedPhoto)) {
            return back()
                ->withErrors(['photo' => 'Please crop your photo again.'])
                ->withInput();
        }

        $imageData = base64_decode(preg_replace('/^data:image\/png;base64,/', '', $croppedPhoto), true);

        if ($imageData === false) {
            return back()
                ->withErrors(['photo' => 'Please crop your photo again.'])
                ->withInput();
        }

        if (getimagesizefromstring($imageData) === false) {
            return back()
                ->withErrors(['photo' => 'Please crop your photo again.'])
                ->withInput();
        }

        $uploadPath = public_path('uploads/users');

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $fileName = time().'_'.Str::random(12).'.png';
        file_put_contents($uploadPath.'/'.$fileName, $imageData);

        $validated['photo'] = 'uploads/users/'.$fileName;

        $user = User::create($validated);

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
        $user = $this->certificateUser();

        if (!$user) {
            return redirect()->route('form.create');
        }

        return view('certificate', compact('user'));
    }

    public function downloadCertificate()
    {
        $user = $this->certificateUser();

        if (!$user) {
            return redirect()->route('form.create');
        }

        $imageData = $this->makeCertificateImage($user);

        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="zydus-certificate.png"');
    }

    private function certificateUser(): ?User
    {
        return User::latest('id')->first();
    }

    private function makeCertificateImage(User $user): string
    {
        $imagePath = public_path('images/Certificate.jpg');
        $certificate = imagecreatefromjpeg($imagePath);

        $this->placeCertificatePhoto($certificate, public_path($user->photo), 797, 342, 326);
        $this->placeCertificateName($certificate, $user->name, 960, 748, 50, 900);

        ob_start();
        imagepng($certificate);
        $imageData = ob_get_clean();

        imagedestroy($certificate);

        return $imageData;
    }

    private function placeCertificatePhoto($certificate, string $photoPath, int $x, int $y, int $size): void
    {
        if (!is_file($photoPath)) {
            return;
        }

        $photo = $this->createImageFromPath($photoPath);

        if (!$photo) {
            return;
        }

        $circle = imagecreatetruecolor($size, $size);

        imagealphablending($circle, false);
        imagesavealpha($circle, true);

        $transparent = imagecolorallocatealpha($circle, 0, 0, 0, 127);
        imagefill($circle, 0, 0, $transparent);

        imagecopyresampled(
            $circle,
            $photo,
            0,
            0,
            0,
            0,
            $size,
            $size,
            imagesx($photo),
            imagesy($photo)
        );

        $radius = $size / 2;

        for ($pixelX = 0; $pixelX < $size; $pixelX++) {
            for ($pixelY = 0; $pixelY < $size; $pixelY++) {
                $distance = sqrt((($pixelX - $radius) ** 2) + (($pixelY - $radius) ** 2));

                if ($distance > $radius) {
                    imagesetpixel($circle, $pixelX, $pixelY, $transparent);
                }
            }
        }

        imagecopy($certificate, $circle, $x, $y, 0, 0, $size, $size);

        imagedestroy($photo);
        imagedestroy($circle);
    }

    private function createImageFromPath(string $path)
    {
        $imageInfo = getimagesize($path);
        $type = $imageInfo[2] ?? null;

        return match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($path),
            IMAGETYPE_PNG => imagecreatefrompng($path),
            IMAGETYPE_WEBP => function_exists('imagecreatefromwebp') ? imagecreatefromwebp($path) : false,
            default => false,
        };
    }

    private function placeCertificateName($certificate, string $name, int $centerX, int $baselineY, int $fontSize, int $maxWidth): void
    {
        $font = public_path('fonts/Poppins-Bold.ttf');
        $name = trim($name);

        while ($fontSize > 28) {
            $bbox = imagettfbbox($fontSize, 0, $font, $name);
            $textWidth = $bbox[2] - $bbox[0];

            if ($textWidth <= $maxWidth) {
                break;
            }

            $fontSize -= 2;
        }

        $bbox = imagettfbbox($fontSize, 0, $font, $name);
        $textWidth = $bbox[2] - $bbox[0];
        $black = imagecolorallocate($certificate, 31, 31, 31);

        $x = $centerX - ($textWidth / 2);

        imagettftext(
            $certificate,
            $fontSize,
            0,
            $x,
            $baselineY,
            $black,
            $font,
            $name
        );
    }
}
