var stepOne = document.getElementById('stepOne');
var stepTwo = document.getElementById('stepTwo');

$(stepTwo).ready(function(){
    if ($("#stepTwo").html().length > 0) {
      $('#stepOne').hide();
    }                                           
});

/* ------------------------------------ */

/* window.onload = function () { 
    document.forms['form'].addEventListener('submit', avisarUsuario);
}
 
function avisarUsuario(evObject) {
    evObject.preventDefault();
    var nombre = document.getElementById('transAlfabeto').value;
    var expReg = /^([A-Za-z0-9]+|@)$/;
    if(!expReg.test(nombre)){
        alert('La transicion no tiene los valores del abecedario ingresado.');
    } else {
        var retrasar = setTimeout(procesaDentroDe2Segundos, 1000);
    }
}

function procesaDentroDe2Segundos() { 
    document.forms['forms'].submit(); 
} */

/* ------------------------------------ */
