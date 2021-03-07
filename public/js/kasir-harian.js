$(document).ready(function () {
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
});