<?php

namespace App\Services;

use SoapClient;
use SoapFault;

class quotePolicyService
{
    public function createQuotePolicy ( $obj ) //

    {
        $location_URL="https://www.segurosafirme.com.mx/MidasWeb/CotizacionAutoIndividualService";
        $token = "<token>3f8583ad-903c-41ad-a816-4922862fc79d</token>";

        $idNegocio = htmlentities($obj->idNegocio);
        $idProducto = htmlentities($obj->idProducto);
        $idTipoPoliza = htmlentities($obj->idTipoPoliza);
        $idEstadoCirculacion = htmlentities($obj->idEstadoCirculacion);
        $idMunicipioCirculacion = htmlentities($obj->idMunicipioCirculacion);
        $idLineaNegocio = htmlentities($obj->idLineaNegocio);
        $idMarca = htmlentities($obj->idMarca);
        $modelo = htmlentities($obj->modelo);
        $idEstilo = htmlentities($obj->idEstilo);
        $idPaquete = htmlentities($obj->idPaquete);
        $idFormaPago = htmlentities($obj->idFormaPago);

        $request_a = '
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
            <soapenv:Header/>
            <soapenv:Body>
                <cot:cotizarPoliza>
                    <!--Optional:-->
                    <json>
                    {
                        "idAgente": 80000,
                       "datosPoliza": {
                        "idNegocio": "'.$idNegocio.'",
                        "idProducto": "'.$idProducto.'",
                        "idTipoPoliza": "'.$idTipoPoliza.'"
                       },
                        "zonaCirculacion": {
                        "idEstadoCirculacion": "'.$idEstadoCirculacion.'",
                        "idMunicipioCirculacion": "'.$idMunicipioCirculacion.'"
                        },
                        "vehiculo": {
                        "idLineaNegocio": "'.$idLineaNegocio.'",
                        "idMarca": "'.$idMarca.'",
                        "modelo": "'.$modelo.'",
                        "idEstilo": "'.$idEstilo.'"
                        },
                        "paquete": {
                        "idPaquete": "'.$idPaquete.'",
                        "idFormaPago": "'.$idFormaPago.'"
                        }
                    }
                    </json>
                    <!--Optional:-->
                    "'.$token.'"
                </cot:cotizarPoliza>
            </soapenv:Body>
            </soapenv:Envelope>'
        ;

        $client = new SoapClient( null, array(
            'location' => $location_URL,
            'uri'      => $location_URL,
            'trace'    => 1,
          ));

          try{

            $search_result = $client->__doRequest($request_a, $location_URL, $location_URL, 1);

          } catch (SoapFault $exception) {

            var_dump(get_class($exception));
            var_dump($exception);

         }

        return $search_result;
    }


}