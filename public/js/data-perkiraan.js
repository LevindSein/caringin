$(document).ready(function(){
    $('.html_result').hide();
    $('#tabelKasir').DataTable({
        processing: true,
		serverSide: true,
		ajax: {
            url: "/kasir/harian/data/perkiraan",
            cache:false,
		},
		columns: [
			{ data: 'kode', name: 'kode', class : 'text-center', width: '25%' },
			{ data: 'nama', name: 'nama', class : 'text-center', width: '25%' },
			{ data: 'jenis', name: 'jenis', class : 'text-center', width: '25%' },
			{ data: 'action', name: 'action', class : 'text-center', width: '25%' }
        ],
        pageLength: 10,
        stateSave: true,
        scrollX: true,
        scrollY: "35vh",
        lengthMenu: [[10,25,50,100,-1], [10,25,50,100,"All"]],
        deferRender: true,
        // dom : "r<'row'<'col-sm-12 col-md-6'><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        responsive : true
    }).columns.adjust().draw();

    var user_id;
    $(document).on('click', '.delete', function(){
		user_id = $(this).attr('id');
		$('#confirmModal').modal('show');
	});

	$('#ok_button').click(function(){
		$.ajax({
			url:"/kasir/harian/data/perkiraan/destroy/" + user_id,
            cache:false,
			beforeSend:function(){
				$('#ok_button').text('Menghapus...');
			},
			success:function(data)
			{
                if(data.error)
                    html = '<div class="alert alert-danger" id="error-alert"> <strong>Oops! </strong>' + data.error + '</div>';
                else if(data.success)
                    html = '<div class="alert alert-success" id="success-alert"> <strong>Success! </strong>' + data.success + '</div>';
                $('.html_result').show();
                $('.html_result').html(html); 
                $('#confirmModal').modal('hide');
                $('#tabelKasir').DataTable().ajax.reload(function(){}, false);
                $("#success-alert,#error-alert,#info-alert,#warning-alert")
                    .fadeTo(2000, 1000)
                    .slideUp(2000, function () {
                        $("#success-alert,#error-alert").slideUp(1000);
                });
            },
            complete:function(){
                $('#ok_button').text('Hapus');
            }
        })
    });
});