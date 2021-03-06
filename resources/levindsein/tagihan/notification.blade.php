@extends('layout.master')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Checking Tagihan| BP3C</title>
<span id="form_result"></span>
<div id="process" style="display:none;text-align:center;">
    <p>Please Wait, Updating <img src="{{asset('img/updating.gif')}}"/></p>
</div>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Notifikasi Checking</h6>
            <div>
                <a
                    href="{{url('tagihan')}}"
                    type="submit"
                    class="btn btn-sm btn-primary"><b>
                    <i class="fas fa-fw fa-home fa-sm text-white"></i></b>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive ">
                <table
                    class="table"
                    id="tabelTagihan"
                    width="100%"
                    cellspacing="0"
                    style="font-size:0.75rem;">
                    <thead class="table-bordered">
                        <tr>
                            <th rowspan="2">Kontrol</th>
                            <th rowspan="2">Pengguna</th>
                            <th colspan="5" class="listrik">Listrik</th>
                            <th colspan="4" class="air">Air</th>
                            <th rowspan="2" class="keamanan">Keamanan IPK (Rp.)</th>
                            <th rowspan="2" class="kebersihan">Kebersihan (Rp.)</th>
                            <th rowspan="2" style="background-color:rgba(50, 255, 255, 0.2);">Air Kotor (Rp.)</th>
                            <th rowspan="2" style="background-color:rgba(255, 50, 255, 0.2);">Lain - Lain (Rp.)</th>
                            <th rowspan="2">Via Publish</th>
                            <th rowspan="2" style="background-color:rgba(255, 212, 71, 0.2);">Jumlah (Rp.)</th>
                            <th rowspan="2">Action</th>
                        </tr>
                        <tr>
                            <th class="listrik-hover">Daya</th>
                            <th class="listrik-hover">Lalu</th>
                            <th class="listrik-hover">Baru</th>
                            <th class="listrik-hover">Pakai</th>
                            <th class="listrik-hover">Total (Rp.)</th>
                            <th class="air-hover">Lalu</th>
                            <th class="air-hover">Baru</th>
                            <th class="air-hover">Pakai</th>
                            <th class="air-hover">Total (Rp.)</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('modal')
<!-- Tambah Content pada Body modal -->
<div id="confirmModal" class="modal fade" role="dialog" tabIndex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Hapus Data Tagihan ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <span id="confirm_result"></span>
            <form id="form_destroy">
            @csrf
                <div class="modal-body-short">Pilih "Hapus" di bawah ini jika anda yakin untuk menghapus data tagihan.<br><br>
                    <div class="col-lg-12 justify-content-between" style="display:flex;flex-wrap:wrap;">
                        <div>
                            <div>
                                <input
                                    type="checkbox"
                                    name="checkListrik"
                                    id="checkListrik"
                                    value="listrik">
                                <label for="checkListrik">
                                    Listrik
                                </label>
                            </div>
                            <div>
                                <input
                                    type="checkbox"
                                    name="checkAirBersih"
                                    id="checkAirBersih"
                                    value="airbersih">
                                <label for="checkAirBersih">
                                    Air Bersih
                                </label>
                            </div>
                        </div>
                        <div>
                            <div>
                                <input
                                    type="checkbox"
                                    name="checkKeamananIpk"
                                    id="checkKeamananIpk"
                                    value="keamananipk">
                                <label for="checkKeamananIpk">
                                    Keamanan IPK
                                </label>
                            </div>
                            <div>
                                <input
                                    type="checkbox"
                                    name="checkKebersihan"
                                    id="checkKebersihan"
                                    value="kebersihan">
                                <label for="checkKebersihan">
                                    Kebersihan
                                </label>
                            </div>
                        </div>
                        <div>
                            <div>
                                <input
                                    type="checkbox"
                                    name="checkAirKotor"
                                    id="checkAirKotor"
                                    value="airkotor">
                                <label for="checkAirKotor">
                                    Air Kotor
                                </label>
                            </div>
                            <div>
                                <input
                                    type="checkbox"
                                    name="checkLain"
                                    id="checkLain"
                                    value="lain">
                                <label for="checkLain">
                                    Lain Lain
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" name="ok_button" id="ok_button" class="btn btn-danger" value="Hapus" />
                    <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div
    class="modal fade"
    id="myTagihan"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_tagihan">Edit Tagihan</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" id="form_tagihan" method="POST">
            @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-group col-lg-12">
                            <label for="kontrol">Kontrol</label>
                            <input
                                readonly
                                required
                                name="kontrol"
                                class="form-control"
                                id="kontrol">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="pengguna">Pengguna </label>
                            <input
                                required
                                name="pengguna"
                                class="form-control"
                                id="pengguna">
                        </div>
                        <hr>

                        <div id="divEditListrik">
                            <input type="hidden" name="stt_listrik" id="stt_listrik" val="" />
                            <div class="form-group col-lg-12">
                                <label for="dayaListrik">Daya Listrik <span style="color:red;">*</span></label>
                                <input
                                    autocomplete="off"
                                    type="text" 
                                    pattern="^[\d,]+$"
                                    name="dayaListrik"
                                    class="form-control"
                                    id="dayaListrik">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="awalListrik">Stand Awal Listrik <span style="color:red;">*</span></label>
                                <input
                                    autocomplete="off"
                                    type="text" 
                                    pattern="^[\d,]+$"
                                    name="awalListrik"
                                    class="form-control"
                                    id="awalListrik">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="akhirListrik">Stand Akhir Listrik <span style="color:red;">*</span></label>
                                <input
                                    autocomplete="off"
                                    type="text" 
                                    pattern="^[\d,]+$"
                                    name="akhirListrik"
                                    class="form-control"
                                    id="akhirListrik">
                            </div>
                            <hr>
                        </div>
                        
                        <div id="divEditAirBersih">
                            <input type="hidden" name="stt_airbersih" id="stt_airbersih" val="" />
                            <div class="form-group col-lg-12">
                                <label for="awalAir">Stand Awal Air <span style="color:red;">*</span></label>
                                <input
                                    autocomplete="off"
                                    type="text" 
                                    pattern="^[\d,]+$"
                                    name="awalAir"
                                    class="form-control"
                                    id="awalAir">
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="akhirAir">Stand Akhir Air <span style="color:red;">*</span></label>
                                <input
                                    autocomplete="off"
                                    type="text" 
                                    pattern="^[\d,]+$"
                                    name="akhirAir"
                                    class="form-control"
                                    id="akhirAir">
                            </div>
                            <hr>
                        </div>

                        <div id="divEditKeamananIpk">
                            <input type="hidden" name="stt_keamananipk" id="stt_keamananipk" val="" />
                            <div class="form-group col-lg-12">
                                <label for="keamananipk">Keamanan & IPK <span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input 
                                        autocomplete="off"
                                        type="text" 
                                        pattern="^[\d,]+$"
                                        name="keamananipk"
                                        class="form-control"
                                        id="keamananipk"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>
                            <div class="form-group col-lg-10">
                                <label for="dis_keamananipk">Diskon Keamanan & IPK</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input
                                        autocomplete="off"
                                        type="text" 
                                        pattern="^[\d,]+$"
                                        name="dis_keamananipk"
                                        class="form-control"
                                        id="dis_keamananipk"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>
                            <hr>
                        </div>
                        
                        <div id="divEditKebersihan">
                            <input type="hidden" name="stt_kebersihan" id="stt_kebersihan" val="" />
                            <div class="form-group col-lg-12">
                                <label for="kebersihan">Kebersihan <span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input
                                        autocomplete="off"
                                        type="text" 
                                        pattern="^[\d,]+$"
                                        name="kebersihan"
                                        class="form-control"
                                        id="kebersihan"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>
                            <div class="form-group col-lg-10">
                                <label for="dis_kebersihan">Diskon Kebersihan</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input
                                        autocomplete="off"
                                        type="text" 
                                        pattern="^[\d,]+$"
                                        name="dis_kebersihan"
                                        class="form-control"
                                        id="dis_kebersihan"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>
                            <hr>
                        </div>
                        
                        <div id="divEditAirKotor">
                            <input type="hidden" name="stt_airkotor" id="stt_airkotor" val="" />
                            <div class="form-group col-lg-12">
                                <label for="airkotor">Air Kotor <span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input
                                        autocomplete="off"
                                        type="text" 
                                        pattern="^[\d,]+$"
                                        name="airkotor"
                                        class="form-control"
                                        id="airkotor"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>
                            <hr>
                        </div>
                        
                        <div id="divEditLain">
                            <input type="hidden" name="stt_lain" id="stt_lain" val="" />
                            <div class="form-group col-lg-12">
                                <label for="lain">Lain - Lain <span style="color:red;">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                    </div>
                                    <input
                                        autocomplete="off"
                                        type="text" 
                                        pattern="^[\d,]+$"
                                        name="lain"
                                        class="form-control"
                                        id="lain"
                                        aria-describedby="inputGroupPrepend">
                                </div>
                            </div>
                            <hr>
                        </div>

                        <div class="form-group col-lg-12">
                            <label for="pesan">Pesan</label>
                            <textarea autocomplete="off" name="pesan" class="form-control" id="pesan"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                    <input type="submit" class="btn btn-primary btn-sm" name="action_btn" id="action_btn" value="Edit" />
                </div>
            </form>
        </div>
    </div>
</div>

<div
    class="modal fade"
    id="myChecking"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body-short">
                <div id="divBulan1">
                    <div class="col-lg-12 justify-content-between" style="display:flex;flex-wrap: wrap;">
                        <div>
                            <h5><strong><span id="bulan1"></span></strong></h5>
                        </div>
                        <div>
                            <h5><strong><span id="totalbulan1"></span></strong></h5>
                        </div>
                    </div>
                </div>
                <div id="divBulan2">
                    <div class="col-lg-12 justify-content-between" style="display:flex;flex-wrap: wrap;">
                        <div>
                            <h5><strong><span id="bulan2"></span></strong></h5>
                        </div>
                        <div>
                            <h5><strong><span id="totalbulan2"></span></strong></h5>
                        </div>
                    </div>
                </div>
                <div id="divBulan3">
                    <div class="col-lg-12 justify-content-between" style="display:flex;flex-wrap: wrap;">
                        <div>
                            <h5><strong><span id="bulan3"></span></strong></h5>
                        </div>
                        <div>
                            <h5><strong><span id="totalbulan3"></span></strong></h5>
                        </div>
                    </div>
                </div>
                <div id="divBulan4">
                    <div class="col-lg-12 justify-content-between" style="display:flex;flex-wrap: wrap;">
                        <div>
                            <h5><strong><span id="bulan4"></span></strong></h5>
                        </div>
                        <div>
                            <h5><strong><span id="totalbulan4"></span></strong></h5>
                        </div>
                    </div>
                </div>
                <div id="divBulan5">
                    <div class="col-lg-12 justify-content-between" style="display:flex;flex-wrap: wrap;">
                        <div>
                            <h5><strong><span id="bulan5"></span></strong></h5>
                        </div>
                        <div>
                            <h5><strong><span id="totalbulan5"></span></strong></h5>
                        </div>
                    </div>
                </div>
                <div id="divBulan6">
                    <div class="col-lg-12 justify-content-between" style="display:flex;flex-wrap: wrap;">
                        <div>
                            <h5><strong><span id="bulan6"></span></strong></h5>
                        </div>
                        <div>
                            <h5><strong><span id="totalbulan6"></span></strong></h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 justify-content-between" style="display:flex;flex-wrap: wrap;">
                    <div>
                        <h4><strong><span id="bulanini" style="color:#3f6ad8;"></span></strong></h4>
                    </div>
                    <div>
                        <h4><strong><span id="totalbulanini" style="color:#3f6ad8;"></span></strong></h4>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="okbutton btn btn-primary btn-sm" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<!-- Tambah Content pada Body JS -->
<script src="{{asset('js/notification-checking.js')}}"></script>
@endsection