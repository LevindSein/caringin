$(document).ready(function(){
	$('#tabel').DataTable({
		processing: true,
		serverSide: true,
		ajax: {
			url: "/tagihan/neraca",
            cache:false,
		},
		columns: [
			{ name: 'created_at', data: { '_': 'created_at.display', 'sort': 'created_at.timestamp' }, class : 'text-center'  },
			{ data: 'debit', name: 'debit', class : 'text-center' },
			{ data: 'kredit', name: 'kredit', class : 'text-center' },
			{ data: 'saldo', name: 'saldo', class : 'text-center' },
			{ data: 'sisa', name: 'sisa', class : 'text-center' },
        ],
        stateSave: true,
        scrollX: true,
        deferRender: true,
        pageLength: 8
    });

    $('#saldo').click(function(){
		$('.titles').text('Saldo saat ini');
		$('#action_btn').val('Submit');
		$('#action').val('saldo');
		$('#form_result').html('');
        $('#form_neraca')[0].reset();
        $('#myModal').modal('show');
    });

    $('#debit').click(function(){
		$('.titles').text('DEBIT');
		$('#action_btn').val('Submit');
		$('#action').val('debit');
		$('#form_result').html('');
        $('#form_neraca')[0].reset();
        $('#myModal').modal('show');
    });

    $('#form_neraca').on('submit', function(event){
		event.preventDefault();
        $('#form_result').html('');
		$.ajax({
			url :"/tagihan/neraca",
            cache:false,
			method:"POST",
			data:$(this).serialize(),
			dataType:"json",
			success:function(data)
			{
                if(data.errors)
				{
                    html = '<div class="alert alert-danger" id="error-alert"> <strong>Maaf ! </strong>' + data.errors + '</div>';
				}
				if(data.success)
				{
					html = '<div class="alert alert-success" id="success-alert"> <strong>Sukses ! </strong>' + data.success + '</div>';
				}
                
                $('#myTotal').modal('hide');
				$('#form_result').html(html);
                $("#success-alert,#error-alert,#info-alert,#warning-alert")
                    .fadeTo(2000, 1000)
                    .slideUp(2000, function () {
                        $("#success-alert,#error-alert").slideUp(1000);
                });
            }
        });
    });

    document
        .getElementById('nominal')
        .addEventListener(
            'input',
            event => event.target.value = (parseInt(event.target.value.replace(/[^\d]+/gi, '')) || 0).toLocaleString('en-US')
        );
});