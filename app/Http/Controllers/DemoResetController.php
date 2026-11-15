<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class DemoResetController extends Controller
{
    /**
     * Reset the database and public uploads for scheduled demo refreshes.
     */
    public function reset(Request $request)
    {
        if (!config('app.demo_mode')) {
            abort(404);
        }

        $expectedToken = (string) config('app.demo_reset_token');
        $providedToken = (string) $request->bearerToken();

        if ($expectedToken === '' || !hash_equals($expectedToken, $providedToken)) {
            abort(403, 'Unauthorized');
        }

        set_time_limit(180);

        $publicDisk = Storage::disk('public');
        foreach ($publicDisk->allDirectories() as $directory) {
            $publicDisk->deleteDirectory($directory);
        }
        foreach ($publicDisk->files() as $file) {
            if (basename($file) !== '.gitignore') {
                $publicDisk->delete($file);
            }
        }

        Artisan::call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);
        Artisan::call('cache:clear');

        return response()->json([
            'status' => 'ok',
            'reset_at' => now()->toIso8601String(),
        ]);
    }
}
