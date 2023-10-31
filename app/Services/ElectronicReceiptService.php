<?php

namespace App\Services;

use App\Sri\Endpoints\EndPoints;
use App\SRI\Templates\XML\CreditNote110;
use App\SRI\Templates\XML\Invoice110;
use App\SRI\Templates\XML\DebitNote100;
use App\SRI\Templates\XML\PurchaseLiquidation110;
use App\SRI\Templates\XML\RemissionGuide110;
use App\SRI\Templates\XML\RetentionReceipt200;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\ArrayToXml\ArrayToXml;

class ElectronicReceiptService
{
    const responseSriTypeAutorizado = 'AUTORIZADO';
    const responseSriTypeNoAutorizado = 'NO AUTORIZADO';
    const responseSriTypeEnProceso = 'EN PROCESO';
    const responseSriTypeRecibida = 'RECIBIDA';
    const responseSriTypeDevuelta = 'DEVUELTA';

    const partialPathElecetronicReceipt = 'app/public';

    public function arrayToXml($electronicReceiptArray, $electronicReceiptType, $version)
    {
        $electronicReceiptXml = ArrayToXml::convert($electronicReceiptArray, [
            'rootElementName' => $electronicReceiptType,
            '_attributes' => [
                'id' => 'comprobante',
                'version' => $version
            ],
        ], true, 'UTF-8');
        return $electronicReceiptXml;
    }

    public function sendElectronicReceiptToSriFromReception($xmlSigned, $environment)
    {
        $xmlBase64 = base64_encode($xmlSigned);
        $params = array();
        $params['xml'] = $xmlBase64;

        $endPointSri = new EndPoints($environment, 'reception');
        $responseReception = $endPointSri->sendToSri($params);
        return $responseReception;
    }

    public function sendElectronicReceiptToSriFromAuthorization($accessKey, $environment)
    {
        $params = array();
        $params['claveAccesoComprobante'] = $accessKey;
        $endPointSri = new EndPoints($environment, 'authorization');
        $responseAuth = $endPointSri->authorization($params);
        return $responseAuth;
    }

    public function getAccessKey($date, $number, $identification, $electronicReceiptType, $environmentTest, $emissionType)
    {
        $fechaEmision = Carbon::parse($date);
        $tipoComprobante = $electronicReceiptType;
        $ruc = $identification;
        $ambiente = $environmentTest;
        // $serie = '001'; //
        // $secuencial = $number;
        // $secuencialArray = explode('-', $secuencial);
        // $secuencial2 = $secuencialArray[2];
        // $secuencialArray = $secuencialArray[0] . $secuencialArray[1] . $secuencialArray[2];

        $codigoNumerico = '00000000';
        $tipoEmision = $emissionType;

        $year = $fechaEmision->year;
        $month = $fechaEmision->format('m');
        $day = $fechaEmision->format('d');
        $claveAcceso = $day . $month . $year . $tipoComprobante . $ruc . $ambiente . $number . $codigoNumerico . $tipoEmision;
        $digitoVerificador = $this->getModulo11Factor2($claveAcceso);
        $claveAcceso = $claveAcceso . $digitoVerificador;
        return $claveAcceso;
    }

    public static function getModulo11Factor2($cadena)
    {
        $factor = 2;
        $suma = 0;
        for ($i = strlen($cadena) - 1; $i >= 0; $i--) {
            $suma += $factor * $cadena[$i];
            $factor = $factor % 7 == 0 ? 2 : $factor + 1;
        }
        $dv = 11 - $suma % 11;
        $ds = $dv == 11 ? 0 : ($dv == 10 ? 1 : $dv);
        return $ds;
    }

    public function verifyResponse($response)
    {
        $verifyArrayResponse = [];
        if (array_key_exists('autorizaciones', $response))
            if ($response['autorizaciones']['autorizacion']['estado'] == 'AUTORIZADO') {
                $verifyArrayResponse['status'] = 'AUTORIZADO';
                return $verifyArrayResponse;
            } else if ($response['autorizaciones']['autorizacion']['estado'] == 'NO AUTORIZADO') {
                $dataError = $response['autorizaciones']['autorizacion']['mensajes']['mensaje'];
                $verifyArrayResponse['status'] = 'NO AUTORIZADO';
                if (array_key_exists('informacionAdicional', $dataError)) {
                    $verifyArrayResponse['errors'][] = iconv("ISO-8859-1", "UTF-8", $dataError['informacionAdicional']);
                } else
                    foreach ($dataError as $error) {
                        $verifyArrayResponse['errors'][] = iconv("ISO-8859-1", "UTF-8", $error['informacionAdicional']);
                    }
                return $verifyArrayResponse;

                $verifyArrayResponse['status'] = 'NO AUTORIZADO';
                return $verifyArrayResponse;
            } else if ($response['autorizaciones']['autorizacion']['estado'] == 'EN PROCESO') {
                $verifyArrayResponse['status'] = 'EN PROCESO';
                return $verifyArrayResponse;
            }
        if (array_key_exists('estado', $response) && $response['estado'] == 'DEVUELTA') {
            $dataError = $response['comprobantes']['comprobante']['mensajes']['mensaje'];
            $verifyArrayResponse['status'] = 'DEVUELTA';
            if (array_key_exists('informacionAdicional', $dataError)) {
                $verifyArrayResponse['errors'][] = iconv("ISO-8859-1", "UTF-8", $dataError['informacionAdicional']);
            } else {
                $verifyArrayResponse['errors'][] = iconv("ISO-8859-1", "UTF-8", $dataError['mensaje']);
            }
            return $verifyArrayResponse;
        }
    }

    public function generatePdfElectronicReceipt($data, $number, $electronicReceiptType)
    {
        $footerHtml = view()->make('pdfs.footer')->render();
        $pdf = SnappyPdf::loadView('pdfs.' . $electronicReceiptType, compact('data'))
            ->setOption('margin-top', '5mm')
            ->setOption('margin-left', '0mm')
            ->setOption('margin-right', '0mm')
            ->setOption('margin-bottom', '10mm')
            ->setOption('footer-html', $footerHtml);
        $pdfFile = $pdf->download('Electronic_Receipt.pdf');
        return $pdfFile->getContent();
    }
}
