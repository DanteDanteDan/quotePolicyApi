<?php

$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual">
<soapenv:Header/>
<soapenv:Body>
   <cot:cotizarPoliza>
      <!--Optional:-->
      <json>
      {
      "datosPoliza": {
       "idNegocio": "43",
       "idProducto": 191,
       "idTipoPoliza": 83
      },
      "zonaCirculacion": {
       "idEstadoCirculacion": 21000,
       "idMunicipioCirculacion": 21115,
       "codigoPostalCirculacion": 72000
      },
      "vehiculo": {
       "idLineaNegocio": 755,
       "idMarca": 340,
       "modelo": 2019,
       "idEstilo": 88785
      },
      "paquete": {
       "idPaquete": 678,
       "idFormaPago": 1
      }
     }
      </json>
      <!--Optional:-->
      <token>a8e39ce4-611e-4801-aef9-ea06d203ebd3</token>
   </cot:cotizarPoliza>
</soapenv:Body>
</soapenv:Envelope>';

$sUrl = 'https://www.segurosafirme.com.mx/MidasWeb/CotizacionAutoIndividualService';

// set parameters

 $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$sUrl);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
    $sOutput = curl_exec($ch);
    curl_close($ch);
    echo "<pre>";
    var_dump($sOutput);