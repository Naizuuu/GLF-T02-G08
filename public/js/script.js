var stepOne = document.getElementById('stepOne');
var stepTwo = document.getElementById('stepTwo');

$(stepTwo).ready(function(){
    if ($("#stepTwo").html().length > 0) {
      $('#stepOne').hide();
    }                                           
});

$(document).ready(function(){
    $("#navUno").click(function() {
        $(".procesoUno").toggleClass('oculto');
    });
    $("#navDos").click(function() {
        $(".procesoDos").toggleClass('oculto');
    });
    $("#navTres").click(function() {
        $(".procesoTres").toggleClass('oculto');
    });
    $("#navCuatro").click(function() {
        $(".procesoCuatro").toggleClass('oculto');
    });
    $("#navCinco").click(function() {
        $(".procesoCinco").toggleClass('oculto');
    });
    $("#navSeis").click(function() {
        $(".procesoSeis").toggleClass('oculto');
    });
});