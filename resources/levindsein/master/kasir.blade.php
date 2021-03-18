<?php use Carbon\Carbon; $time = strtotime(Carbon::now());?>
@extends('layout.master')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Data Kasir | BP3C</title>
<span id="form_result"></span>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Aktivitas Kasir</h6>
            <div class="row">
                <form action="{{url('master/kasir')}}" method="GET">
                    <input
                        required
                        style="color: #6e707e;background-color: #fff;background-clip: padding-box;border: 1px solid #d1d3e2;border-radius: 0.35rem;"
                        autocomplete="off"
                        type="date"
                        name="tanggal"
                        id="tanggal"
                        value="<?php echo Session::get('masterkasir'); ?>">
                    &nbsp;
                    <input 
                        type="submit"
                        class="btn btn-sm btn-info" value="Cari"/>
                </form>
                &nbsp;
                <div class="dropdown no-arrow" style="display:inline-block">
                    <a 
                        class="dropdown-toggle btn btn-sm btn-success" 
                        href="#" 
                        role="button" 
                        data-toggle="dropdown"
                        aria-haspopup="true" 
                        aria-expanded="false"><b>
                        Menu
                        <i class="fas fa-ellipsis-v fa-sm fa-fw"></i></b>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <a 
                            class="dropdown-item"
                            href="{{url('master/kasir/harian/data/perkiraan')}}"
                            type="submit">
                            <i class="fas fa-fw fa-table fa-sm text-gray-500"></i> Data Perkiraan
                        </a>
                        <a 
                            class="dropdown-item"
                            data-toggle="modal"
                            data-target="#mySisa"
                            href="#">
                            <i class="fas fa-fw fa-dollar-sign fa-sm text-gray-500"></i> Data Sisa
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table
                    class="table"
                    id="tabel"
                    width="100%"
                    cellspacing="0"
                    style="font-size:0.75rem;">
                    <thead class="table-bordered">
                        <tr>
                            <th>Kontrol</th>
                            <th>Tagihan</th>
                            <th>Pengguna</th>
                            <th>Ket</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>  
</div>
<div
    class="modal fade"
    id="myModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Tanggal Penerimaan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" id="form_edit" method="POST">
                @csrf
                <div class="modal-body-short">
                    <div class="col-lg-12">
                        <input
                            required
                            placeholder="Masukkan Tanggal Penerimaan" class="form-control" type="date"
                            autocomplete="off"
                            type="date"
                            name="edittanggal"
                            id="edittanggal"
                            value="{{Session::get('masterkasir')}}">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_ref" id="hidden_ref"/>
                    <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                </div>
            </form>
        </div>
    </div>
</div>

<div
    class="modal fade"
    id="mySisa"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rekap Sisa Tagihan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('master/kasir/sisa')}}" target="_blank" method="GET">
                <div class="modal-body-short">
                    <div class="form-group col-lg-12">
                        <label for="sisatagihan">Pilih Rekap Sisa Tagihan</label>
                        <select class="form-control" name="sisatagihan" id="sisatagihan" required>
                            <option selected value="all">Semua</option>
                            <option value="sebagian">Sebagian</option>
                        </select>
                        <div class="form-group col-lg-12" style="display:none;" id="divrekapsisa">
                            <br>
                            <label for="sebagian">Blok <span style="color:red;">*</span></label>
                            <div class="form-group">
                                <select class="sebagian" name="sebagian[]" id="sebagian" required multiple></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function () {
    $('#tabel').DataTable({
        processing: true,
		serverSide: true,
		ajax: {
            url: "/master/kasir/?tanggal=" + <?php echo Session::get('masterkasir')?>,
            cache:false,
		},
		columns: [
			{ data: 'kd_kontrol', name: 'kd_kontrol', class : 'text-center', width: '25%' },
			{ data: 'tagihan', name: 'tagihan', class : 'text-center', width: '25%' },
			{ data: 'pengguna', name: 'pengguna', class : 'text-center', width: '20%', orderable: false },
			{ data: 'lokasi', name: 'lokasi', class : 'text-center', width: '20%', orderable: false },
			{ data: 'action', name: 'action', class : 'text-center', width: '10%', orderable: false, searchable: false },
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

    $(document).on('click', '.restore', function(){
        var id = $(this).attr('id');
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
		$.ajax({       
			url: "/master/kasir/restore/"+id,
            cache:false,
			method:"POST",
			dataType:"json",
			success:function(data)
			{
				if(data.errors)
				{
                    alert(data.errors);
				}
				if(data.success)
				{
                    alert(data.success);
                    $('#tabel').DataTable().ajax.reload(function(){}, false);
                }
            },
            error: function(data){
                alert('Oops! Kesalahan Sistem');
                $('#process').hide();
                location.reload();
            }
		});
    });

    $("#sebagian").prop('required',false);
            
    $('#sebagian').select2({
        placeholder: '--- Pilih Blok ---',
        ajax: {
            url: "/cari/blok",
            dataType: 'json',
            delay: 250,
            processResults: function (blok) {
                return {
                results:  $.map(blok, function (bl) {
                    return {
                    text: bl.nama,
                    id: bl.nama
                    }
                })
                };
            },
            cache: true
        }
    });

    $("#sisatagihan").change(function() {
        var val = $(this).val();
        if(val === "all") {
            $("#divrekapsisa").hide();
            $("#sebagian").prop('required',false);
            $('#sebagian').val('');
            $('#sebagian').html('');
        }
        else if(val === "sebagian") {
            $("#divrekapsisa").show();
            $("#sebagian").prop('required',true);
        }
    });
});
</script>
<script src="{{asset('js/master/kasir.js')}}"></script>
@endsection