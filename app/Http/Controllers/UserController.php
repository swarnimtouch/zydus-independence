<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    private const PROJECT_FOLDER = 'zydus-independence';
    private const CROP_PHOTO_FOLDER = self::PROJECT_FOLDER.'/crop-photo';
    private const CERTIFICATE_PHOTO_FOLDER = self::PROJECT_FOLDER.'/certificate-photo';

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

        $token = Str::random(48);
        $photoPath = self::CROP_PHOTO_FOLDER.'/'.$token.'.png';
        $certificatePath = self::CERTIFICATE_PHOTO_FOLDER.'/'.$token.'.png';
        $certificateImage = $this->makeCertificateImage($validated['name'], $imageData);

        $s3 = Storage::disk('s3');
        $photoStored = $s3->put($photoPath, $imageData, [
            'visibility' => 'public',
            'ContentType' => 'image/png',
        ]);
        $certificateStored = $s3->put($certificatePath, $certificateImage, [
            'visibility' => 'public',
            'ContentType' => 'image/png',
        ]);

        if (!$photoStored || !$certificateStored) {
            return back()
                ->withErrors(['photo' => 'Photo upload failed. Please check S3 configuration and try again.'])
                ->withInput();
        }

        $validated['photo'] = $photoPath;
        $validated['certificate_token'] = $token;
        $validated['certificate_path'] = $certificatePath;

        $user = User::create($validated);

        return redirect()->route('second', ['u' => $user->certificate_token])
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

    public function certificate(Request $request)
    {
        $user = $this->certificateUser($request);

        if (!$user) {
            return redirect()->route('form.create');
        }

        $photoUrl = $this->storedFileUrl($user->photo);

        return view('certificate', compact('user', 'photoUrl'));
    }

    public function downloadCertificate(Request $request)
    {
        $user = $this->certificateUser($request);

        if (!$user) {
            return redirect()->route('form.create');
        }

        $imageData = $this->storedCertificateImage($user);

        return response($imageData)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="zydus-certificate-'.$user->id.'.png"');
    }

    private function certificateUser(Request $request): ?User
    {
        $token = $request->query('u');

        if (!$token) {
            return null;
        }

        return User::where('certificate_token', $token)->first();
    }

    private function storedCertificateImage(User $user): string
    {
        $s3 = Storage::disk('s3');

        if ($user->certificate_path && $s3->exists($user->certificate_path)) {
            return $s3->get($user->certificate_path);
        }

        $photoData = $s3->get($user->photo);
        $imageData = $this->makeCertificateImage($user->name, $photoData);
        $certificatePath = self::CERTIFICATE_PHOTO_FOLDER.'/'.$user->certificate_token.'.png';

        $s3->put($certificatePath, $imageData, [
            'visibility' => 'public',
            'ContentType' => 'image/png',
        ]);

        $user->forceFill(['certificate_path' => $certificatePath])->save();

        return $imageData;
    }

    private function makeCertificateImage(string $name, string $photoData): string
    {
        $imagePath = public_path('images/Certificate.jpg');
        $certificate = imagecreatefromjpeg($imagePath);
        $photo = imagecreatefromstring($photoData);

        if ($photo) {
            $this->placeCertificatePhoto($certificate, $photo, 797, 342, 326);
            imagedestroy($photo);
        }

        $this->placeCertificateName($certificate, $name, 960, 748, 50, 900);

        ob_start();
        imagepng($certificate);
        $imageData = ob_get_clean();

        imagedestroy($certificate);

        return $imageData;
    }

    private function placeCertificatePhoto($certificate, $photo, int $x, int $y, int $size): void
    {
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

        imagedestroy($circle);
    }

    private function storedFileUrl(?string $path): string
    {
        if (!$path) {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, self::PROJECT_FOLDER.'/')) {
            return Storage::disk('s3')->url($path);
        }

        return asset($path);
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
