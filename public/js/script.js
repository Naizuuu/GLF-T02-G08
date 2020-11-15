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
    var nuevoNodo = document.createElement('h2');
    nuevoNodo.innerHTML = '<h2 style="color:orange;">Enviando el formulario...</h2>';
    document.body.appendChild(nuevoNodo);
    var retrasar = setTimeout(procesaDentroDe2Segundos, 1000);
}

function procesaDentroDe2Segundos() { 
    document.forms['forms'].submit(); 
} */

/* ------------------------------------ */