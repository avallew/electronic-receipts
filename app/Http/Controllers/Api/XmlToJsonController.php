<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class XmlToJsonController extends Controller
{
    public function xmlToJson(Request $request)
    {
        $file = $request->file('xmlFile');
        if ($file)
            $xmlData = simplexml_load_file($file);
        // $jsonData = json_encode($xmlData);
        // return response()->json(json_decode($jsonData, true));

        $jsonData = json_encode($xmlData);
        $campoAdicionalJson = $this->processCampoAdicional($xmlData);
        $mergedJsonData = $this->mergeJson($jsonData, $campoAdicionalJson);
        return response()->json(json_decode($mergedJsonData, true));
    }

    private function processCampoAdicional($xmlData)
    {
        $campoAdicionalArray = [];

        foreach ($xmlData->infoAdicional->campoAdicional as $campo) {
            $nombre = (string) $campo['nombre'];
            $valor = (string) $campo;

            $campoAdicionalArray[] = [
                'nombre' => $nombre,
                'valor' => $valor,
            ];
        }

        return json_encode(['infoAdicional' => $campoAdicionalArray]);
    }

    private function mergeJson($json1, $json2)
    {
        $array1 = json_decode($json1, true);
        $array2 = json_decode($json2, true);

        return json_encode(array_merge($array1, $array2));
    }
}
