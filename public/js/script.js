function showDiv() {
    var test1 = document.getElementById('test1');
    var test2 = document.getElementById('test2');

    /* test1.style.visibility = "hidden";
    test1.style.maxHeight = "0";
    test2.style.visibility = "visible";
    test1.style.maxHeight = "auto"; */
    /* test3.style.visibility = "none"; */
    if(test1.style.display === "none") {
        test2.style.display = "block";
    } else {
        test1.style.display = "none";
    }
    /* test1.style.display = "none";
    test2.style.display = "block"; */

    /* 
    visibility: hidden; 
    max-height: 0;
     */
 }

