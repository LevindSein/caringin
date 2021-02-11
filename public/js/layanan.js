$(document).ready(function () {
    $("#daftar").prop("disabled", true);

    $("#ktp,#nama,#alamat,#hp").on("change paste keyup", function() {
        if($("#ktp").val() && $("#nama").val() && $("#alamat").val() && $("#hp").val()){
            $("#daftar").prop("disabled", false);
        }
        else if($(".require").text() == ''){
            $("#daftar").prop("disabled", true);
        }
    });

    
    $('#kontrol').select2({
        placeholder: '--- Pilih Tempat ---',
        ajax: {
            url: "/cari/alamat/kosong",
            dataType: 'json',
            delay: 250,
            processResults: function (alamat) {
                return {
                results:  $.map(alamat, function (al) {
                    return {
                    text: al.kd_kontrol,
                    id: al.id
                    }
                })
                };
            },
            cache: true
        }
    });

    $("#divTempat").hide();
    $("#kontrol").on("change paste keyup", function(){
        $("#divTempat").show();
        id = $(this).val();
        $("#kd_kontrol").val(id);
        $("#process").show();
        $("#dataset").hide();
        $.ajax({
            url :"/layanan/tempat/" + id,
            cache:false,
            dataType:"json",
            success:function(data)
            {
                if(data.errors){
                    console.log(data.errors);
                    alert('Data Tidak Ditemukan');
                }
                if(data.result){
                    setTimeout(function(){
                        $("#process").hide();
                        $('#kode').html(data.result.kd_kontrol);

                        $('#displayKeamananIpk').show();
                        $('#displayKeamananIpkDiskon').show();

                        $("#dataset").show();
                    }, 3000);
                }
            }
        });
    });

    function checkKeamananIpk() {
        if ($('#myCheck3').is(':checked')) {
            document
                .getElementById('myDiv3')
                .required = true;
        } else {
            document
                .getElementById('myDiv3')
                .required = false;
        }
    }
    $('input[type="checkbox"]')
        .click(checkKeamananIpk)
        .each(checkKeamananIpk);
});