<?php

namespace App\Services;

use App\Firmador\Firmador;
use App\Models\Setting;
use App\Models\Settings;
use App\Sri\Endpoints\EndPoints;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class SignService
{
    public function uploadSignFile($file)
    {
        $path = 'public/sign/FirmaElectronica.p12';
        Storage::deleteDirectory('public/sign');
        Storage::put($path, file_get_contents($file));
        return response()->json([
            'message' => 'Sign Uploaded Successfully',
            'status' => true
        ], 200);
    }

    public function validateSign($file, $password, $ruc)
    {
        if ($this->validatePassword($file, $password)) {
            $data = $this->getDataSign($file, $password);
            if ($this->validateRuc($data['extensions'], $ruc)) {
                $dataDate = $this->validateDateExpiration($data['extensions']);
                if ($dataDate['is_valid_date'])
                    return $dataDate;
                else
                    return 'Expiration date invalid';
            } else {
                return 'Ruc not found';
            }
        } else {
            return 'Incorrect Password';
        }
    }

    public function validatePassword($file, $password)
    {
        $certs = array();
        $pkcs12 = file_get_contents($file);
        return openssl_pkcs12_read($pkcs12, $certs, $password);
    }

    public function validateRuc($extensions, $ruc)
    {
        $rucFound = null;
        foreach ($extensions as $key => $value) {
            if (strpos($key, '3.11') !== false) {
                $rucFound = $value;
                break;
            }
        }
        return $rucFound == $ruc ? true : false;
    }

    public function validateDateExpiration($extensions)
    {
        $usagePeriod = Arr::get($extensions, 'privateKeyUsagePeriod');
        $segmentos = explode(', ', $usagePeriod);
        $resultado = [];
        foreach ($segmentos as $segmento) {
            list($clave, $valor) = explode(': ', $segmento, 2);
            $resultado[$clave] = $valor;
        }
        $now = Carbon::now();
        if ($now->isAfter(Carbon::parse($resultado['Not After'])))
            return false;
        else {
            $dataDate['expiration_date'] = Carbon::parse($resultado['Not After']);
            $dataDate['is_valid_date'] = true;
            return $dataDate;
        }
    }

    public function getDataSign($file, $password)
    {
        $certs = array();
        $pkcs12 = file_get_contents($file);
        openssl_pkcs12_read($pkcs12, $certs, $password);
        return openssl_x509_parse($certs['cert']);
    }

    public function deleteSignElectronic()
    {
        Storage::deleteDirectory('public/sign');
        // $settings = Setting::first();
        // $settings->path_sign_electronic = null;
        // $settings->key_sign_electronic = null;
        // $settings->save();
        // return $settings;
        return response()->json([
            'message' => 'Sign Deleted Successfully',
            'status' => true
        ], 200);
    }

    // public function downloadSignFile()
    // {
    //     $settings = Setting::first();
    //     return $settings->path_sign_electronic != null ? $settings->path_sign_electronic : 'Signature not set';
    // }

    public function signer($invoiceXml)
    {
        $pathSignatureElectronic = storage_path('app/public/sign/FirmaElectronica.p12');
        $signer = new Firmador();
        $xmlSigned = $signer->signerXml($pathSignatureElectronic, env('SIGNATURE_KEY'), $invoiceXml, $signer::TO_XML_FILE, null);
        return $xmlSigned;
    }
}
