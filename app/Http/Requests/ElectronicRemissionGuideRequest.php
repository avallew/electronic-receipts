<?php

namespace App\Http\Requests;

use App\Helpers\Helpers;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Illuminate\Foundation\Http\FormRequest;

class ElectronicRemissionGuideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $electronicReceipstConstants = new ElectronicReceipstConstants();
        return [
            'infoTributaria' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $arrayEnvironmentType = $electronicReceipstConstants->getValidationEnvironmentType();
                if (key_exists('ambiente', $value)) {
                    if (!in_array($value['ambiente'], $arrayEnvironmentType, true))
                        $fail('Tipo de Ambiente ' . $value['ambiente'] . ' Inválido');
                } else
                    $fail('El campo ambiente es Obligatorio');

                if (key_exists('tipoEmision', $value)) {
                    if ($value['tipoEmision'] != ElectronicReceipstConstants::EMISSION_TYPE_NORMAL)
                        $fail('Tipo de Emisión ' . $value['tipoEmision'] . ' Inválido');
                } else
                    $fail('El campo tipoEmision es Obligatorio');

                if (!key_exists('razonSocial', $value))
                    $fail('El campo razonSocial es Obligatorio');
                if (!key_exists('ruc', $value))
                    $fail('El campo ruc es Obligatorio');
                if (!key_exists('estab', $value))
                    $fail('El campo estab es Obligatorio');
                if (!key_exists('ptoEmi', $value))
                    $fail('El campo ptoEmi es Obligatorio');
                if (!key_exists('secuencial', $value))
                    $fail('El campo secuencial es Obligatorio');
                if (!key_exists('dirMatriz', $value))
                    $fail('El campo dirMatriz es Obligatorio');

                if (key_exists('codDoc', $value)) {
                    $arrayElectronicReceiptTypes = $electronicReceipstConstants->getValidationElectronicReceiptTypes();
                    if (!in_array($value['codDoc'], $arrayElectronicReceiptTypes, true))
                        $fail('Codigo de Documento ' . $value['codDoc'] . ' Inválido');
                }
            }],

            'infoGuiaRemision' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                if (!key_exists('dirPartida', $value))
                    $fail('El campo dirPartida es Obligatorio');
                if (!key_exists('razonSocialTransportista', $value))
                    $fail('El campo razonSocialTransportista es Obligatorio');

                if (key_exists('tipoIdentificacionTransportista', $value)) {
                    $arrayBuyer = $electronicReceipstConstants->getValidationIdentificationBuyer();
                    if (!in_array($value['tipoIdentificacionTransportista'], $arrayBuyer, true))
                        $fail('Tipo de Identificación de Transportista ' . $value . ' Inválido');
                } else
                    $fail('El campo tipoIdentificacionTransportista es Obligatorio');

                if (!key_exists('rucTransportista', $value))
                    $fail('El campo rucTransportista es Obligatorio');
                if (!key_exists('fechaIniTransporte', $value))
                    $fail('El campo fechaIniTransporte es Obligatorio');
                if (!key_exists('fechaFinTransporte', $value))
                    $fail('El campo fechaFinTransporte es Obligatorio');
                if (!key_exists('placa', $value))
                    $fail('El campo placa es Obligatorio');
            }],

            'infoGuiaRemision.tipoIdentificacionTransportista' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $arrayBuyer = $electronicReceipstConstants->getValidationIdentificationBuyer();
                if (!in_array($value, $arrayBuyer, true))
                    $fail('Tipo de Identificación de Transportista ' . $value . ' Inválido');
            }],

            'infoGuiaRemision.rucTransportista' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $buyerQuantityChars = $electronicReceipstConstants->getValidationIdentificationBuyerMinMax('MINMAX_CHARS_' . $this->input('infoGuiaRemision.tipoIdentificacionTransportista'));
                if ($buyerQuantityChars) {
                    $lengthIdentification = mb_strlen($value);
                    $array = explode("|", $buyerQuantityChars);
                    $minLength = $array[0];
                    $maxLength = $array[1];
                    if (!($lengthIdentification >= $minLength && $lengthIdentification <= $maxLength)) {
                        $fail('Tamaño de Identificacion de Transportista No corresponde con la cantidad correcta del tipo de identificación ' . $this->input('infoGuiaRemision.tipoIdentificacionTransportista'));
                    }

                    $arrayBuyers = $electronicReceipstConstants->getValidationIdentificationBuyer();
                    $type = null;
                    foreach ($arrayBuyers as $key => $value) {
                        if ($value == $this->input('infoGuiaRemision.tipoIdentificacionTransportista')) {
                            $parts = explode("_", $key);
                            $type = end($parts);
                            $helper = new Helpers();
                            if (!$helper->validarIdentification($type, $this->input('infoGuiaRemision.rucTransportista')))
                                $fail('Número de identificación ' . $this->input('infoGuiaRemision.rucTransportista') . ' Inválido');
                        }
                    }
                }
            }],

            'destinatarios' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                foreach ($value as $destinatario) {

                    if (!key_exists('identificacionDestinatario', $destinatario))
                        $fail('El campo identificacionDestinatario es Obligatorio');
                    if (!key_exists('razonSocialDestinatario', $destinatario))
                        $fail('El campo razonSocialDestinatario es Obligatorio');
                    if (!key_exists('dirDestinatario', $destinatario))
                        $fail('El campo dirDestinatario es Obligatorio');
                    if (!key_exists('motivoTraslado', $destinatario))
                        $fail('El campo motivoTraslado es Obligatorio');

                    foreach ($destinatario['detalles'] as $detalle) {
                        if (!key_exists('descripcion', $detalle))
                            $fail('El campo descripcion es Obligatorio');
                        if (!key_exists('cantidad', $detalle))
                            $fail('El campo cantidad es Obligatorio');
                    }
                }
            }],
        ];
    }
}
