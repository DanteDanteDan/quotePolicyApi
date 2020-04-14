<?php

$location_URL="https://www.segurosafirme.com.mx/MidasWeb/CotizacionAutoIndividualService";
$token = "<token>e9497991-d9ce-4f74-9d80-2786e3ac3fbf</token>";

$idNegocio = "43";
$idProducto = 191;
$idTipoPoliza = 83;
$idEstadoCirculacion = 21000;      // Puebla
$idMunicipioCirculacion = 21115;   // Puebla
$codigoPostalCirculacion = 72000;
$idLineaNegocio = 755;
$idMarca = 340;
$modelo = 2017;
$idEstilo = 88785;
$idPaquete = 678;
$idFormaPago = 1;

/*

a. Cotización express
b. Cotizar para personas físicas o morales usando clientes existentes
c. Cotizar para personas físicas usando clientes nuevos
d. Cotizar para personas Morales usando clientes nuevos
e. Cotizar enviando coberturas // Pendiente
f. Cotizar enviando datos del conductor y del asegurado
g. Cotizar conducto cobro con tarjeta

*/

$request_a = '
   <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
   <soapenv:Header/>
   <soapenv:Body>
      <cot:cotizarPoliza>
         <!--Optional:-->
         <json>
         {
         "datosPoliza": {
         "idNegocio": "'.$idNegocio.'",
         "idProducto": "'.$idProducto.'",
         "idTipoPoliza": "'.$idTipoPoliza.'"
         },
         "zonaCirculacion": {
         "idEstadoCirculacion": "'.$idEstadoCirculacion.'",
         "idMunicipioCirculacion": "'.$idMunicipioCirculacion.'",
         "codigoPostalCirculacion": "'.$codigoPostalCirculacion.'"
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

$request_b = '
   <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
   <soapenv:Header/>
   <soapenv:Body>
      <cot:cotizarPoliza>
         <!--Optional:-->
         <json>
         {
         "datosPoliza": {
         "idNegocio": "'.$idNegocio.'",
         "idProducto": "'.$idProducto.'",
         "idTipoPoliza": "'.$idTipoPoliza.'"
         },
         "zonaCirculacion": {
         "idEstadoCirculacion": "'.$idEstadoCirculacion.'",
         "idMunicipioCirculacion": "'.$idMunicipioCirculacion.'",
         "codigoPostalCirculacion": "'.$codigoPostalCirculacion.'"
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
         },
         "contratante": {
         "idContratante": 1651582
         }
      }
         </json>
         <!--Optional:-->
         "'.$token.'"
      </cot:cotizarPoliza>
   </soapenv:Body>
   </soapenv:Envelope>'
;

$request_c = '
   <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
   <soapenv:Header/>
   <soapenv:Body>
      <cot:cotizarPoliza>
         <!--Optional:-->
         <json>
         {
         "datosPoliza": {
         "idNegocio": "'.$idNegocio.'",
         "idProducto": "'.$idProducto.'",
         "idTipoPoliza": "'.$idTipoPoliza.'"
         },
         "zonaCirculacion": {
         "idEstadoCirculacion": "'.$idEstadoCirculacion.'",
         "idMunicipioCirculacion": "'.$idMunicipioCirculacion.'",
         "codigoPostalCirculacion": "'.$codigoPostalCirculacion.'"
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
         },
         "contratante": {
            "nombreContratante": "Joel",
            "apellidoPaterno": "Fabian",
            "apellidoMaterno": "Rufino",
            "rfc": "JOFR790224IZ0",
            "claveSexo": "M",
            "claveEstadoCivil": "S",
            "idEstadoNacimiento": "19000",
            "idMunicipioNacimiento": "19038",
            "fechaNacimiento": "1979-02-24 00:00:00",
            "codigoPostal": "67515",
            "idCiudad": "19038",
            "idEstado": "19000",
            "claveColonia": "67515-4",
            "nombreColonia": "REAL DEL VALLE",
            "calle": "Bugambilias",
            "numero": "115",
            "telefonoCasa": "82634567801",
            "telefonoOficina": "",
            "email": "0jose.ake@afirme.com"
            } 
      }
         </json>
         <!--Optional:-->
         "'.$token.'"
      </cot:cotizarPoliza>
   </soapenv:Body>
   </soapenv:Envelope>'
;

$request_d = '
   <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
   <soapenv:Header/>
   <soapenv:Body>
      <cot:cotizarPoliza>
         <!--Optional:-->
         <json>
         {
         "datosPoliza": {
         "idNegocio": "'.$idNegocio.'",
         "idProducto": "'.$idProducto.'",
         "idTipoPoliza": "'.$idTipoPoliza.'"
         },
         "zonaCirculacion": {
         "idEstadoCirculacion": "'.$idEstadoCirculacion.'",
         "idMunicipioCirculacion": "'.$idMunicipioCirculacion.'",
         "codigoPostalCirculacion": "'.$codigoPostalCirculacion.'"
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
         },
         "contratante": {
            "nombreRazonSocial":"FABRICACION Y MANUFACTURA DE REMOLQUEZ ORTIZ S.A DE C.V.",
            "representanteLegal":"FERNANDO LEGAL MENA",
            "fechaConstitucion":"2014-06-09 00:00:00",
            "idEstadoNacimiento": "19000",
            "codigoPostal":"67515",
            "rfc":"JOFR790224IZ0",
            "idCiudad":"19038",
            "idEstado":"19000",
            "claveColonia":"67515-4",
            "nombreColonia":"REAL DEL VALLE",
            "calle":"Bugambilias",
            "numero":"115"
            }
      }
         </json>
         <!--Optional:-->
         "'.$token.'"
      </cot:cotizarPoliza>
   </soapenv:Body>
   </soapenv:Envelope>'
;

$request_e = '
   <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
   <soapenv:Header/>
   <soapenv:Body>
      <cot:cotizarPoliza>
         <!--Optional:-->
         <json>
         {
         "datosPoliza": {
         "idNegocio": "'.$idNegocio.'",
         "idProducto": "'.$idProducto.'",
         "idTipoPoliza": "'.$idTipoPoliza.'",
         "porcentajePagoFraccionado": 0
         },
         "zonaCirculacion": {
         "idEstadoCirculacion": "'.$idEstadoCirculacion.'",
         "idMunicipioCirculacion": "'.$idMunicipioCirculacion.'"
         },
         "vehiculo": {
         "idLineaNegocio": "'.$idLineaNegocio.'",
         "numeroSerieVin": "",
         "idTipoUso": 9,
         "idMarca": "'.$idMarca.'",
         "modelo": "'.$modelo.'",
         "idEstilo": "'.$idEstilo.'"
         },
         "paquete": {
         "idPaquete": "'.$idPaquete.'",
         "idFormaPago": "'.$idFormaPago.'",
         "pctDescuentoEstado": 0,
         "observaciones": "test WS ake uc"
         },
         "contratante": {
            "idContratante": 1651582
         },
         "coberturas": [{
            "idCobertura": 2510,
            "obligatoriedad": 0,
            "contratada": true,
            "descripcion": "DAÑOS MATERIALES",
            "sumaAsegurada": "Valor Comercial",
            "deducible": 5.0
         }]
      }
         </json>
         <!--Optional:-->
         "'.$token.'"
      </cot:cotizarPoliza>
   </soapenv:Body>
   </soapenv:Envelope>'
;

$request_f = '
   <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
   <soapenv:Header/>
   <soapenv:Body>
      <cot:cotizarPoliza>
         <!--Optional:-->
         <json>
         {
         "datosPoliza": {
         "idNegocio": "'.$idNegocio.'",
         "idProducto": "'.$idProducto.'",
         "idTipoPoliza": "'.$idTipoPoliza.'"
         },
         "zonaCirculacion": {
         "idEstadoCirculacion": "'.$idEstadoCirculacion.'",
         "idMunicipioCirculacion": "'.$idMunicipioCirculacion.'",
         "codigoPostalCirculacion": "'.$codigoPostalCirculacion.'"
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
         },
         "contratante": {
            "nombreContratante": "Joel",
            "apellidoPaterno": "Fabian",
            "apellidoMaterno": "Rufino",
            "rfc": "JOFR790224IZ0",
            "claveSexo": "M",
            "claveEstadoCivil": "S",
            "idEstadoNacimiento": "19000",
            "idMunicipioNacimiento": "19038",
            "fechaNacimiento": "1979-02-24 00:00:00",
            "codigoPostal": "67515",
            "idCiudad": "19038",
            "idEstado": "19000",
            "claveColonia": "67515-4",
            "nombreColonia": "REAL DEL VALLE",
            "calle": "Bugambilias",
            "numero": "115",
            "telefonoCasa": "82634567801",
            "telefonoOficina": "",
            "email": "0jose.ake@afirme.com"
            },
            "conductor": {
            "nombreConductor": "danelys",
            "apellidoPaternoConductor": "morales",
            "apellidoMaternoConductor": "soler",
            "fechaNacimiento": "1987-10-18 00:00:00",
            "numeroLicencia": "555555",
            "ocupacion": "chofer"
            },
            "asegurado": {
            "nombreAsegurado": "Hileab Fuentes Garza"
            }
      }
         </json>
         <!--Optional:-->
         "'.$token.'"
      </cot:cotizarPoliza>
   </soapenv:Body>
   </soapenv:Envelope>'
;

$request_g = '
   <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
   <soapenv:Header/>
   <soapenv:Body>
      <cot:cotizarPoliza>
         <!--Optional:-->
         <json>
         {
         "datosPoliza": {
         "idNegocio": "'.$idNegocio.'",
         "idProducto": "'.$idProducto.'",
         "idTipoPoliza": "'.$idTipoPoliza.'"
         },
         "zonaCirculacion": {
         "idEstadoCirculacion": "'.$idEstadoCirculacion.'",
         "idMunicipioCirculacion": "'.$idMunicipioCirculacion.'",
         "codigoPostalCirculacion": "'.$codigoPostalCirculacion.'"
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
         },
         "conductoCobro":{
            "idMedioPago":"4",
            "datosTarjeta":{
            "tarjetaHabiente":"LUIS A MORALES G",
            "idBanco":"56",
            "idTipoTarjeta":"VS",
            "numeroTarjeta":"4772143009798030",
            "codigoSeguridadTarjeta":"123",
            "fechaVencimientoTarjeta":"0120"
            },
            "datosTitular":{
            "tarjetaHabiente":"LUIS A MORALES G",
            "correo":"superluigy@gmail.com",
            "telefono":"5516549337",
            "clavePais":"PAMEXI",
            "idEstado":"15000",
            "idMunicipio":"15058",
            "idColonia":"7880",
            "nombreColonia":"ben",
            "calleNumero":"Benito Juárez 86",
            "codigoPostal":"57000",
            "rfc":"MOGL821124"
            }
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

      $search_result = $client->__doRequest($request_e, $location_URL, $location_URL, 1);
      // Get response
      echo('<pre>');
      print_r($search_result);
      echo('</pre>');

    } catch (SoapFault $exception) {

      var_dump(get_class($exception));
      var_dump($exception);

   }
