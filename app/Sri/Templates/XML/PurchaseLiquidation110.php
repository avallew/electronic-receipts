<?php

namespace App\SRI\Templates\XML;

// require(dirname(__FILE__) . '/hacienda/firmador.php');

use App\Firmador\Firmador;
use App\Sri\Endpoints\EndPoints;
use Spatie\ArrayToXml\ArrayToXml;

class PurchaseLiquidation110
{
    public $infoTributaria;
    public $infoLiquidacionCompra;
    public $detalles;
    public $reembolsos;
    public $maquinaFiscal;
    public $infoAdicional;

    public $purchaseLiquidation = [];

    public function liquidacionCompra()
    {
        $this->purchaseLiquidation['infoTributaria'] = $this->infoTributariaToArray();
        $this->purchaseLiquidation['infoLiquidacionCompra'] = $this->infoLiquidacionCompraToArray();
        $this->purchaseLiquidation['detalles'] = $this->detallesToArray();
        if ($this->reembolsos != null)
            $this->purchaseLiquidation['reembolsos'] = $this->reembolsosToArray();
        if ($this->maquinaFiscal != null)
            $this->purchaseLiquidation['maquinaFiscal'] = $this->maquinaFiscalToArray();
        if ($this->infoAdicional != null)
            $this->purchaseLiquidation['infoAdicional'] = $this->infoAdicionalToArray();

        return $this->purchaseLiquidation;
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

    public function infoLiquidacionCompraToArray()
    {
        $infoFacturaArray = [];
        $infoFacturaArray['fechaEmision'] = $this->infoLiquidacionCompra['fechaEmision'];
        if (array_key_exists('dirEstablecimiento', $this->infoLiquidacionCompra))
            $infoFacturaArray['dirEstablecimiento'] = $this->infoLiquidacionCompra['dirEstablecimiento'];
        if (array_key_exists('contribuyenteEspecial', $this->infoLiquidacionCompra))
            $infoFacturaArray['contribuyenteEspecial'] = $this->infoLiquidacionCompra['contribuyenteEspecial'];
        if (array_key_exists('obligadoContabilidad', $this->infoLiquidacionCompra))
            $infoFacturaArray['obligadoContabilidad'] = $this->infoLiquidacionCompra['obligadoContabilidad'];
        $infoFacturaArray['tipoIdentificacionProveedor'] = $this->infoLiquidacionCompra['tipoIdentificacionProveedor'];
        $infoFacturaArray['razonSocialProveedor'] = $this->infoLiquidacionCompra['razonSocialProveedor'];
        $infoFacturaArray['identificacionProveedor'] = $this->infoLiquidacionCompra['identificacionProveedor'];
        if (array_key_exists('direccionProveedor', $this->infoLiquidacionCompra))
            $infoFacturaArray['direccionProveedor'] = $this->infoLiquidacionCompra['direccionProveedor'];
        $infoFacturaArray['totalSinImpuestos'] = $this->infoLiquidacionCompra['totalSinImpuestos'];
        if (array_key_exists('totalDescuento', $this->infoLiquidacionCompra))
            $infoFacturaArray['totalDescuento'] = $this->infoLiquidacionCompra['totalDescuento'];
        if (array_key_exists('codDocReembolso', $this->infoLiquidacionCompra))
            $infoFacturaArray['codDocReembolso'] = $this->infoLiquidacionCompra['codDocReembolso'];
        if (array_key_exists('totalComprobantesReembolso', $this->infoLiquidacionCompra))
            $infoFacturaArray['totalComprobantesReembolso'] = $this->infoLiquidacionCompra['totalComprobantesReembolso'];
        if (array_key_exists('totalBaseImponibleReembolso', $this->infoLiquidacionCompra))
            $infoFacturaArray['totalBaseImponibleReembolso'] = $this->infoLiquidacionCompra['totalBaseImponibleReembolso'];
        if (array_key_exists('totalImpuestoReembolso', $this->infoLiquidacionCompra))
            $infoFacturaArray['totalImpuestoReembolso'] = $this->infoLiquidacionCompra['totalImpuestoReembolso'];

        $infoFacturaArray['totalConImpuestos'] = $this->totalConImpuestosToArray($this->infoLiquidacionCompra['totalConImpuestos']);

        $infoFacturaArray['importeTotal'] = $this->infoLiquidacionCompra['importeTotal'];
        $infoFacturaArray['moneda'] = $this->infoLiquidacionCompra['moneda'];
        $infoFacturaArray['pagos'] = $this->pagosToArray($this->infoLiquidacionCompra['pagos']);
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
            if (array_key_exists('tarifa', $totalConImpuesto))
                $data['tarifa'] = $totalConImpuesto['tarifa'];
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
            if (array_key_exists('unidadMedida', $detalle))
                $detalleArray['unidadMedida'] = $detalle['unidadMedida'];
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

    public function reembolsosToArray()
    {
        $reembolsosArray = [];
        foreach ($this->reembolsos as $reembolso) {
            $data = [];
            $data['tipoIdentificacionProveedorReembolso'] = $reembolso['tipoIdentificacionProveedorReembolso'];
            $data['identificacionProveedorReembolso'] = $reembolso['identificacionProveedorReembolso'];
            $data['codPaisPagoProveedorReembolso'] = $reembolso['codPaisPagoProveedorReembolso'];
            $data['tipoProveedorReembolso'] = $reembolso['tipoProveedorReembolso'];
            $data['codDocReembolso'] = $reembolso['codDocReembolso'];
            $data['estabDocReembolso'] = $reembolso['estabDocReembolso'];
            $data['ptoEmiDocReembolso'] = $reembolso['ptoEmiDocReembolso'];
            $data['secuencialDocReembolso'] = $reembolso['secuencialDocReembolso'];
            $data['fechaEmisionDocReembolso'] = $reembolso['fechaEmisionDocReembolso'];
            $data['numeroautorizacionDocReemb'] = $reembolso['numeroautorizacionDocReemb'];
            $data['detalleImpuestos'] = $this->detalleImpuestosToArray($reembolso['detalleImpuestos']);
            $reembolsosArray['reembolsoDetalle'][] = $data;
        }
        return $reembolsosArray;
    }

    public function detalleImpuestosToArray($detalleImpuestos)
    {
        $detalleImpuestoArray = [];
        foreach ($detalleImpuestos as $detalleImpuesto) {
            $data = [];
            $data['codigo'] = $detalleImpuesto['codigo'];
            $data['codigoPorcentaje'] = $detalleImpuesto['codigoPorcentaje'];
            $data['tarifa'] = $detalleImpuesto['tarifa'];
            $data['baseImponibleReembolso'] = $detalleImpuesto['baseImponibleReembolso'];
            $data['impuestoReembolso'] = $detalleImpuesto['impuestoReembolso'];
            $detalleImpuestoArray['detalleImpuesto'][] = $data;
            return $detalleImpuestoArray;
        }
    }

    public function maquinaFiscalToArray()
    {
        $maquinaFiscalArray = [];
        $maquinaFiscalArray['marca'] = $this->maquinaFiscal['marca'];
        $maquinaFiscalArray['modelo'] = $this->maquinaFiscal['modelo'];
        $maquinaFiscalArray['serie'] = $this->maquinaFiscal['serie'];
        return $maquinaFiscalArray;
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
