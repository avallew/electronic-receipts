<?php

namespace App\SRI\Templates\XML;

use App\Firmador\Firmador;
use App\Sri\Endpoints\EndPoints;
use Spatie\ArrayToXml\ArrayToXml;

class DebitNote100
{
    public $infoTributaria;
    public $infoNotaDebito;
    public $motivos;
    public $infoAdicional;

    public $notaDebito = [];

    public function notaDebito()
    {
        $this->notaDebito['infoTributaria'] = $this->infoTributariaToArray();
        $this->notaDebito['infoNotaDebito'] = $this->infoNotaDebitoToArray();
        $this->notaDebito['motivos'] = $this->motivosToArray();
        if ($this->infoAdicional != null)
            $this->notaDebito['infoAdicional'] = $this->infoAdicionalToArray();
        return $this->notaDebito;
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

    public function infoNotaDebitoToArray()
    {
        $infoNotaDebitoArray = [];
        $infoNotaDebitoArray['fechaEmision'] = $this->infoNotaDebito['fechaEmision'];
        if (array_key_exists('dirEstablecimiento', $this->infoNotaDebito))
            $infoNotaDebitoArray['dirEstablecimiento'] = $this->infoNotaDebito['dirEstablecimiento'];
        $infoNotaDebitoArray['tipoIdentificacionComprador'] = $this->infoNotaDebito['tipoIdentificacionComprador'];
        $infoNotaDebitoArray['razonSocialComprador'] = $this->infoNotaDebito['razonSocialComprador'];
        $infoNotaDebitoArray['identificacionComprador'] = $this->infoNotaDebito['identificacionComprador'];
        if (array_key_exists('contribuyenteEspecial', $this->infoNotaDebito))
            $infoNotaDebitoArray['contribuyenteEspecial'] = $this->infoNotaDebito['contribuyenteEspecial'];
        if (array_key_exists('obligadoContabilidad', $this->infoNotaDebito))
            $infoNotaDebitoArray['obligadoContabilidad'] = $this->infoNotaDebito['obligadoContabilidad'];
        $infoNotaDebitoArray['codDocModificado'] = $this->infoNotaDebito['codDocModificado'];
        $infoNotaDebitoArray['numDocModificado'] = $this->infoNotaDebito['numDocModificado'];
        $infoNotaDebitoArray['fechaEmisionDocSustento'] = $this->infoNotaDebito['fechaEmisionDocSustento'];
        $infoNotaDebitoArray['totalSinImpuestos'] = $this->infoNotaDebito['totalSinImpuestos'];

        $infoNotaDebitoArray['impuestos'] = $this->impuestosToArray($this->infoNotaDebito['impuestos']);
        $infoNotaDebitoArray['valorTotal'] = $this->infoNotaDebito['valorTotal'];
        $infoNotaDebitoArray['pagos'] = $this->pagosToArray($this->infoNotaDebito['pagos']);

        return $infoNotaDebitoArray;
    }

    public function pagosToArray($pagos)
    {
        $pagosArray = [];
        foreach ($pagos as $pago) {
            $data = [];
            $data['formaPago'] = $pago['formaPago'];
            $data['total'] = $pago['total'];
            if (array_key_exists('plazo', $pago))
                $data['plazo'] = $pago['plazo'];
            if (array_key_exists('unidadTiempo', $pago))
                $data['unidadTiempo'] = $pago['unidadTiempo'];
            $pagosArray['pago'][] = $data;
        }
        return $pagosArray;
    }

    public function impuestosToArray($impuestos)
    {
        $impuestosArray = [];
        foreach ($impuestos as $impuesto) {
            $data = [];
            $data['codigo'] = $impuesto['codigo'];
            $data['codigoPorcentaje'] = $impuesto['codigoPorcentaje'];
            $data['tarifa'] = $impuesto['tarifa'];
            $data['baseImponible'] = $impuesto['baseImponible'];
            $data['valor'] = $impuesto['valor'];
            $impuestosArray['impuesto'][] = $data;
        }
        return $impuestosArray;
    }

    public function motivosToArray()
    {
        $motiviosArray = [];
        if ($this->motivos) {
            foreach ($this->motivos as $motivo) {
                $data = [];
                $data['razon'] = $motivo['razon'];
                $data['valor'] = $motivo['valor'];
                $motiviosArray['motivo'][] = $data;
            }
        }
        return $motiviosArray;
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
