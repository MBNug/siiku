<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        ini_set('max_execution_time', 120); // Set the maximum execution time to 120 seconds (2 minutes)
    }

    /**
     * Abort with 403 when a department-scoped account accesses another department's record.
     */
    protected function authorizeDepartmentAccess(string $kodeOrDept): void
    {
        $user = Auth::user();
        if ($user && (string) $user->level === '2' && substr((string) $user->kode, 0, 2) !== substr($kodeOrDept, 0, 2)) {
            abort(403, 'Anda tidak punya akses ke departemen ini.');
        }
    }
}
