<?php

namespace App\Sri\Endpoints;

use nusoap_client;

class EndPoints
{
    private $actionReception = 'reception';
    private $end_point;
    private $url_reception = 'RecepcionComprobantesOffline';
    private $url_authorization = 'AutorizacionComprobantesOffline';
    private $environment_production_sri = 2;

    public function __construct($environment, $action)
    {
        $this->end_point = "https://celcer.sri.gob.ec/comprobantes-electronicos-ws/";
        if ($environment == $this->environment_production_sri) {
            $this->end_point = "https://cel.sri.gob.ec/comprobantes-electronicos-ws/";
        }
        if ($action == $this->actionReception) {
            $this->end_point = $this->end_point . $this->url_reception;
        } else {
            $this->end_point = $this->end_point . $this->url_authorization;
        }
        $this->end_point = $this->end_point . '?wsdl';
    }

    public function sendToSri($params)
    {
        $client = new nusoap_client($this->end_point);
        $client->soap_defencoding = 'utf-8';
        $response = $client->call("validarComprobante", $params, "http://ec.gob.sri.ws.recepcion");
        return $response;
    }

    public function authorization($params)
    {
        $client = new nusoap_client($this->end_point);
        $client->soap_defencoding = 'utf-8';
        $response = $client->call("autorizacionComprobante", $params, "http://ec.gob.sri.ws.autorizacion");
        return $response;
    }
}
