$(document).ready(function () {
    $("#simulasi").on("change", function(){
        if($("#simulasi").val() == 'listrik'){
            $("#hidden_id").val("listrik");
            $("#divTarifListrik").show();
            $("#divTarifAirBersih").hide();
            $("#label-simulasi").html("<b>Simulasi Tarif Listrik</b>");
        }

        if($("#simulasi").val() == 'airbersih'){
            $("#hidden_id").val("airbersih");
            $("#divTarifListrik").hide();
            $("#divTarifAirBersih").show();
            $("#label-simulasi").html("<b>Simulasi Tarif Air Bersih</b>");
        }
    });
});