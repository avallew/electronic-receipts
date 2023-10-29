<?php

namespace App\Http\Requests;

use App\Helpers\Helpers;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Illuminate\Foundation\Http\FormRequest;

class ElectronicDebitNoteRequest extends FormRequest
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

            'infoNotaDebito' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                if (!key_exists('fechaEmision', $value))
                    $fail('El campo fechaEmision es Obligatorio');

                if (key_exists('tipoIdentificacionComprador', $value)) {
                    $arrayBuyer = $electronicReceipstConstants->getValidationIdentificationBuyer();
                    if (!in_array($value['tipoIdentificacionComprador'], $arrayBuyer, true))
                        $fail('Tipo de Identificación de Comprador ' . $value . ' Inválido');
                } else
                    $fail('El campo tipoIdentificacionComprador es Obligatorio');

                if (!key_exists('razonSocialComprador', $value))
                    $fail('El campo razonSocialComprador es Obligatorio');
                if (!key_exists('identificacionComprador', $value))
                    $fail('El campo identificacionComprador es Obligatorio');

                if (key_exists('codDocModificado', $value)) {
                    $arrayElectronicReceiptTypes = $electronicReceipstConstants->getValidationElectronicReceiptTypes();
                    if (!in_array($value['codDocModificado'], $arrayElectronicReceiptTypes, true))
                        $fail('Codigo de Documento Modificado ' . $value['codDocModificado'] . ' Inválido');
                } else
                    $fail('El campo codDocModificado es Obligatorio');

                if (!key_exists('numDocModificado', $value))
                    $fail('El campo numDocModificado es Obligatorio');
                if (!key_exists('fechaEmisionDocSustento', $value))
                    $fail('El campo fechaEmisionDocSustento es Obligatorio');
                if (!key_exists('totalSinImpuestos', $value))
                    $fail('El campo totalSinImpuestos es Obligatorio');

                if (!key_exists('valorTotal', $value))
                    $fail('El campo valorTotal es Obligatorio');
            }],

            'infoNotaDebito.identificacionComprador' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $buyerQuantityChars = $electronicReceipstConstants->getValidationIdentificationBuyerMinMax('MINMAX_CHARS_' . $this->input('infoNotaDebito.tipoIdentificacionComprador'));
                if ($buyerQuantityChars) {
                    $lengthIdentification = mb_strlen($value);
                    $array = explode("|", $buyerQuantityChars);
                    $minLength = $array[0];
                    $maxLength = $array[1];
                    if (!($lengthIdentification >= $minLength && $lengthIdentification <= $maxLength)) {
                        $fail('Tamaño de Identificacion de Comprador No corresponde con la cantidad correcta del tipo de identificación ' . $this->input('infoNotaDebito.tipoIdentificacionComprador'));
                    }

                    $arrayBuyers = $electronicReceipstConstants->getValidationIdentificationBuyer();
                    $type = null;
                    foreach ($arrayBuyers as $key => $value) {
                        if ($value == $this->input('infoNotaDebito.tipoIdentificacionComprador')) {
                            $parts = explode("_", $key);
                            $type = end($parts);
                            $helper = new Helpers();
                            if (!$helper->validarIdentification($type, $this->input('infoNotaDebito.identificacionComprador')))
                                $fail('Número de identificación ' . $this->input('infoNotaDebito.identificacionComprador') . ' Inválido');
                        }
                    }
                }
            }],

            'infoNotaDebito.impuestos' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $arrayVat = $electronicReceipstConstants->getValidationVatType();
                $arrayTaxRateType = $electronicReceipstConstants->getValidationTaxRateType();
                $arrayRatesIce = $electronicReceipstConstants->getValidationRatesIce();
                foreach ($value as $impuesto) {
                    if (key_exists('codigo', $impuesto)) {
                        if (!in_array($impuesto['codigo'], $arrayTaxRateType, true))
                            $fail('Código de Tarífa de Impuesto ' . $impuesto['codigo'] . ' Inválido');
                    } else
                        $fail('El campo codigo es Obligatorio');

                    if ($impuesto['codigo'] == ElectronicReceipstConstants::TAX_RATE_TYPE_ICE) {
                        if (key_exists('codigoPorcentaje', $impuesto)) {
                            if (!in_array($impuesto['codigoPorcentaje'], $arrayRatesIce, true))
                                $fail('Código de Tarífa ICE ' . $impuesto['codigoPorcentaje'] . ' Inválido');
                        } else
                            $fail('El campo Código Porcentaje es obligatorio.');
                    } else if (key_exists('codigoPorcentaje', $impuesto)) {
                        if (!in_array($impuesto['codigoPorcentaje'], $arrayVat, true))
                            $fail('Código de Tarífa de Iva ' . $impuesto['codigoPorcentaje'] . ' Inválido');
                    } else
                        $fail('El campo Código Porcentaje es obligatorio.');

                    if (!key_exists('tarifa', $impuesto))
                        $fail('El campo tarifa es Obligatorio');
                    if (!key_exists('baseImponible', $impuesto))
                        $fail('El campo baseImponible es Obligatorio');
                    if (!key_exists('valor', $impuesto))
                        $fail('El campo valor es Obligatorio');
                }
            }],

            'infoNotaDebito.pagos' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $arrayPaymentMethods = $electronicReceipstConstants->getValidationPaymentMethods();
                foreach ($value as $pago) {
                    if (key_exists('formaPago', $pago)) {
                        if (!in_array($pago['formaPago'], $arrayPaymentMethods, true))
                            $fail('Tipo de Pago ' . $pago['formaPago'] . ' Inválido');
                    } else
                        $fail('El campo formaPago es Obligatorio');
                    if (!key_exists('total', $pago))
                        $fail('El campo total es Obligatorio');
                }
            }],

            'motivos' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                foreach ($value as $motivo) {
                    if (!key_exists('razon', $motivo))
                        $fail('El campo razon es Obligatorio');
                    if (!key_exists('valor', $motivo))
                        $fail('El campo valor es Obligatorio');
                }
            }],
        ];
    }
}
