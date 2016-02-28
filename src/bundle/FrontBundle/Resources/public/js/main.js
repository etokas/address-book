$(document).ready(function(){

    var url = "drihl_1_meuble_inf1946.json";
    var map;
    var maxPrix = null;
    var minPrix = null;
    var superficie = null;
    var maxTotal = null;
    var minTotal = null;


    initialisation(url);

    var colors = {
        '#style2': "#FC4A4A",
        "#style1": "#F65151",
        "#style4": "#ED5A5A",

        "#style3": "#FDA44B",
        "#style8": "#F6A351",
        "#style6": "#EDA35A",

        "#style7": "#FDE24B",
        "#style10": "#F6DD51",
        "#style5": "#EDD75A",

        "#style12": "#E2FD4B",
        "#style14": "#DDF651",
        "#style11": "#D7ED5A",

        "#style9": "#4AB76C",
        "#style13": "#59A671"
    };


   $(".send").click(function(){

       resetField();

       $(".resultat > td").each(function(){

           $(this).empty();

       });

        var piece = $("#piece").val();
        var annee = $("#annee").val();
        var type = $("#type").val();

        var url = "drihl_" + piece + "_" + type + "_" + annee + ".json";

       initialisation(url);
    });



    function initialisation(path) {

        $("#surface").change(function () {

            if ($(".prix-max").is(':empty')) {

                alert("Selectionnez une zone avant")
                resetField();
            }

        });

        map = new google.maps.Map(document.getElementById("googleMap"), {

            center: new google.maps.LatLng(48.856127,2.353735),
            zoom: 12,
            mapTypeId:google.maps.MapTypeId.ROADMAP
        });


        map.data.loadGeoJson("/bundles/front/json/" + path);

        map.data.setStyle(function(feature) {

            var fill = feature.getProperty('styleUrl');

            var colorfill = colors[fill];

            return({
                fillColor: colorfill,
                strokeWeight: 1,
                fillOpacity:0.7
            });
        });

        map.data.addListener('click', function(event) {

            maxPrix = event.feature.getProperty('refmaj');
            minPrix = event.feature.getProperty('refmin');


            $(".name-ville").text(event.feature.getProperty('nameZone'));
            $(".prix").text(event.feature.getProperty('ref') + ' €');
            $(".prix-max").text(event.feature.getProperty('refmaj') + ' €');
            $(".prix-min").text(event.feature.getProperty('refmin') + ' €');
            $(".type").text(event.feature.getProperty('type'));
            $(".piece").text(event.feature.getProperty('piece'));


            calculPrixMax();
            calculPrixMin();
        });



    }

    function calculPrixMax() {

        $("#surface").change(function () {

            superficie = $(this).val();

            console.log("prix : " + superficie);
            console.log("max : " + parseInt(maxPrix));

            maxTotal = (superficie * parseFloat(maxPrix)).toFixed(1);

            console.log(maxTotal);

            $(".surface-max").empty().append(maxTotal + " € / mois");

        });

    }


    function calculPrixMin() {

        $("#surface").change(function () {

            superficie = $(this).val();

            console.log("prix : " + superficie);
            console.log("max : " + parseInt(minPrix));

            minTotal = (superficie * parseFloat(minPrix)).toFixed(1);

            console.log(minTotal);

            $(".surface-min").empty().append(minTotal + " € / mois");

        });

    }


    function resetField(){

        $("#surface").val("");
        $(".surface-min").empty().append("0.0 € / mois");
        $(".surface-max").empty().append("0.0 € / mois");

        superficie = 0;
        maxTotal = 0;
        minTotal = 0;

    }


});