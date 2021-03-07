@extends('layout.kasir')
@section('content')
<title>Kasir Harian | BP3C</title>
<div class="form-group">
    <h3 style="color:#16aaff;font-weight:700;text-align:center;">Data Perkiraan</h3>
</div>
<div class="form-group d-flex align-items-center justify-content-center">
    <div>
        <a
            type="button"
            class="btn btn-outline-inverse-info"
            href="{{url('kasir/harian')}}"
            title="Home">
            <i class="mdi mdi-home btn-icon-append"></i>  
        </a>
    </div>
    &nbsp;
    <div>
        <a 
            type="button"
            class="btn btn-outline-inverse-info"
            data-toggle="modal"
            data-target="#myPerkiraan"
            title="Tambah Data">
            <i class="mdi mdi-plus btn-icon-append"></i>  
        </a>
    </div>
</div>
<div id="container">
    <div id="qr-result" hidden="">
        <input hidden id="outputData"></input>
    </div>
    <canvas hidden="" id="qr-canvas"></canvas>
</div>
<span class="html_result" id="html_result"></span>

<div class="row">
    <div class="table-responsive">
        <table 
            id="tabelKasir" 
            class="table table-bordered" 
            cellspacing="0"
            width="100%">
            <thead>
                <tr>
                    <th style="text-align:center;"><b>Kode</b></th>
                    <th style="text-align:center;"><b>Nama</b></th>
                    <th style="text-align:center;"><b>Jenis</b></th>
                    <th style="text-align:center;"><b>Action</b></th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div
    class="modal fade"
    id="myPerkiraan"
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

<div id="confirmModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Apakah yakin hapus data perkiraan?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body-short">Pilih "Hapus" di bawah ini jika anda yakin untuk menghapus data pedagang.</div>
            <div class="modal-footer">
            	<button type="button" name="ok_button" id="ok_button" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/data-perkiraan.js')}}"></script>
@endsection