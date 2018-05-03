/*
https://api.jquery.com/scroll/
*/

/* als de section met id content begint te scrollen */
$( "#content").scroll(function() {
    var hoogteZoekbalk = $("main>header").height();
    var hoogteInfobalk = $("#content>header").height();
    var huidigeScrollPos = $("#content>header").offset().top;
    var delta = (hoogteZoekbalk - hoogteInfobalk);
   console.log("hoogte van zoekbalk: " + hoogteZoekbalk);
    console.log("hoogte van infobalk: "+ hoogteInfobalk);

    console.log(huidigeScrollPos);
    console.log("delta" + delta);
    console.log("ik ben aan het scrollen!!!");
    if(huidigeScrollPos < delta){
        //toon de mini navigatie
        $("main").addClass("isScrolled");
    }else{
        //toon terug de grote navigatie
        $("main").removeClass("isScrolled")
    }
});