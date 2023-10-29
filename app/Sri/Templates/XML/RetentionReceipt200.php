<?php

namespace App\SRI\Templates\XML;

use App\Firmador\Firmador;
use App\Sri\Endpoints\EndPoints;
use Spatie\ArrayToXml\ArrayToXml;

class RetentionReceipt200
{
    public $infoTributaria;
    public $infoCompRetencion;
    public $docsSustento;
    public $infoAdicional;

    public $compRetencion = [];

    public function comprobanteRetencion()
    {
        $this->compRetencion['infoTributaria'] = $this->infoTributariaToArray();
        $this->compRetencion['infoCompRetencion'] = $this->infoCompRetencionToArray();
        $this->compRetencion['docsSustento'] = $this->docsSustentoToArray();
        if ($this->infoAdicional != null)
            $this->compRetencion['infoAdicional'] = $this->infoAdicionalToArray();
        return $this->compRetencion;
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

    public function infoCompRetencionToArray()
    {
        $infoCompRetencionArray = [];
        $infoCompRetencionArray['fechaEmision'] = $this->infoCompRetencion['fechaEmision'];
        if (array_key_exists('dirEstablecimiento', $this->infoCompRetencion))
            $infoCompRetencionArray['dirEstablecimiento'] = $this->infoCompRetencion['dirEstablecimiento'];
        if (array_key_exists('contribuyenteEspecial', $this->infoCompRetencion))
            $infoCompRetencionArray['contribuyenteEspecial'] = $this->infoCompRetencion['contribuyenteEspecial'];
        if (array_key_exists('obligadoContabilidad', $this->infoCompRetencion))
            $infoCompRetencionArray['obligadoContabilidad'] = $this->infoCompRetencion['obligadoContabilidad'];
        $infoCompRetencionArray['tipoIdentificacionSujetoRetenido'] = $this->infoCompRetencion['tipoIdentificacionSujetoRetenido'];
        $infoCompRetencionArray['tipoSujetoRetenido'] = $this->infoCompRetencion['tipoSujetoRetenido'];
        $infoCompRetencionArray['parteRel'] = $this->infoCompRetencion['parteRel'];
        $infoCompRetencionArray['razonSocialSujetoRetenido'] = $this->infoCompRetencion['razonSocialSujetoRetenido'];
        $infoCompRetencionArray['identificacionSujetoRetenido'] = $this->infoCompRetencion['identificacionSujetoRetenido'];
        $infoCompRetencionArray['periodoFiscal'] = $this->infoCompRetencion['periodoFiscal'];
        return $infoCompRetencionArray;
    }

    public function docsSustentoToArray()
    {
        foreach ($this->docsSustento as $docSustento) {
            $docSustentoArray = [];
            $docSustentoArray['codSustento'] = $docSustento['codSustento'];
            $docSustentoArray['codDocSustento'] = $docSustento['codDocSustento'];
            if (array_key_exists('numDocSustento', $docSustento))
                $docSustentoArray['numDocSustento'] = $docSustento['numDocSustento'];
            $docSustentoArray['fechaEmisionDocSustento'] = $docSustento['fechaEmisionDocSustento'];
            if (array_key_exists('fechaRegistroContable', $docSustento))
                $docSustentoArray['fechaRegistroContable'] = $docSustento['fechaRegistroContable'];
            if (array_key_exists('numAutDocSustento', $docSustento))
                $docSustentoArray['numAutDocSustento'] = $docSustento['numAutDocSustento'];
            $docSustentoArray['pagoLocExt'] = $docSustento['pagoLocExt'];
            $docSustentoArray['tipoRegi'] = $docSustento['tipoRegi'];
            $docSustentoArray['paisEfecPago'] = $docSustento['paisEfecPago'];
            $docSustentoArray['aplicConvDobTrib'] = $docSustento['aplicConvDobTrib'];
            $docSustentoArray['pagExtSujRetNorLeg'] = $docSustento['pagExtSujRetNorLeg'];
            $docSustentoArray['pagoRegFis'] = $docSustento['pagoRegFis'];
            $docSustentoArray['totalComprobantesReembolso'] = $docSustento['totalComprobantesReembolso'];
            $docSustentoArray['totalBaseImponibleReembolso'] = $docSustento['totalBaseImponibleReembolso'];
            $docSustentoArray['totalImpuestoReembolso'] = $docSustento['totalImpuestoReembolso'];
            $docSustentoArray['totalSinImpuestos'] = $docSustento['totalSinImpuestos'];
            $docSustentoArray['importeTotal'] = $docSustento['importeTotal'];

            $docSustentoArray['impuestosDocSustento'] = $this->impuestosDocSustentoToArray($docSustento['impuestosDocSustento']);
            $docSustentoArray['retenciones'] = $this->retencionesToArray($docSustento['retenciones']);
            $docSustentoArray['reembolsos'] = $this->reembolsosToArray($docSustento['reembolsos']);
            $docSustentoArray['pagos'] = $this->pagosToArray($docSustento['pagos']);

            $docsSustentoArray['docSustento'][] = $docSustentoArray;
        }
        return $docsSustentoArray;
    }

    public function impuestosDocSustentoToArray($impuestosDocSustento)
    {
        $impuestosDocSustentoArray = [];
        foreach ($impuestosDocSustento as $impuestoDocSustento) {
            $data = [];
            $data['codImpuestoDocSustento'] = $impuestoDocSustento['codImpuestoDocSustento'];
            $data['codigoPorcentaje'] = $impuestoDocSustento['codigoPorcentaje'];
            $data['baseImponible'] = $impuestoDocSustento['baseImponible'];
            $data['tarifa'] = $impuestoDocSustento['tarifa'];
            $data['valorImpuesto'] = $impuestoDocSustento['valorImpuesto'];
            $impuestosDocSustentoArray['impuestoDocSustento'][] = $data;
            return $impuestosDocSustentoArray;
        }
    }

    public function retencionesToArray($retenciones)
    {
        $retencionesArray = [];
        foreach ($retenciones as $retencion) {
            $data = [];
            $data['codigo'] = $retencion['codigo'];
            $data['codigoRetencion'] = $retencion['codigoRetencion'];
            $data['baseImponible'] = $retencion['baseImponible'];
            $data['porcentajeRetener'] = $retencion['porcentajeRetener'];
            $data['valorRetenido'] = $retencion['valorRetenido'];
            if (array_key_exists('dividendos', $retencion))
                $data['dividendos'] = $this->dividendosToArray($retencion['dividendos']);
            $retencionesArray['retencion'][] = $data;
        }
        return $retencionesArray;
    }

    public function dividendosToArray($dividendos)
    {
        $dividendosArray = [];
        $dividendosArray['fechaPagoDiv'] = $dividendos['fechaPagoDiv'];
        $dividendosArray['imRentaSoc'] = $dividendos['imRentaSoc'];
        $dividendosArray['ejerFisUtDiv'] = $dividendos['ejerFisUtDiv'];

        return $dividendosArray;
    }

    public function reembolsosToArray($reembolsos)
    {
        $reembolsosArray = [];
        foreach ($reembolsos as $reembolsoDetalle) {
            $data = [];
            $data['tipoIdentificacionProveedorReembolso'] = $reembolsoDetalle['tipoIdentificacionProveedorReembolso'];
            $data['identificacionProveedorReembolso'] = $reembolsoDetalle['identificacionProveedorReembolso'];
            $data['codPaisPagoProveedorReembolso'] = $reembolsoDetalle['codPaisPagoProveedorReembolso'];
            $data['tipoProveedorReembolso'] = $reembolsoDetalle['tipoProveedorReembolso'];
            $data['codDocReembolso'] = $reembolsoDetalle['codDocReembolso'];
            $data['estabDocReembolso'] = $reembolsoDetalle['estabDocReembolso'];
            $data['ptoEmiDocReembolso'] = $reembolsoDetalle['ptoEmiDocReembolso'];
            $data['secuencialDocReembolso'] = $reembolsoDetalle['secuencialDocReembolso'];
            $data['fechaEmisionDocReembolso'] = $reembolsoDetalle['fechaEmisionDocReembolso'];
            $data['numeroAutorizacionDocReemb'] = $reembolsoDetalle['numeroAutorizacionDocReemb'];
            $data['detalleImpuestos'] = $this->detalleImpuestosToArray($reembolsoDetalle['detalleImpuestos']);

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
        }
        return $detalleImpuestoArray;
    }

    public function pagosToArray($pagos)
    {
        $pagosArray = [];
        foreach ($pagos as $pago) {
            $data = [];
            $data['formaPago'] = $pago['formaPago'];
            $data['total'] = $pago['total'];
            $pagosArray['pago'][] = $data;
        }
        return $pagosArray;
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
