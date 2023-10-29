<?php

namespace App\Http\Requests;

use App\Helpers\Helpers;
use App\Utilities\Constants\CountryConstants;
use App\Utilities\Constants\ElectronicReceipstConstants;
use Illuminate\Foundation\Http\FormRequest;

class ElectronicRetentionReceiptRequest extends FormRequest
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
        $countriesConstants = new CountryConstants();
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

            'infoCompRetencion' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $arrayRetainedSubjectType = $electronicReceipstConstants->getValidationRetainedSubjectType();
                if (!key_exists('fechaEmision', $value))
                    $fail('El campo fechaEmision es Obligatorio');
                if (!key_exists('tipoIdentificacionSujetoRetenido', $value))
                    $fail('El campo tipoIdentificacionSujetoRetenido es Obligatorio');

                if (key_exists('tipoSujetoRetenido', $value))
                    if (!in_array($value['tipoSujetoRetenido'], $arrayRetainedSubjectType, true))
                        $fail('Tipo de Sujeto Retenido ' . $value['tipoSujetoRetenido'] . ' Inválido');

                if (!key_exists('parteRel', $value))
                    $fail('El campo parteRel es Obligatorio');
                if (!key_exists('razonSocialSujetoRetenido', $value))
                    $fail('El campo razonSocialSujetoRetenido es Obligatorio');
                if (!key_exists('identificacionSujetoRetenido', $value))
                    $fail('El campo identificacionSujetoRetenido es Obligatorio');
                if (!key_exists('periodoFiscal', $value))
                    $fail('El campo periodoFiscal es Obligatorio');
            }],

            'infoCompRetencion.tipoIdentificacionSujetoRetenido' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $arrayBuyer = $electronicReceipstConstants->getValidationIdentificationBuyer();
                if (!in_array($value, $arrayBuyer, true))
                    $fail('Tipo de Identificación de Sujeto Retenido ' . $value . ' Inválido');
            }],

            'infoCompRetencion.identificacionSujetoRetenido' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $buyerQuantityChars = $electronicReceipstConstants->getValidationIdentificationBuyerMinMax('MINMAX_CHARS_' . $this->input('infoCompRetencion.tipoIdentificacionSujetoRetenido'));
                if ($buyerQuantityChars) {
                    $lengthIdentification = mb_strlen($value);
                    $array = explode("|", $buyerQuantityChars);
                    $minLength = $array[0];
                    $maxLength = $array[1];
                    if (!($lengthIdentification >= $minLength && $lengthIdentification <= $maxLength)) {
                        $fail('Tamaño de Identificacion de Sujeto Retenido No corresponde con la cantidad correcta del tipo de identificación ' . $this->input('infoCompRetencion.tipoIdentificacionSujetoRetenido'));
                    }

                    $arrayBuyers = $electronicReceipstConstants->getValidationIdentificationBuyer();
                    $type = null;
                    foreach ($arrayBuyers as $key => $value) {
                        if ($value == $this->input('infoCompRetencion.tipoIdentificacionSujetoRetenido')) {
                            $parts = explode("_", $key);
                            $type = end($parts);
                            $helper = new Helpers();
                            if (!$helper->validarIdentification($type, $this->input('infoCompRetencion.identificacionSujetoRetenido')))
                                $fail('Número de identificación ' . $this->input('infoCompRetencion.identificacionSujetoRetenido') . ' Inválido');
                        }
                    }
                }
            }],

            'infoCompRetencion.tipoSujetoRetenido' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
                $arrayBuyer = $electronicReceipstConstants->getValidationRetainedSubjectType();
                if (!in_array($value, $arrayBuyer, true))
                    $fail('Tipo de Sujeto Retenido ' . $value . ' Inválido');
            }],

            'docsSustento' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants, $countriesConstants) {
                $arrayReceiptSupportCode = $electronicReceipstConstants->getValidationReceiptSupportCode();
                $arrayAuthorizedVoucherType = $electronicReceipstConstants->getValidationAuthorizedVoucherType();
                $arrayResidentPaymentType = $electronicReceipstConstants->getValidationResidentPaymentType();
                $arrayRegimeTaxForeignType = $electronicReceipstConstants->getValidationRegimeTaxForeignType();
                foreach ($value as $docSustento) {
                    if (key_exists('codSustento', $docSustento)) {
                        if (!in_array($docSustento['codSustento'], $arrayReceiptSupportCode, true))
                            $fail('Código de Sustento ' . $docSustento['codSustento'] . ' Inválido');
                    } else
                        $fail('El campo codSustento es Obligatorio');

                    if (key_exists('codDocSustento', $docSustento)) {
                        if (!in_array($docSustento['codDocSustento'], $arrayAuthorizedVoucherType, true))
                            $fail('Código de Documento de Sustento ' . $docSustento['codDocSustento'] . ' Inválido');
                    } else
                        $fail('El campo codDocSustento es Obligatorio');

                    if (!key_exists('fechaEmisionDocSustento', $docSustento))
                        $fail('El campo fechaEmisionDocSustento es Obligatorio');

                    if (key_exists('pagoLocExt', $docSustento)) {
                        if (!in_array($docSustento['pagoLocExt'], $arrayResidentPaymentType, true))
                            $fail('Tipo de pago Loc Ext ' . $docSustento['pagoLocExt'] . ' Inválido');
                    } else
                        $fail('El campo pagoLocExt es Obligatorio');

                    if (key_exists('tipoRegi', $docSustento))
                        if (!in_array($docSustento['tipoRegi'], $arrayRegimeTaxForeignType, true))
                            $fail('Tipo de Régimen ' . $docSustento['tipoRegi'] . ' Inválido');

                    if (!key_exists('totalSinImpuestos', $docSustento))
                        $fail('El campo totalSinImpuestos es Obligatorio');
                    if (!key_exists('importeTotal', $docSustento))
                        $fail('El campo importeTotal es Obligatorio');

                    $arrayTaxRateType = $electronicReceipstConstants->getValidationTaxRateType();
                    $arrayVat = $electronicReceipstConstants->getValidationVatType();
                    $arrayRatesIce = $electronicReceipstConstants->getValidationRatesIce();
                    foreach ($docSustento['impuestosDocSustento'] as $impuestoDocSustento) {

                        if (key_exists('codImpuestoDocSustento', $impuestoDocSustento)) {
                            if (!in_array($impuestoDocSustento['codImpuestoDocSustento'], $arrayTaxRateType, true))
                                $fail('Código de Tarífa de Impuesto ' . $impuestoDocSustento['codImpuestoDocSustento'] . ' Inválido');
                        } else
                            $fail('El campo codImpuestoDocSustento es Obligatorio');

                        if (key_exists('codigoPorcentaje', $impuestoDocSustento)) {
                            $arrayMerge = array_merge($arrayVat, $arrayRatesIce);
                            if (!in_array($impuestoDocSustento['codigoPorcentaje'], $arrayMerge, true))
                                $fail('Código de Tarífa de Impuesto ' . $impuestoDocSustento['codigoPorcentaje'] . ' Inválido');
                        } else
                            $fail('El campo codigoPorcentaje es Obligatorio');

                        if (!key_exists('baseImponible', $impuestoDocSustento))
                            $fail('El campo baseImponible es Obligatorio');
                        if (!key_exists('tarifa', $impuestoDocSustento))
                            $fail('El campo tarifa es Obligatorio');
                        if (!key_exists('valorImpuesto', $impuestoDocSustento))
                            $fail('El campo valorImpuesto es Obligatorio');
                    }

                    foreach ($docSustento['retenciones'] as $retencion) {
                        if (key_exists('codigo', $retencion)) {
                            $arrayTaxToWithHoldType = $electronicReceipstConstants->getValidationTaxToWithHoldType();
                            if (!in_array($retencion['codigo'], $arrayTaxToWithHoldType, true))
                                $fail('Código de Retención de Iva ' . $retencion['codigo'] . ' Inválido');
                        } else
                            $fail('El campo codigo es Obligatorio');

                        if (key_exists('codigoRetencion', $retencion)) {
                            $arrayVatPorcentaje = $electronicReceipstConstants->getValidationVatPorcentaje();
                            if (!in_array($retencion['codigoRetencion'], $arrayVatPorcentaje, true))
                                $fail('Código de Retención de Iva ' . $retencion['codigoRetencion'] . ' Inválido');
                        } else
                            $fail('El campo codigoRetencion es Obligatorio');

                        if (!key_exists('baseImponible', $retencion))
                            $fail('El campo baseImponible es Obligatorio');
                        if (!key_exists('porcentajeRetener', $retencion))
                            $fail('El campo porcentajeRetener es Obligatorio');
                        if (!key_exists('valorRetenido', $retencion))
                            $fail('El campo valorRetenido es Obligatorio');
                    }
                    
                    foreach ($docSustento['pagos'] as $pago) {
                        if (key_exists('formaPago', $pago)) {
                            $arrayPaymentMethodsAts = $electronicReceipstConstants->getValidationPaymentMethodsAts();
                            if (!in_array($pago['formaPago'], $arrayPaymentMethodsAts, true))
                                $fail('Tipo de Pago ' . $pago['formaPago'] . ' Inválido');
                        } else
                            $fail('El campo formaPago es Obligatorio');
                        if (!key_exists('total', $pago))
                            $fail('El campo total es Obligatorio');
                    }


                    // if ($docSustento['pagoLocExt'] == ElectronicReceipstConstants::NO_RESIDENT_PAYMENT_TYPE) {
                    //     if (key_exists('tipoRegi', $docSustento)) {
                    //         if (!in_array($docSustento['tipoRegi'], $arrayRegimeTaxForeignType, true))
                    //             $fail('Tipo de Régimen ' . $docSustento['tipoRegi'] . ' Inválido');
                    //     } else
                    //         $fail('Para el tipo de Pago Loc Ext ' . $docSustento['pagoLocExt'] . ' es obligatorio el tipo de Régimen');
                    // } else {
                    //     if (key_exists('tipoRegi', $docSustento))
                    //         if (!in_array($docSustento['tipoRegi'], $arrayRegimeTaxForeignType, true))
                    //             $fail('Tipo de Régimen ' . $docSustento['tipoRegi'] . ' Inválido');
                    // }

                    // if ($docSustento['pagoLocExt'] == ElectronicReceipstConstants::NO_RESIDENT_PAYMENT_TYPE) {
                    //     if (key_exists('tipoRegi', $docSustento)) {
                    //         if ($docSustento['tipoRegi'] == ElectronicReceipstConstants::REGIME_TAX_FOREIGN_TYPE) {
                    //             $arrayCodeCountries = $countriesConstants->getValidationCodeCountries();
                    //             if (!in_array($docSustento['paisEfecPago'], $arrayCodeCountries, true))
                    //                 $fail('Código de País ' . $docSustento['paisEfecPago'] . ' Inválido');
                    //         } else if ($docSustento['tipoRegi'] == ElectronicReceipstConstants::REGIME_TAX_FOREIGN_TYPE_TAX_HAVEN) {
                    //             $arrayCodeHavenCountries = $countriesConstants->getValidationCodeHavenCountries();
                    //             if (!in_array($docSustento['paisEfecPago'], $arrayCodeHavenCountries, true))
                    //                 $fail('Código de País ' . $docSustento['paisEfecPago'] . ' Inválido');
                    //         } else if ($docSustento['tipoRegi'] == ElectronicReceipstConstants::REGIME_TAX_FOREIGN_TYPE_TAX_REGIME) {
                    //             $arrayCodeHavenCountriesCatAts = $countriesConstants->getValidationCodeCountriesCatAts();
                    //             if (!in_array($docSustento['paisEfecPago'], $arrayCodeHavenCountriesCatAts, true))
                    //                 $fail('Código de País ' . $docSustento['paisEfecPago'] . ' Inválido');
                    //         }
                    //     } else
                    //         $fail('Para el tipo de Pago Loc Ext ' . $docSustento['pagoLocExt'] . ' es obligatorio el Código de País');
                    // }

                    // if ($docSustento['pagoLocExt'] == ElectronicReceipstConstants::NO_RESIDENT_PAYMENT_TYPE) {
                    //     if (key_exists('aplicConvDobTrib', $docSustento)) {
                    //     } else
                    //         $fail('Para el tipo de Pago Loc Ext ' . $docSustento['pagoLocExt'] . ' es obligatorio el campo aplicConvDobTrib');
                    // }
                }
            }],



            // 'docsSustento' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
            //     $arrayVat = $electronicReceipstConstants->getValidationVatType();
            //     foreach ($value as $docSustento) {
            //         foreach ($docSustento['impuestos'] as $impuesto) {
            //             if (!in_array($impuesto['codigoPorcentaje'], $arrayVat, true))
            //                 $fail('Tipo de Iva ' . $impuesto['codigoPorcentaje'] . ' Inválido');
            //         }
            //     }
            // }],



            // 'infoCompRetencion.totalConImpuestos' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
            //     $arrayVat = $electronicReceipstConstants->getValidationVatType();
            //     foreach ($value as $totalConImpuesto) {
            //         if (!in_array($totalConImpuesto['codigoPorcentaje'], $arrayVat, true))
            //             $fail('Tipo de Iva ' . $totalConImpuesto['codigoPorcentaje'] . ' Inválido');
            //     }
            // }],
            // 'infoCompRetencion.pagos' => [function ($attribute, $value, $fail) use ($electronicReceipstConstants) {
            //     $arrayPaymentMethods = $electronicReceipstConstants->getValidationPaymentMethods();
            //     foreach ($value as $pago) {
            //         if (!in_array($pago['formaPago'], $arrayPaymentMethods, true))
            //             $fail('Tipo de Pago ' . $pago['formaPago'] . ' Inválido');
            //     }
            // }],
        ];
    }
}
