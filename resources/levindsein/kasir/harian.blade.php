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
        <div class="col-lg-6" style="height:50vh;overflow-y:auto">
            <div class="form-group col-lg-12">
                <label for="nama">Nama <span style="color:red;">*</span></label>
                <input required type="text" class="form-control" id="nama" name="nama" maxlength="30" style="text-transform:capitalize;" placeholder="Masukkan Nama (Bukan Kasir)" autocomplete="off">
            </div>
            <div class="form-group col-lg-12">
                <label for="keamananlos"><span style="color:blue;">Keamanan LOS</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-append" style="width:10vh">
                        <input readonly class="form-control text-center" value="Rp." tabIndex="-1">
                    </div>
                    <input type="text" class="form-control" id="keamananlos" name="keamananlos" maxlength="14" placeholder="Masukkan Tarif">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <label for="kebersihanlos"><span style="color:green;">Kebersihan LOS</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-append" style="width:10vh">
                        <input readonly class="form-control text-center" value="Rp." tabIndex="-1">
                    </div>
                    <input type="text" class="form-control" id="kebersihanlos" name="kebersihanlos" maxlength="14" placeholder="Masukkan Tarif">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <label for="kebersihanpos"><span style="color:green;">Kebersihan POS</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-append" style="width:10vh">
                        <input readonly class="form-control text-center" value="Rp." tabIndex="-1">
                    </div>
                    <input type="text" class="form-control" id="kebersihanpos" name="kebersihanpos" maxlength="14" placeholder="Masukkan Tarif">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <label for="kebersihanposlebih"><span style="color:green;">Kebersihan POS LEBIH</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-append" style="width:10vh">
                        <input readonly class="form-control text-center" value="Rp." tabIndex="-1">
                    </div>
                    <input type="text" class="form-control" id="kebersihanposlebih" name="kebersihanposlebih" maxlength="14" placeholder="Masukkan Tarif">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <label for="abonemen"><span style="color:orange;">Abonemen</span></label>
                <div class="input-group mb-3">
                    <div class="input-group-append" style="width:10vh">
                        <input readonly class="form-control text-center" value="Rp." tabIndex="-1">
                    </div>
                    <input type="text" class="form-control" id="abonemen" name="abonemen" maxlength="14" placeholder="Masukkan Tarif">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <label for="laporan">Laporan (optional)</label>
                <textarea autocomplete="off" name="laporan" class="form-control" id="laporan" placeholder="Masukkan Keterangan Disini . . ." style="height:15vh"></textarea>
            </div>
        </div>
        <div class="col-lg-6" style="height:50vh;overflow-y:auto">
            <div id="newRow"></div>
            <button id="addRow" type="button" class="btn btn-primary btn-rounded btn-icon float-right"><i class="mdi mdi-plus"></i></button>
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
<script src="{{asset('js/kasir-harian.js')}}"></script>
@endsection