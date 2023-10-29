<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SignService;
use Illuminate\Http\Request;

class SignController extends Controller
{
    public function uploadSignFile(Request $request)
    {
        if ($file = $request->file('signP12')) {
            $signService = new SignService();
            return $signService->uploadSignFile($file);
        }
    }

    public function deleteSignElectronic()
    {
        $signService = new SignService();
        return $signService->deleteSignElectronic();
    }
}
