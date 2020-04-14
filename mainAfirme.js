function soapRequest() {
    var str =
        '<?xml version="1.0" encoding="utf-8"?>' +
        '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:cot="http://segurosafirme.com.mx/cotizacion/cotizacionautoindividual"> ' +
        '<soapenv:Header/>' +
        '<soapenv:Body>' +
        '<cot:buscarCliente> ' +
        '<json> ' +
        '{' +
        '"codigoRFC": "reps6712223xa" ' +
        '}' +
        '</json>' +
        '<token>83d0a4b9-7359-40d5-afc2-822db48b319c</token>' +
        '</cot:buscarCliente>' +
        '</soapenv:Body> ' +
        '</soapenv:Envelope>';

    function createCORSRequest(method, url) {
        var xhr = new XMLHttpRequest();
        if ("withCredentials" in xhr) {
            xhr.open(method, url, false);
        } else if (typeof XDomainRequest != "undefined") {
            alert
            xhr = new XDomainRequest();
            xhr.open(method, url);
        } else {
            console.log("CORS not supported");
            alert("CORS not supported");
            xhr = null;
        }
        return xhr;
    }
    var xhr = createCORSRequest("POST", "https://www.segurosafirme.com.mx/MidasWeb/CotizacionAutoIndividualService");
    if (!xhr) {
        console.log("XHR issue");
        return;
    }

    xhr.onload = function() {
        var results = xhr.responseText;
        console.log(results);
    }

    xhr.setRequestHeader('Content-Type', 'text/xml');
    xhr.send(str);
}