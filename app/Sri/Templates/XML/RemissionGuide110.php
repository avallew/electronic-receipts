<?php

namespace App\SRI\Templates\XML;

class RemissionGuide110
{
    public $infoTributaria;
    public $infoGuiaRemision;
    public $destinatarios;
    public $infoAdicional;

    public $guiaRemision = [];

    public $signPath;
    public $signKey;

    public function remissionGuide()
    {
        $this->guiaRemision['infoTributaria'] = $this->infoTributariaToArray();
        $this->guiaRemision['infoGuiaRemision'] = $this->infoGuiaRemisionToArray();
        $this->guiaRemision['destinatarios'] = $this->destinatariosToArray();
        if ($this->infoAdicional != null)
            $this->guiaRemision['infoAdicional'] = $this->infoAdicionalToArray();

        return $this->guiaRemision;
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

    public function infoGuiaRemisionToArray()
    {
        $infoGuiaRemisionArray = [];
        if (array_key_exists('dirEstablecimiento', $this->infoGuiaRemision))
            $infoGuiaRemisionArray['dirEstablecimiento'] = $this->infoGuiaRemision['dirEstablecimiento'];
        $infoGuiaRemisionArray['dirPartida'] = $this->infoGuiaRemision['dirPartida'];
        $infoGuiaRemisionArray['razonSocialTransportista'] = $this->infoGuiaRemision['razonSocialTransportista'];
        $infoGuiaRemisionArray['tipoIdentificacionTransportista'] = $this->infoGuiaRemision['tipoIdentificacionTransportista'];
        $infoGuiaRemisionArray['rucTransportista'] = $this->infoGuiaRemision['rucTransportista'];
        if (array_key_exists('rise', $this->infoGuiaRemision))
            $infoGuiaRemisionArray['rise'] = $this->infoGuiaRemision['rise'];
        if (array_key_exists('obligadoContabilidad', $this->infoGuiaRemision))
            $infoGuiaRemisionArray['obligadoContabilidad'] = $this->infoGuiaRemision['obligadoContabilidad'];
        if (array_key_exists('contribuyenteEspecial', $this->infoGuiaRemision))
            $infoGuiaRemisionArray['contribuyenteEspecial'] = $this->infoGuiaRemision['contribuyenteEspecial'];
        $infoGuiaRemisionArray['fechaIniTransporte'] = $this->infoGuiaRemision['fechaIniTransporte'];
        $infoGuiaRemisionArray['fechaFinTransporte'] = $this->infoGuiaRemision['fechaFinTransporte'];
        $infoGuiaRemisionArray['placa'] = $this->infoGuiaRemision['placa'];
        return $infoGuiaRemisionArray;
    }

    public function destinatariosToArray()
    {
        $destinatariosArray = [];
        foreach ($this->destinatarios as $destinatario) {
            $data = [];
            $data['identificacionDestinatario'] = $destinatario['identificacionDestinatario'];
            $data['razonSocialDestinatario'] = $destinatario['razonSocialDestinatario'];
            $data['dirDestinatario'] = $destinatario['dirDestinatario'];
            $data['motivoTraslado'] = $destinatario['motivoTraslado'];
            if (array_key_exists('docAduaneroUnico', $destinatario))
                $data['docAduaneroUnico'] = $destinatario['docAduaneroUnico'];
            if (array_key_exists('codEstabDestino', $destinatario))
                $data['codEstabDestino'] = $destinatario['codEstabDestino'];
            if (array_key_exists('ruta', $destinatario))
                $data['ruta'] = $destinatario['ruta'];
            if (array_key_exists('codDocSustento', $destinatario))
                $data['codDocSustento'] = $destinatario['codDocSustento'];
            if (array_key_exists('numDocSustento', $destinatario))
                $data['numDocSustento'] = $destinatario['numDocSustento'];
            if (array_key_exists('numAutDocSustento', $destinatario))
                $data['numAutDocSustento'] = $destinatario['numAutDocSustento'];
            if (array_key_exists('fechaEmisionDocSustento', $destinatario))
                $data['fechaEmisionDocSustento'] = $destinatario['fechaEmisionDocSustento'];
            $data['detalles'] = $this->detallesToArray($destinatario['detalles']);
            $destinatariosArray['destinatario'][] = $data;
        }

        return $destinatariosArray;
    }

    public function detallesToArray($detalles)
    {
        $detallesArray = [];
        foreach ($detalles as $detalle) {
            $data = [];
            $data['codigoInterno'] = $detalle['codigoInterno'];
            if (array_key_exists('codigoAdicional', $detalle))
                $data['codigoAdicional'] = $detalle['codigoAdicional'];
            $data['descripcion'] = $detalle['descripcion'];
            $data['cantidad'] = $detalle['cantidad'];
            if (array_key_exists('detallesAdicionales', $detalle))
                $data['detallesAdicionales'] = $this->detallesAdicionalesToArray($detalle['detallesAdicionales']);
            $detallesArray['detalle'][] = $data;
        }
        return $detallesArray;
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
