@extends('layout.master')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Kasir Harian | BP3C</title>
<span id="form_result"></span>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Perkiraan</h6>
            <div>
                <a 
                    href="{{url('master/kasir')}}" 
                    type="submit"
                    title="Home"
                    class="btn btn-sm btn-info"><b><i class="fas fa-fw fa-home fa-sm text-white"></i></b>
                </a>
                &nbsp;
                <button 
                    type="button"
                    class="btn btn-sm btn-success"
                    data-toggle="modal"
                    data-target="#myPerkiraan"
                    title="Tambah Data"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Data Perkiraan</b> 
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table
                    id="tabelKasir" 
                    class="table" 
                    cellspacing="0"
                    width="100%"
                    style="font-size:0.75rem;">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Jenis</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('modal')
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
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Perkiraan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('#')}}">
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
            <div class="modal-body-short">Pilih "Hapus" di bawah ini jika anda yakin untuk menghapus data perkiraan.</div>
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