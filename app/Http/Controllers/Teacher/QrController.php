<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrController extends Controller
{
    public function generate()
    {
        $token = Str::random(40);

        Session::put('qr_token', $token);
        Session::put('qr_expiration', now()->addMinutes(5));

        $qr = QrCode::size(300)->generate(
            route('student.qr.validate', $token)
        );

        return view('teacher.qr', compact('qr'));
    }
}

