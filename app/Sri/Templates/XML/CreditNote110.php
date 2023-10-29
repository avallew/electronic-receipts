<?php

namespace App\SRI\Templates\XML;

class CreditNote110
{
    public $infoTributaria;
    public $infoNotaCredito;
    public $detalles;
    public $infoAdicional;

    public $notaCredito = [];

    public $signPath;
    public $signKey;

    public function notaCredito()
    {
        $this->notaCredito['infoTributaria'] = $this->infoTributariaToArray();
        $this->notaCredito['infoNotaCredito'] = $this->infoNotaCreditoToArray();
        $this->notaCredito['detalles'] = $this->detallesToArray();
        if ($this->infoAdicional != null)
            $this->notaCredito['infoAdicional'] = $this->infoAdicionalToArray();

        return $this->notaCredito;
    }

    public function infoTributariaToArray()
    {
        $infoTributariaArray = [];
        $infoTributariaArray['ambiente'] = $this->infoTributaria['ambiente'];
        $infoTributariaArray['tipoEmision'] = $this->infoTributaria['tipoEmision'];
        $infoTributariaArray['razonSocial'] = $this->infoTributaria['razonSocial'];
        if (array_key_exists('nombreComercial', $this->infoTributaria))
            $infoTributariaArray['nombreComercial'] = $this->infoTributaria['nombreComercial'];
        $infoTributariaArray['ruc'] = $this->infoTributaria['ruc'];
        $infoTributariaArray['claveAcceso'] = $this->infoTributaria['claveAcceso'];
        $infoTributariaArray['codDoc'] = $this->infoTributaria['codDoc'];
        $infoTributariaArray['estab'] = $this->infoTributaria['estab'];
        $infoTributariaArray['ptoEmi'] = $this->infoTributaria['ptoEmi'];
        $infoTributariaArray['secuencial'] = $this->infoTributaria['secuencial'];
        $infoTributariaArray['dirMatriz'] = $this->infoTributaria['dirMatriz'];
        if (array_key_exists('contribuyenteRimpe', $this->infoTributaria))
            $infoTributariaArray['contribuyenteRimpe'] = $this->infoTributaria['contribuyenteRimpe'];
        if (array_key_exists('agenteRetencion', $this->infoTributaria))
            $infoTributariaArray['agenteRetencion'] = $this->infoTributaria['agenteRetencion'];
        return $infoTributariaArray;
    }

    public function infoNotaCreditoToArray()
    {
        $infoNotaDebitoArray = [];
        $infoNotaDebitoArray['fechaEmision'] = $this->infoNotaCredito['fechaEmision'];
        if (array_key_exists('dirEstablecimiento', $this->infoNotaCredito))
            $infoNotaDebitoArray['dirEstablecimiento'] = $this->infoNotaCredito['dirEstablecimiento'];
        $infoNotaDebitoArray['tipoIdentificacionComprador'] = $this->infoNotaCredito['tipoIdentificacionComprador'];
        $infoNotaDebitoArray['razonSocialComprador'] = $this->infoNotaCredito['razonSocialComprador'];
        $infoNotaDebitoArray['identificacionComprador'] = $this->infoNotaCredito['identificacionComprador'];
        if (array_key_exists('contribuyenteEspecial', $this->infoNotaCredito))
            $infoNotaDebitoArray['contribuyenteEspecial'] = $this->infoNotaCredito['contribuyenteEspecial'];
        if (array_key_exists('obligadoContabilidad', $this->infoNotaCredito))
            $infoNotaDebitoArray['obligadoContabilidad'] = $this->infoNotaCredito['obligadoContabilidad'];
        if (array_key_exists('rise', $this->infoNotaCredito))
            $infoNotaDebitoArray['rise'] = $this->infoNotaCredito['rise'];
        $infoNotaDebitoArray['codDocModificado'] = $this->infoNotaCredito['codDocModificado'];
        if (array_key_exists('numDocModificado', $this->infoNotaCredito))
            $infoNotaDebitoArray['numDocModificado'] = $this->infoNotaCredito['numDocModificado'];
        $infoNotaDebitoArray['fechaEmisionDocSustento'] = $this->infoNotaCredito['fechaEmisionDocSustento'];
        $infoNotaDebitoArray['totalSinImpuestos'] = $this->infoNotaCredito['totalSinImpuestos'];
        $infoNotaDebitoArray['valorModificacion'] = $this->infoNotaCredito['valorModificacion'];
        if (array_key_exists('moneda', $this->infoNotaCredito))
            $infoNotaDebitoArray['moneda'] = $this->infoNotaCredito['moneda'];
        $infoNotaDebitoArray['totalConImpuestos'] = $this->totalConImpuestosToArray($this->infoNotaCredito['totalConImpuestos']);
        $infoNotaDebitoArray['motivo'] = $this->infoNotaCredito['motivo'];

        return $infoNotaDebitoArray;
    }

    public function totalConImpuestosToArray($totalConImpuestos)
    {
        $totalConImpuestosArray = [];
        foreach ($totalConImpuestos as $totalConImpuesto) {
            $data = [];
            $data['codigo'] = $totalConImpuesto['codigo'];
            $data['codigoPorcentaje']  = $totalConImpuesto['codigoPorcentaje'];
            $data['baseImponible'] =  $totalConImpuesto['baseImponible'];
            $data['valor'] = $totalConImpuesto['valor'];
            $totalConImpuestosArray['totalImpuesto'][] = $data;
        }
        return $totalConImpuestosArray;
    }

    public function detallesToArray()
    {
        $detalles = [];
        foreach ($this->detalles as $detalle) {
            $detalleArray = [];
            if (array_key_exists('codigoInterno', $detalle))
                $detalleArray['codigoInterno'] = $detalle['codigoInterno'];
            if (array_key_exists('codigoAdicional', $detalle))
                $detalleArray['codigoAdicional'] = $detalle['codigoAdicional'];
            $detalleArray['descripcion'] = $detalle['descripcion'];
            $detalleArray['cantidad'] = $detalle['cantidad'];
            $detalleArray['precioUnitario'] = $detalle['precioUnitario'];
            if (array_key_exists('descuento', $detalle))
                $detalleArray['descuento'] = $detalle['descuento'];
            $detalleArray['precioTotalSinImpuesto'] = $detalle['precioTotalSinImpuesto'];
            if (array_key_exists('detallesAdicionales', $detalle))
                $detalleArray['detallesAdicionales'] = $this->detallesAdicionalesToArray($detalle['detallesAdicionales']);
            $detalleArray['impuestos'] = $this->impuestosToArray($detalle['impuestos']);
            $detalles['detalle'][] = $detalleArray;
        }
        return $detalles;
    }

    public function impuestosToArray($impuestos)
    {
        $impuestosArray = [];
        foreach ($impuestos as $impuesto) {
            $data = [];
            $data['codigo'] = $impuesto['codigo'];
            $data['codigoPorcentaje'] = $impuesto['codigoPorcentaje'];
            if (array_key_exists('tarifa', $impuesto))
                $data['tarifa'] = $impuesto['tarifa'];
            $data['baseImponible'] = $impuesto['baseImponible'];
            $data['valor'] = $impuesto['valor'];
            $impuestosArray['impuesto'][] = $data;
        }
        return $impuestosArray;
    }

    public function infoAdicionalToArray()
    {
        $infoAdicionalArray = [];
        if ($this->infoAdicional) {
            foreach ($this->infoAdicional as $campoAdicional) {
                $infoAdicionalArray['campoAdicional'][] =
                    $this->_attributesArray($campoAdicional) + $this->_valueArray($campoAdicional);
            }
        }
        return $infoAdicionalArray;
    }

    public function detallesAdicionalesToArray($detallesAdicionales)
    {
        $detAdicionalArray = [];
        foreach ($detallesAdicionales as $detAdicional) {
            $detAdicionalArray['detAdicional'][] = $this->_attributesArray($detAdicional);
        }
        return $detAdicionalArray;
    }

    public function _attributesArray($detAdicional)
    {
        $_attributesArray = [];
        $_attributesArray['_attributes'] = $this->attsArray($detAdicional);
        return $_attributesArray;
    }

    public function attsArray($detAdicional)
    {
        $attsArray = [];
        $attsArray['nombre'] = $detAdicional['nombre'];
        if (array_key_exists('valor', $detAdicional))
            $attsArray['valor'] = $detAdicional['valor'];
        return $attsArray;
    }

    public function _valueArray($campoAdicional)
    {
        $_valueArray = [];
        $_valueArray['_value'] = $campoAdicional['value'];
        return $_valueArray;
    }
}
