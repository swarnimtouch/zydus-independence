<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('admin_user_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $admin = User::where('email', $credentials['email'])
            ->where('is_admin', true)
            ->first();

        if (!$admin || !Hash::check($credentials['password'], (string) $admin->password)) {
            return back()
                ->withErrors(['email' => 'Invalid admin credentials.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $request->session()->put('admin_user_id', $admin->id);

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('admin_user_id');
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function dashboard(): View
    {
        $usersCount = User::where('is_admin', false)->count();

        return view('admin.dashboard', compact('usersCount'));
    }

    public function users(): View
    {
        $users = User::where('is_admin', false)
            ->latest()
            ->get();

        return view('admin.users', compact('users'));
    }

    public function downloadCertificate(User $user)
    {
        abort_if($user->is_admin, 404);
        abort_if(!$user->certificate_path, 404);

        $s3 = Storage::disk('s3');
        abort_if(!$s3->exists($user->certificate_path), 404);

        return $s3->download(
            $user->certificate_path,
            'zydus-certificate-'.$user->id.'.png',
            ['Content-Type' => 'image/png']
        );
    }

    public function destroy(User $user): RedirectResponse
    {
        abort_if($user->is_admin, 403);

        $this->deleteS3Files([$user->photo, $user->certificate_path]);
        $user->delete();

        return redirect()
            ->route('admin.users')
            ->with('success', 'Registration deleted successfully.');
    }

    public function export()
    {
        $users = User::where('is_admin', false)
            ->latest()
            ->get();

        $fileName = 'zydus-registrations-'.now()->format('Y-m-d-H-i-s').'.csv';

        return response()->streamDownload(function () use ($users): void {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Sr No',
                'Name',
                'BO Code',
                'Doctor Code',
                'Photo Link',
                'Certificate Link',
                'Registered At',
            ]);

            foreach ($users as $index => $user) {
                fputcsv($handle, [
                    $index + 1,
                    $user->name,
                    $user->bo_code,
                    $user->doctor_code,
                    $this->s3Url($user->photo),
                    $this->s3Url($user->certificate_path) ?: ($user->certificate_path ? route('admin.certificate.download', $user) : ''),
                    optional($user->created_at)
                        ? $user->created_at->timezone('Asia/Kolkata')->format('d M Y, h:i A')
                        : '',
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    private function deleteS3Files(array $paths): void
    {
        $paths = collect($paths)
            ->filter()
            ->map(fn (string $path) => $this->s3Path($path))
            ->filter()
            ->unique()
            ->values()
            ->all();

        if ($paths) {
            Storage::disk('s3')->delete($paths);
        }
    }

    private function s3Url(?string $path): string
    {
        $path = $this->s3Path($path);

        return $path ? Storage::disk('s3')->url($path) : '';
    }

    private function s3Path(?string $path): string
    {
        if (!$path) {
            return '';
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            $urlPath = parse_url($path, PHP_URL_PATH);

            return $urlPath ? ltrim($urlPath, '/') : '';
        }

        return ltrim($path, '/');
    }
}
