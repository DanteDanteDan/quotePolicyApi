<?php

namespace App\Controllers;

use App\Services\catalogueService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class catalogueController
{

    private $_catalogueService;

    public function __construct()
    {
        $this->_catalogueService = new catalogueService();
    }

    public function carBrands(Request $request, Response $response, $args)
    {

        $brands = $this->_catalogueService->carBrands();

        // echo gettype($brands);

        $response->getBody()->write(json_encode($brands));

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function subBrands(Request $request, Response $response, $args)
    {
        // ORP
        $id_business_orp = '1370';
        $action_soap_orp = 'SubMarca';
        $user_orp = 'ORPWS';
        $pass_orp = '6Avvy3qv';

        $subBrands = $this->_catalogueService->subBrands($request->getQueryParams(), $id_business_orp, $action_soap_orp, $user_orp, $pass_orp);

        $response->getBody()->write(json_encode($subBrands));

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }

    public function description(Request $request, Response $response, $args)
    {

        $description_ORP = Array();
        $description_Afirme = Array();
        $description_ORP_Array = Array();

        // Extract subBrands from ORP
        $subBrands = $this->_catalogueService->subBrands($request->getQueryParams(), $id_business_orp, $action_soap_orp, $user_orp, $pass_orp);

        foreach ($subBrands as $key => $value) {
            $description_ORP = $this->_catalogueService->descriptionORP($request->getQueryParams(), $subBrands[$key]['id']);

            $description_ORP_Array = array_merge($description_ORP_Array, $description_ORP);
        }

        // Extract vehicles from Afirme
        $description_Afirme = $this->_catalogueService->descriptionAfirme($request->getQueryParams());

        // Combine description from ORP and Afirme
        $result_merged = array_merge($description_ORP_Array, $description_Afirme);

        // Assign positioning
        $result = array();
        foreach ($result_merged as $key => $value) {
            $result[] = $value;
        }

        $response->getBody()->write(json_encode($result));

        return $response->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }


}
