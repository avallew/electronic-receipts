<?php

namespace App\SRI\Templates\XML;

use App\Helpers\Helpers;

class Invoice110
{
    public $infoTributaria;
    public $infoFactura;
    public $detalles;
    public $retenciones;
    public $infoAdicional;

    public $factura = [];

    public function factura()
    {
        $this->factura['infoTributaria'] = $this->infoTributariaToArray();
        $this->factura['infoFactura'] = $this->infoFacturaToArray();
        $this->factura['detalles'] = $this->detallesToArray();
        if ($this->retenciones != null)
            $this->factura['retenciones'] = $this->retencionesToArray();
        if ($this->infoAdicional != null)
            $this->factura['infoAdicional'] = $this->infoAdicionalToArray();
        return $this->factura;
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

    public function infoFacturaToArray()
    {
        $infoFacturaArray = [];
        $infoFacturaArray['fechaEmision'] = $this->infoFactura['fechaEmision'];

        if (array_key_exists('dirEstablecimiento', $this->infoFactura)) {

            $validate = new Helpers();
            $srtingValidated = $validate->validateString($this->infoFactura['dirEstablecimiento'], 300);
            $infoFacturaArray['dirEstablecimiento'] = $srtingValidated;
        }
        if (array_key_exists('contribuyenteEspecial', $this->infoFactura))
            $infoFacturaArray['contribuyenteEspecial'] = $this->infoFactura['contribuyenteEspecial'];
        if (array_key_exists('obligadoContabilidad', $this->infoFactura))
            $infoFacturaArray['obligadoContabilidad'] = $this->infoFactura['obligadoContabilidad'];
        $infoFacturaArray['tipoIdentificacionComprador'] = $this->infoFactura['tipoIdentificacionComprador'];
        if (array_key_exists('guiaRemision', $this->infoFactura))
            $infoFacturaArray['guiaRemision'] = $this->infoFactura['guiaRemision'];
        $infoFacturaArray['razonSocialComprador'] = $this->infoFactura['razonSocialComprador'];
        $infoFacturaArray['identificacionComprador'] = $this->infoFactura['identificacionComprador'];
        if (array_key_exists('direccionComprador', $this->infoFactura))
            $infoFacturaArray['direccionComprador'] = $this->infoFactura['direccionComprador'];
        $infoFacturaArray['totalSinImpuestos'] = $this->infoFactura['totalSinImpuestos'];
        $infoFacturaArray['totalDescuento'] = $this->infoFactura['totalDescuento'];
        $infoFacturaArray['totalConImpuestos'] = $this->totalConImpuestosToArray($this->infoFactura['totalConImpuestos']);
        $infoFacturaArray['propina'] = $this->infoFactura['propina'];
        $infoFacturaArray['importeTotal'] = $this->infoFactura['importeTotal'];
        if (array_key_exists('moneda', $this->infoFactura))
            $infoFacturaArray['moneda'] = $this->infoFactura['moneda'];
        $infoFacturaArray['pagos'] = $this->pagosToArray($this->infoFactura['pagos']);
        if (array_key_exists('valorRetIva', $this->infoFactura))
            $infoFacturaArray['valorRetIva'] = $this->infoFactura['valorRetIva'];
        if (array_key_exists('valorRetRenta', $this->infoFactura))
            $infoFacturaArray['valorRetRenta'] = $this->infoFactura['valorRetRenta'];
        return $infoFacturaArray;
    }

    public function totalConImpuestosToArray($totalConImpuestos)
    {
        $totalConImpuestosArray = [];
        foreach ($totalConImpuestos as $totalConImpuesto) {
            $data = [];
            $data['codigo'] = $totalConImpuesto['codigo'];
            $data['codigoPorcentaje']  = $totalConImpuesto['codigoPorcentaje'];
            if (array_key_exists('descuentoAdicional', $totalConImpuesto))
                $data['descuentoAdicional'] =  $totalConImpuesto['descuentoAdicional'];
            $data['baseImponible'] =  $totalConImpuesto['baseImponible'];
            $data['valor'] = $totalConImpuesto['valor'];
            $totalConImpuestosArray['totalImpuesto'][] = $data;
        }
        return $totalConImpuestosArray;
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

    public function detallesToArray()
    {
        $detalles = [];
        foreach ($this->detalles as $detalle) {
            $detalleArray = [];
            $detalleArray['codigoPrincipal'] = $detalle['codigoPrincipal'];
            if (array_key_exists('codigoAuxiliar', $detalle))
                $detalleArray['codigoAuxiliar'] = $detalle['codigoAuxiliar'];
            $detalleArray['descripcion'] = $detalle['descripcion'];
            $detalleArray['cantidad'] = $detalle['cantidad'];
            $detalleArray['precioUnitario'] = $detalle['precioUnitario'];
            $detalleArray['descuento'] = $detalle['descuento'];
            $detalleArray['precioTotalSinImpuesto'] = $detalle['precioTotalSinImpuesto'];
            if (array_key_exists('detallesAdicionales', $detalle))
                $detalleArray['detallesAdicionales'] = $this->detallesAdicionalesToArray($detalle['detallesAdicionales']);
            $detalleArray['impuestos'] = $this->impuestosToArray($detalle['impuestos']);
            $detalles['detalle'][] = $detalleArray;
        }
        return $detalles;
    }

    public function retencionesToArray()
    {
        $retenciones = [];
        foreach ($this->retenciones as $retencion) {
            $retencionesArray = [];
            $retencionesArray['codigo'] = $retencion['codigo'];
            $retencionesArray['codigoPorcentaje'] = $retencion['codigoPorcentaje'];
            $retencionesArray['tarifa'] = $retencion['tarifa'];
            $retencionesArray['valor'] = $retencion['valor'];
            $retenciones['retencion'][] = $retencionesArray;
        }
        return $retenciones;
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

    public function impuestosToArray($impuestos)
    {
        $impuestoss = [];
        foreach ($impuestos as $impuesto) {
            $impuestosArray = [];
            $impuestosArray['codigo'] = $impuesto['codigo'];
            $impuestosArray['codigoPorcentaje'] = $impuesto['codigoPorcentaje'];
            $impuestosArray['tarifa'] = $impuesto['tarifa'];
            $impuestosArray['baseImponible'] = $impuesto['baseImponible'];
            $impuestosArray['valor'] = $impuesto['valor'];
            $impuestoss['impuesto'][] = $impuestosArray;
        }
        return $impuestoss;
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
