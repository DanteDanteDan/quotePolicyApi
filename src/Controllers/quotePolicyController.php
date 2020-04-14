<?php

namespace App\Controllers;

use App\Services\quotePolicyService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class quotePolicyController
{

    private $_quotePolicyService;

    public function __construct()
    {
        $this->_quotePolicyService = new quotePolicyService();
    }

    public function createQuotePolicy(Request $request, Response $response, $args)
    {
        $entryPayment = $this->_quotePolicyService->createQuotePolicy((object) $request->getParsedBody());

        $entryPayment = str_replace ( "&quot;" , '"' , $entryPayment );
        $entryPayment = str_replace ( '<?xml version="1.0" encoding="utf-8"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Body><dlwmin:cotizarPolizaResponse xmlns:dlwmin="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><return>' , "" , $entryPayment );
        $entryPayment = str_replace ( '</return></dlwmin:cotizarPolizaResponse></soapenv:Body></soapenv:Envelope>' , "" , $entryPayment );

        $entryPayment = str_replace ( "0," , "0" , $entryPayment );
        $entryPayment = str_replace ( "1," , "1" , $entryPayment );
        $entryPayment = str_replace ( "2," , "2" , $entryPayment );
        $entryPayment = str_replace ( "3," , "3" , $entryPayment );
        $entryPayment = str_replace ( "4," , "4" , $entryPayment );
        $entryPayment = str_replace ( "5," , "5" , $entryPayment );
        $entryPayment = str_replace ( "6," , "6" , $entryPayment );
        $entryPayment = str_replace ( "7," , "7" , $entryPayment );
        $entryPayment = str_replace ( "8," , "8" , $entryPayment );
        $entryPayment = str_replace ( "9," , "9" , $entryPayment );

        $entryPayment = str_replace ( "11:" , "'11': " , $entryPayment );
        $entryPayment = str_replace ( "'0:'" , "'0': " , $entryPayment );
        $entryPayment = str_replace ( "1:" , "'1': " , $entryPayment );
        $entryPayment = str_replace ( "2:" , "'2': " , $entryPayment );
        $entryPayment = str_replace ( "3:" , "'3': " , $entryPayment );
        $entryPayment = str_replace ( "4:" , "'4': " , $entryPayment );
        $entryPayment = str_replace ( "5:" , "'5': " , $entryPayment );
        $entryPayment = str_replace ( "6:" , "'6': " , $entryPayment );
        $entryPayment = str_replace ( "7:" , "'7': " , $entryPayment );
        $entryPayment = str_replace ( "8:" , "'8': " , $entryPayment );
        $entryPayment = str_replace ( "9:" , "'9': " , $entryPayment );
        $entryPayment = str_replace ( "10:" , "'10': " , $entryPayment );


        $entryPayment = str_replace ( '"pagoInicial":' , ',"pagoInicial":' , $entryPayment );
        $entryPayment = str_replace ( '"pagoSubsecuente":' , '"pagoSubsecuente":' , $entryPayment );
        $entryPayment = str_replace ( '"formaPago":' , ', "formaPago":' , $entryPayment );
        $entryPayment = str_replace ( '"deducible":' , ',"deducible":' , $entryPayment );
        $entryPayment = str_replace ( '"descripcion":' , ',"descripcion":' , $entryPayment );
        $entryPayment = str_replace ( '"sumaAsegurada":' , ',"sumaAsegurada":' , $entryPayment );

        $entryPayment = str_replace ( '"iva":' , ',"iva":' , $entryPayment );
        $entryPayment = str_replace ( '"folio":' , ',"folio":' , $entryPayment );
        $entryPayment = str_replace ( '"primaTotal":' , ', "primaTotal":' , $entryPayment );
        $entryPayment = str_replace ( '"descuentos":' , ',"descuentos":' , $entryPayment );
        $entryPayment = str_replace ( '"derechoPago":' , ',"derechoPago":' , $entryPayment );
        $entryPayment = str_replace ( '"requiereDatosAdicionales":' , ',"requiereDatosAdicionales":' , $entryPayment );

        $entryPayment = str_replace ( ',,' , ',' , $entryPayment );
        $entryPayment = str_replace ( '&' , '}' , $entryPayment );

        $encode = json_encode($entryPayment);
        $decode = json_decode($encode);

        // Convertir en array $newA->vehiculo;
        $response->getBody()->write($decode);

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }


}
