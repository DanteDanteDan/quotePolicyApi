<?php

namespace App\Services;

use SoapFault;
use SoapClient;
use DOMDocument;
use PDO;
use db;

class catalogueService
{

  public function __construct()
  {

  }

  public function queryInsurers() // List of insurers
  {
      $db = new db();
      $db = $db->conectDB();

      $sql = "SELECT * from quo0320_cat_insurance";

      $content = $db->query($sql);
      $result = $content->fetchAll(PDO::FETCH_OBJ);

      return $result;
  }

  public function queryBrands() // List of Brands
  {
      $db = new db();
      $db = $db->conectDB();

      $sql = "SELECT * from quo0320_brands";

      $content = $db->query($sql);
      $result = $content->fetchAll(PDO::FETCH_OBJ);

      return $result;
  }

  private function doRequest($location_url, $xml, $action_soap)  // Request Soap
  {

    // Create client
    $client = new SoapClient( null, array(
      'location' => $location_url,
      'uri'      => $location_url,
      'trace'    => 1,
    ));

    // Do Request
    try{

      $result = $client->__doRequest($xml, $location_url, $action_soap, 1);

    } catch (SoapFault $exception) {

      var_dump(get_class($exception));
      var_dump($exception);

    }

    return $result;

  }

  private function reedXml($clean_result, $tag_name, $attribute_name)  // Reed XML
  {

    $arr =array();

    $dom = new DOMDocument('1.0', 'utf-8');
    $dom->loadXML( $clean_result );
    $XMLresults = $dom->getElementsByTagName($tag_name);

    for ($i=0; $i < count($XMLresults); $i++) {

      $arr[$XMLresults[$i]->getAttribute($attribute_name)] = $XMLresults->item($i)->nodeValue;

    }

    return $arr;

  }

  private function arrayFusion($result_index, $index_first_type, $index_second_type)  // Array fusion
  {

    $brands = array();

    foreach ($result_index as $key => $value) {

      $brands[$key]['name'] = strtoupper($key);

      foreach ($index_first_type as $key => $value) {
        $key = strtoupper($key);
        $brands[$key]['id'][0] = $value;
        if (!isset($brands[$key]['id'][1])) {
          $brands[$key]['id'][1] = null;
        }
      }
      foreach ($index_second_type as $key => $value) {
        $key = strtoupper($key);
        $brands[$key]['id'][1] = $value;
        if (!isset($brands[$key]['id'][0])) {
          $brands[$key]['id'][0] = null;
        }
      }

    }

    $array_brands = (array) $brands;
    $result = array();
    foreach ($array_brands as $key => $value) {
      $result[] = $value;
    }

    return $result;

  }

  public function carBrands() { // All brands

    // Querys
    $brands = $this->queryBrands();
    $insurances = $this->queryInsurers();

    // Arrays
    $array_first_type = Array();
    $array_second_type = Array();
    $result_merged = Array();

    foreach ($brands as $key => $value) {

      $brands[$key]->xml_string = str_replace ( "#IDBUSS#", $brands[$key]->id_business ,  $brands[$key]->xml_string );
      $brands[$key]->xml_string = str_replace ( "#USER#",   $insurances[$key]->user ,     $brands[$key]->xml_string );
      $brands[$key]->xml_string = str_replace ( "#PASS#",   $insurances[$key]->password , $brands[$key]->xml_string );
      $brands[$key]->xml_string = str_replace ( "#TOKEN#",  $insurances[$key]->token ,    $brands[$key]->xml_string );

      // Request
      $result_request = $this->doRequest($insurances[$key]->location_url, $brands[$key]->xml_string, $brands[$key]->action_soap);

      if ($brands[$key]->type == 1 ) {
        // Clean format type 1
        $result_request = str_replace ( "&quot;" , '"' , $result_request );
        $result_request = str_replace ( '<?xml version="1.0" encoding="utf-8"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Body><dlwmin:getListMarcasResponse xmlns:dlwmin="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><return>' , "" , $result_request );
        $result_request = str_replace ( '</return></dlwmin:getListMarcasResponse></soapenv:Body></soapenv:Envelope>' , "" , $result_request );

        $encode = json_encode($result_request); // String
        $object_result = json_decode($encode); // String
        $object_afirme = json_decode($object_result);
        $array_result = (array) $object_afirme;

        $array_first_type = $array_first_type + (array) $array_result;

        // Dom document Afirme
        //$arr_reed_afirme = $this->reedXml($result_afirme, 'getListMarcasResponse', 'id');

      } else {
        // Clean format type 2
        $result_request = str_replace ( '&gt;' , '>' , $result_request );
        $result_request = str_replace ( '&lt;' , '<' , $result_request );
        $result_request = str_replace ( '<?xml version="1.0" encoding="UTF-8"?><transacciones xmlns="">' , '<transacciones xmlns="">' , $result_request );

        // Dom document ORP
        $arr_reed_result = $this->reedXml($result_request, 'marca', 'id');

        $encode = json_encode($arr_reed_result); // String
        $object_result = json_decode($encode);   // String
        $array_result = (array) $object_result;

        $array_second_type = $array_second_type + (array) $array_result;

      }

      // merge arrays
      $result_merged = $result_merged + $array_result;
      //print_r($result_merged);

    }

    $result_unique = array_unique($result_merged);

    $result_index = array_flip(array_values($result_unique));
    $index_second_type = array_flip($array_second_type);
    $index_first_type = array_flip($array_first_type);

    // Array fusion
    $result = $this->arrayFusion($result_index, $index_first_type, $index_second_type);

    return $result;

  }

  public function subBrands ($obj, $id_business_orp, $action_soap_orp, $user_orp, $pass_orp) //

  {
    $db = $this->queryBrands();
    print_r($db);


    $location_URL="https://server.anaseguros.com.mx/ananetws/service.asmx?wsdl";
    $action_soap = 'http://tempuri.org/'.$action_soap_orp.'';

    //$obj->idBrand = "AI";
    $idBrand = htmlentities($obj['idBrandORP']);

    $request_brands = '<?xml version="1.0" encoding="utf-8"?>
    <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
      <soap:Body>
        <SubMarca xmlns="http://tempuri.org/">
          <Negocio>'.$id_business_orp.'</Negocio>
          <Marca>'.$idBrand.'</Marca>
          <Modelo>2018</Modelo>
          <Categoria>100</Categoria>
          <Usuario>'.$user_orp.'</Usuario>
          <Clave>'.$pass_orp.'</Clave>
        </SubMarca>
      </soap:Body>
    </soap:Envelope>'
    ;

    $client = new SoapClient( null, array(
        'location' => $location_URL,
        'uri'      => $location_URL,
        'trace'    => 1,
    ));

    try{

      $search_result = $client->__doRequest($request_brands, $location_URL, $action_soap, 1);

    } catch (SoapFault $exception) {

      var_dump(get_class($exception));
      var_dump($exception);

    }

    $search_result = str_replace ( '&gt;' , '>' , $search_result );
    $search_result = str_replace ( '&lt;' , '<' , $search_result );
    $search_result = str_replace ( '<?xml version="1.0" encoding="UTF-8"?><transacciones xmlns="">' , '<transacciones xmlns="">' , $search_result );

    $arr_sub_brands = array();

    $dom = new DOMDocument('1.0', 'utf-8');
    $dom->loadXML( $search_result );
    $XMLresults = $dom->getElementsByTagName("submarca");

    for ($i=0; $i < count($XMLresults); $i++) {

      //$arr_sub_brands[$XMLresults[$i]->getAttribute('clave')] = $XMLresults->item($i)->nodeValue;
      $arr_sub_brands[$i]['id'] = $XMLresults[$i]->getAttribute('clave');
      $arr_sub_brands[$i]['name'] = $XMLresults->item($i)->nodeValue;

    }

    $result = array();
    foreach ($arr_sub_brands as $key => $value) {
      $result[] = $value;
    }

    //$response = json_encode($arr_sub_brands);

    return $result;

  }

  public function descriptionORP ($obj, $subBrand) // ORP Vehicles

  {
    $location_URL="https://server.anaseguros.com.mx/ananetws/service.asmx?wsdl";
    $actionSoap = 'http://tempuri.org/Vehiculo';

    $idBrand = htmlentities($obj['idBrandORP']);
    $idSubBrand = $subBrand;
    //$idBrand = "TA";
    //$idSubBrand = "178";

    $request_brands = '<?xml version="1.0" encoding="utf-8"?>
      <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
        <soap:Body>
          <Vehiculo xmlns="http://tempuri.org/">
            <Negocio>1370</Negocio>
            <Marca>'.$idBrand.'</Marca>
            <Submarca>'.$idSubBrand.'</Submarca>
            <Modelo>2019</Modelo>
            <Usuario>ORPWS</Usuario>
            <Clave>6Avvy3qv</Clave>
          </Vehiculo>
        </soap:Body>
      </soap:Envelope>'
    ;

    $client = new SoapClient( null, array(
        'location' => $location_URL,
        'uri'      => $location_URL,
        'trace'    => 1,
    ));

    try{

      $search_result = $client->__doRequest($request_brands, $location_URL, $actionSoap, 1);

    } catch (SoapFault $exception) {

      var_dump(get_class($exception));
      var_dump($exception);

    }

    $search_result = str_replace ( '&gt;' , '>' , $search_result );
    $search_result = str_replace ( '&lt;' , '<' , $search_result );
    $search_result = str_replace ( '<?xml version="1.0" encoding="UTF-8"?><transacciones xmlns="">' , '<transacciones xmlns="">' , $search_result );

    $arr_desacription = array();

    $dom = new DOMDocument('1.0', 'utf-8');
    $dom->loadXML( $search_result );
    $XMLresults = $dom->getElementsByTagName("vehiculo");

    for ($i=0; $i < count($XMLresults); $i++) {

      //$arr_desacription[$XMLresults[$i]->getAttribute('clave')] = $XMLresults->item($i)->nodeValue;
      $arr_desacription[$i]['id'] = $XMLresults[$i]->getAttribute('clave');
      $arr_desacription[$i]['name'] = $XMLresults->item($i)->nodeValue;

    }

    $result = array();
    foreach ($arr_desacription as $key => $value) {
      $result[] = $value;
    }

    //$response = json_encode($arr_sub_brands);

    return $result;

  }

  public function descriptionAfirme ($obj) // Afirme styles

  {
      $location_URL="https://www.segurosafirme.com.mx/MidasWeb/CotizacionAutoIndividualService";

      //$idLineaNegocio = htmlentities($obj->idLineaNegocio);
      //var_dump($idBrand = $obj['idBrandAfirme']);
      $idBrand = $obj['idBrandAfirme'];

      $request_brands = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
      <soapenv:Header/>
      <soapenv:Body>
          <cot:buscarEstilo>
            <!--Optional:-->
            <json>{
              "idMarca":'.$idBrand.',
              "modelo": 2018,
              "idLineaNegocio": 755,
              "descripcion": ""
              }
            </json>
            <!--Optional:-->
            <token>732d4a49-83ae-490c-8245-7f55472b6551</token>
            </cot:buscarEstilo>
          </soapenv:Body>
      </soapenv:Envelope>'
      ;

      $client = new SoapClient( null, array(
          'location' => $location_URL,
          'uri'      => $location_URL,
          'trace'    => 1,
        ));

        try{

          $result_afirme_req = $client->__doRequest($request_brands, $location_URL, $location_URL, 1);

        } catch (SoapFault $exception) {

          var_dump(get_class($exception));
          var_dump($exception);

        }

        $result_afirme = str_replace ( "&quot;" , '"' , $result_afirme_req );
        $result_afirme = str_replace ( "&quot" , '"' , $result_afirme );
        $result_afirme = str_replace ( '<?xml version="1.0" encoding="utf-8"?><soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Body><dlwmin:buscarEstiloResponse xmlns:dlwmin="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><return>' , "" , $result_afirme );
        $result_afirme = str_replace ( '</return></dlwmin:buscarEstiloResponse></soapenv:Body></soapenv:Envelope>' , "" , $result_afirme );

        $encode = json_encode($result_afirme); // String
        $decode_afirme = json_decode($encode); // String

        $object_afirme = json_decode($decode_afirme);

        // Array
        $array_afirme = (array) $object_afirme;
        //print_r($array_afirme);
        $array_description = array();


        foreach ($array_afirme as $key => $value) {

          $array_description[$key]['id'] = $key;
          $array_description[$key]['name'] = $value;

        }

        $array_brands = (array) $array_description;
        //print_r($array_brands);
        $result = array();
        foreach ($array_brands as $key => $value) {
          $result[] = $value;
        }

        return $result;
  }


}