$(document).ready(function () {
    $('#tabel').DataTable({
        processing: true,
        serverSide: true,
		ajax: {
			url: "/keuangan/laporan/tagihan/" + $('#fasilitas').val(),
            cache:false,
		},
		columns: [
			{ data: 'kd_kontrol', name: 'kd_kontrol', class : 'text-center' },
			{ data: 'pedagang', name: 'pedagang', class : 'text-center', orderable : false },
			{ data: 'ket', name: 'ket', class : 'text-center', orderable : false },
			{ data: 'tagihan', name: 'tagihan', class : 'text-center', orderable : false },
        ],
        pageLength: 10,
        stateSave: true,
        scrollX: true,
        scrollY: "35vh",
        lengthMenu: [[10,25,50,100,-1], [10,25,50,100,"All"]],
        deferRender: true,
        // dom : "r<'row'<'col-sm-12 col-md-6'><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        responsive : true,
    }).columns.adjust().draw();

    $(document).on('click', '.totaltagihan', function(){
        id = $(this).attr('id');
        $('#bulan1').html('');
        $('#totalbulan1').html('');
        $('#bulan2').html('');
        $('#totalbulan2').html('');
        $('#bulan3').html('');
        $('#totalbulan3').html('');
        $('#bulan4').html('');
        $('#totalbulan4').html('');
        $('#bulan5').html('');
        $('#totalbulan5').html('');
        $('#bulan6').html('');
        $('#totalbulan6').html('');
        $('#bulanini').html('');
        $('#totalbulanini').html('');
        $('#divBulan1').hide();
        $('#divBulan2').hide();
        $('#divBulan3').hide();
        $('#divBulan4').hide();
        $('#divBulan5').hide();
        $('#divBulan6').hide();
        $.ajax({       
			url: "/cari/tagihan/" + $('#fasilitas').val() + "/" + id,
            cache:false,
			method:"GET",
			dataType:"json",
			success:function(data)
			{
                $('#judulRincian').html(data.result.kode);
                if(data.result.totalbulan1 != 0){
                    $('#divBulan1').show();
                    $('#bulan1').html(data.result.bulan1);
                    $('#totalbulan1').html("RP. " + data.result.totalbulan1);
                }

                if(data.result.totalbulan2 != 0){
                    $('#divBulan2').show();
                    $('#bulan2').html(data.result.bulan2);
                    $('#totalbulan2').html("RP. " + data.result.totalbulan2);
                }
                
                if(data.result.totalbulan3 != 0){
                    $('#divBulan3').show();
                    $('#bulan3').html(data.result.bulan3);
                    $('#totalbulan3').html("RP. " + data.result.totalbulan3);
                }
                if(data.result.totalbulan4 != 0){
                    $('#divBulan4').show();
                    $('#bulan4').html(data.result.bulan4);
                    $('#totalbulan4').html("RP. " + data.result.totalbulan4);
                }

                if(data.result.totalbulan5 != 0){
                    $('#divBulan5').show();
                    $('#bulan5').html(data.result.bulan5);
                    $('#totalbulan5').html("RP. " + data.result.totalbulan5);
                }
                
                if(data.result.totalbulan6 != 0){
                    $('#divBulan6').show();
                    $('#bulan6').html(data.result.bulan6);
                    $('#totalbulan6').html("RP. " + data.result.totalbulan6);
                }

                $('#bulanini').html(data.result.bulanini);
                $('#totalbulanini').html("RP. " + data.result.totalbulanini);
                
                $('#nominalTotal').html("RP. " + data.result.totalselisih);
                
                $('#myModal').modal('show');
            }
		});
        $('#myRincian').modal('show');
    });
});