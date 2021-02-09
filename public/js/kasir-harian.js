$(document).ready(function () {
    var i = 0;
    $("#addRow").click(function () {
        var html = '';
        html += '<div class="form-group col-lg-12">';
        html += '<div id="inputFormRow" class="inputFormRow">';
        html += '<label>&nbsp;</label>';
        html += '<div class="input-group mb-3">';
        html += '<div class="input-group-append" style="width:25vh">';
        html += '<input type="text" name="title[]" style="text-transform: capitalize;" maxlength="20" class="title form-control m-input" placeholder="Enter title" autocomplete="off">';
        html += '</div>';
        html += '<input type="text" id="tarif" name="tarif[]" class="tarif form-control m-input" maxlength="14" placeholder="Masukkan Tarif" autocomplete="off">';
        html += '<div class="input-group-append">';
        html += '<button id="removeRow" type="button" class="btn btn-danger btn-rounded btn-icon" tabIndex="-1"><i class="mdi mdi-minus"></i></button>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        
        $('#newRow').append(html);
        $('.title').focus().prop('required',true);
        $('.tarif').prop('required',true);
        $(".tarif").on('input',event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US'));
        i++;
    });

    // remove row
    $(document).on('click', '#removeRow', function () {
        $(this).blur().prop('required',false).closest('#inputFormRow').remove();
    });

    $('#form_harian').on('submit', function(event){
		event.preventDefault();
		$.ajax({
			url: '/kasir/harian',
            cache:false,
			method:"POST",
			data:$(this).serialize(),
			dataType:"json",
			success:function(data)
			{
				var html = '';
				if(data.errors)
				{
                    html = '<div class="alert alert-danger" id="error-alert"> <strong>Oops ! </strong>' + data.errors + '</div>';
                    console.log(data.errors);
                    $('.inputFormRow').remove();
				}
                else if(data.success){
                    html = '<div class="alert alert-success" id="error-alert"> <strong>Sukses ! </strong>' + data.success + '</div>';
                    $('#form_harian')[0].reset();
                    $('.inputFormRow').remove();
                }

                $('.form_result').html(html);
                $("#success-alert,#error-alert,#info-alert,#warning-alert")
                    .fadeTo(2000, 1000)
                    .slideUp(2000, function () {
                        $("#success-alert,#error-alert").slideUp(1000);
                });
            }
		});
    });

    $("#keamananlos").on('input',event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US'));
    $("#kebersihanlos").on('input',event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US'));
    $("#kebersihanpos").on('input',event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US'));
    $("#kebersihanposlebih").on('input',event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US'));
    $("#abonemen").on('input',event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US'));
});