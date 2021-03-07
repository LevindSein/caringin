@extends('layout.kasir')
@section('content')
<title>Kasir Harian | BP3C</title>
<div class="form-group">
    <h3 style="color:#16aaff;font-weight:700;text-align:center;">{{$tanggal}}</h3>
</div>
<div class="form-group d-flex align-items-center justify-content-center">
    <div>
        <a 
            type="button"
            class="btn btn-outline-inverse-info"
            data-toggle="modal"
            data-target="#myPendapatan"
            title="Cari Pendapatan">
            <i class="mdi mdi-magnify btn-icon-append"></i>  
        </a>
    </div>
    &nbsp;
    <div>
        <button
            type="button"
            class="btn btn-outline-inverse-info"
            data-toggle="modal"
            data-target="#myPenerimaan"
            title="Penerimaan Harian">
            <i class="mdi mdi-printer btn-icon-append"></i>  
        </button>
    </div>
    &nbsp;
    <div>
        <a
            type="button"
            class="btn btn-outline-inverse-info"
            href="{{url('kasir/harian/data/perkiraan')}}"
            title="Data Perkiraan">
            <i class="mdi mdi-table-edit btn-icon-append"></i>  
        </a>
    </div>
</div>
<div id="container">
    <div id="qr-result" hidden="">
        <input hidden id="outputData"></input>
    </div>
    <canvas hidden="" id="qr-canvas"></canvas>
</div>
<span class="form_result"></span>
<form id="form_harian" >
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div id="newRow"></div>
            <button id="addRow" type="button" class="btn btn-primary btn-rounded btn-icon float-right"><i class="mdi mdi-plus"></i></button>
            <br><br>
            <div class="form-group col-lg-12">
                <label for="laporan">Laporan (opsional)</label>
                <textarea autocomplete="off" name="laporan" class="form-control" id="laporan" placeholder="Masukkan Keterangan Disini . . ." style="height:15vh"></textarea>
            </div>
            <div class="form-group col-lg-12">
                <label for="transaksi">Tanggal Transaksi</label>
                <input type="date" name="transaksi" class="form-control" id="transaksi" placeholder="Masukkan Keterangan Disini . . ." />
            </div>
        </div>  
    </div>
    <br>
    <div class="col-lg-12" style="text-align:center;">
        <input type="submit" class="btn btn-primary mr-2" value="Submit" />
    </div>
</form>
<br>
<span class="form_result"></span>

<div
    class="modal fade"
    id="myPenerimaan"
    tabIndex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Penerimaan Harian</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('kasir/harian/penerimaan')}}" target="_blank" method="GET">
                <div class="modal-body-short">
                    <div class="form-group col-lg-12">
                        <br>
                        <input
                            required
                            placeholder="Masukkan Tanggal Penerimaan" class="form-control" type="text" onfocus="(this.type='date')"
                            autocomplete="off"
                            type="date"
                            name="tgl_penerimaan"
                            id="tgl_penerimaan">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Cetak</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div
    class="modal fade"
    id="myPendapatan"
    tabIndex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pencarian Pendapatan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('kasir/harian/pendapatan')}}" method="GET">
                <div class="modal-body-short">
                    <div class="form-group col-lg-12">
                        <br>
                        <input
                            required
                            placeholder="Masukkan Tanggal Pendapatan" class="form-control" type="text" onfocus="(this.type='date')"
                            autocomplete="off"
                            type="date"
                            name="tgl_pendapatan"
                            id="tgl_pendapatan">
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
    var i = 0;
    $("#addRow").click(function () {
        var html = '';
        html += '<div class="form-group col-lg-12">';
        html += '<div id="inputFormRow" class="inputFormRow">';
        html += '<label>&nbsp;</label>';
        html += '<div class="input-group mb-3">';
        html += '<div class="input-group-append" style="width:50vh">';
        html += '<select class="title form-control m-input" name="title[]" required> @foreach($perkiraan as $d) <option value="{{$d->id}}">{{$d->nama}} - ({{$d->jenis}})</option> @endforeach </select>';
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
});

</script>
<script src="{{asset('js/kasir-harian.js')}}"></script>
@endsection