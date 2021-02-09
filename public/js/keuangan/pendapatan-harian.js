$(document).ready(function () {
    $('#tabel').DataTable({
        processing: true,
        serverSide: true,
		ajax: {
			url: "/keuangan/laporan/pendapatan/harian",
            cache:false,
		},
		columns: [
			{ data: 'kd_kontrol', name: 'kd_kontrol', class : 'text-center' },
			{ data: 'tgl_bayar', name: 'tgl_bayar', class : 'text-center', orderable : false },
			{ data: 'realisasi', name: 'realisasi', class : 'text-center', orderable : false },
			{ data: 'nama', name: 'nama', class : 'text-center'},
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
});