function postDataToServer(args, serviceName, methodName, callbackMethod) {
    var webRequestInfo = {
        methodName: methodName,
        serviceName: serviceName,
        jsonParams: args
    };
    var dataVal = JSON.stringify(webRequestInfo);

    var url = "/gladstone/jsonServlet";
    $.ajax({
        type: 'POST',
        data: dataVal,
        dataType: 'json',
        url: url,
        contentType: "application/json; charset=utf-8",
        success: callbackMethod,
        error: callbackMethod
    });
}

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}
