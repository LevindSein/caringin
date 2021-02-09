$(document).ready(function () {
    $('#tabel').DataTable({
        processing: true,
        serverSide: true,
		ajax: {
			url: "/keuangan/laporan/pendapatan/tahunan",
            cache:false,
		},
		columns: [
			{ data: 'thn_bayar', name: 'thn_bayar', class : 'text-center' },
			{ data: 'realisasi', name: 'realisasi', class : 'text-center', orderable : false },
			{ data: 'diskon', name: 'diskon', class : 'text-center', orderable : false }
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