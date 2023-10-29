<?php

namespace App\Http\Requests;

use App\Helpers\Helpers;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ElectronicInvoiceRequest extends FormRequest
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

            'infoFactura' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
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
                if (!key_exists('totalSinImpuestos', $value))
                    $fail('El campo totalSinImpuestos es Obligatorio');
                if (!key_exists('totalDescuento', $value))
                    $fail('El campo totalDescuento es Obligatorio');
                if (!key_exists('propina', $value))
                    $fail('El campo propina es Obligatorio');
                if (!key_exists('importeTotal', $value))
                    $fail('El campo importeTotal es Obligatorio');
            }],


            // 'infoFactura.tipoIdentificacionComprador' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
            //     $arrayBuyer = $electronicReceipstConstants->getValidationIdentificationBuyer();
            //     if (!in_array($value, $arrayBuyer, true))
            //         $fail('Tipo de Identificación de Comprador ' . $value . ' Inválido');
            // }],

            'infoFactura.identificacionComprador' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $buyerQuantityChars = $electronicReceipstConstants->getValidationIdentificationBuyerMinMax('MINMAX_CHARS_' . $this->input('infoFactura.tipoIdentificacionComprador'));
                if ($buyerQuantityChars) {
                    $lengthIdentification = mb_strlen($value);
                    $array = explode("|", $buyerQuantityChars);
                    $minLength = $array[0];
                    $maxLength = $array[1];
                    if (!($lengthIdentification >= $minLength && $lengthIdentification <= $maxLength)) {
                        $fail('Tamaño de Identificacion de Comprador No corresponde con la cantidad correcta del tipo de identificación ' . $this->input('infoFactura.tipoIdentificacionComprador'));
                    }

                    $arrayBuyers = $electronicReceipstConstants->getValidationIdentificationBuyer();
                    $type = null;
                    foreach ($arrayBuyers as $key => $value) {
                        if ($value == $this->input('infoFactura.tipoIdentificacionComprador')) {
                            $parts = explode("_", $key);
                            $type = end($parts);
                            $helper = new Helpers();
                            if (!$helper->validarIdentification($type, $this->input('infoFactura.identificacionComprador')))
                                $fail('Número de identificación ' . $this->input('infoFactura.identificacionComprador') . ' Inválido');
                        }
                    }
                }
            }],

            'infoFactura.totalConImpuestos' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $arrayVat = $electronicReceipstConstants->getValidationVatType();
                $arrayTaxRateType = $electronicReceipstConstants->getValidationTaxRateType();
                $arrayRatesIce = $electronicReceipstConstants->getValidationRatesIce();
                foreach ($value as $totalConImpuesto) {
                    if (key_exists('codigo', $totalConImpuesto)) {
                        if (!in_array($totalConImpuesto['codigo'], $arrayTaxRateType, true))
                            $fail('Código de Tarífa de Impuesto ' . $totalConImpuesto['codigo'] . ' Inválido');
                    } else
                        $fail('El campo codigo es Obligatorio');

                    if ($totalConImpuesto['codigo'] == ElectronicReceipstConstants::TAX_RATE_TYPE_ICE) {
                        if (key_exists('codigoPorcentaje', $totalConImpuesto)) {
                            if (!in_array($totalConImpuesto['codigoPorcentaje'], $arrayRatesIce, true))
                                $fail('Código de Tarífa ICE ' . $totalConImpuesto['codigoPorcentaje'] . ' Inválido');
                        } else
                            $fail('El campo Código Porcentaje es obligatorio.');
                    } else if (key_exists('codigoPorcentaje', $totalConImpuesto)) {
                        if (!in_array($totalConImpuesto['codigoPorcentaje'], $arrayVat, true))
                            $fail('Código de Tarífa de Iva ' . $totalConImpuesto['codigoPorcentaje'] . ' Inválido');
                    } else
                        $fail('El campo Código Porcentaje es obligatorio.');

                    if (!key_exists('baseImponible', $totalConImpuesto))
                        $fail('El campo baseImponible es Obligatorio');
                    if (!key_exists('valor', $totalConImpuesto))
                        $fail('El campo valor es Obligatorio');
                }
            }],



            'infoFactura.pagos' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
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

            //
            'detalles' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $arrayVat = $electronicReceipstConstants->getValidationVatType();
                $arrayTaxRateType = $electronicReceipstConstants->getValidationTaxRateType();
                $arrayRatesIce = $electronicReceipstConstants->getValidationRatesIce();
                foreach ($value as $detalle) {
                    if (!key_exists('codigoPrincipal', $detalle))
                        $fail('El campo codigoPrincipal es Obligatorio');
                    if (!key_exists('descripcion', $detalle))
                        $fail('El campo descripcion es Obligatorio');
                    if (!key_exists('cantidad', $detalle))
                        $fail('El campo cantidad es Obligatorio');
                    if (!key_exists('precioUnitario', $detalle))
                        $fail('El campo precioUnitario es Obligatorio');
                    if (!key_exists('descuento', $detalle))
                        $fail('El campo descuento es Obligatorio');
                    if (!key_exists('precioTotalSinImpuesto', $detalle))
                        $fail('El campo precioTotalSinImpuesto es Obligatorio');
                    foreach ($detalle['impuestos'] as $impuesto) {

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
                }
            }],

            'retenciones' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                foreach ($value as $retencion) {
                    if ($retencion['codigo'] == ElectronicReceipstConstants::TAX_TO_WITHHOLD) {
                        $arrayWithHoldType = $electronicReceipstConstants->getValidationWithHoldType();
                        if (!in_array($retencion['codigoPorcentaje'], $arrayWithHoldType, true))
                            $fail('Código de Retención de Iva ' . $retencion['codigoPorcentaje'] . ' Inválido');
                    } else
                        $fail('Código de Impuesto a Retener ' . $retencion['codigo'] . ' Inválido');
                }
            }],
        ];
    }
}
