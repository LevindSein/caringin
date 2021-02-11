@extends('layanan.index')

@section('breadcrumb')
<title>Registrasi | BP3C</title>
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item" aria-current="page">Layanan</li>
            <li class="breadcrumb-item active" aria-current="page">Registrasi</li>
        </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Registrasi Pelanggan</h4>
    </div>
    <hr>
</div>
@endsection

@section('content')
<span class="form_result"></span>
<form id="form_registrasi" method="POST">
    @csrf
    <div class="row justify-content-center">
        <div class="col-lg-6" style="height:55vh;overflow-y:auto">
            <div class="form-group col-lg-12">
                <label for="ktp">KTP <span style="color:red;">*</span></label>
                <div class="input-group">
                    <input
                        required
                        autocomplete="off"
                        type="tel"
                        maxlength="17"
                        class="form-control shadow require"
                        name="ktp"
                        id="ktp"
                        placeholder="Nomor KTP">
                </div>
                <br>
                <label for="nama">Nama <span style="color:red;">*</span></label>
                <div class="input-group">
                    <input 
                        required
                        type="text" 
                        autocomplete="off" 
                        class="form-control shadow require"
                        name="nama"
                        id="nama" 
                        maxlength="30"
                        placeholder="Nama Sesuai KTP">
                </div>
                <br>
                <label for="alamat">Alamat <span style="color:red;">*</span></label>
                <div class="input-group">
                    <textarea required autocomplete="off" name="alamat" class="form-control shadow require" id="alamat" maxlength="150" placeholder="Alamat Sesuai KTP"></textarea>
                </div>
                <br>
                <label for="email">Email</label>
                <div class="input-group">
                    <input
                        type="text" 
                        autocomplete="off" 
                        class="form-control shadow"
                        name="email"
                        id="email" 
                        maxlength="20"
                        placeholder="Email Jika Ada">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend">@gmail.com</span>
                    </div>
                </div>
                <br>
                <label for="hp">No. Handphone <span style="color:red;">*</span></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroupPrepend">+62</span>
                    </div>
                    <input
                        required
                        type="tel" 
                        autocomplete="off" 
                        class="form-control shadow require"
                        name="hp"
                        id="hp" 
                        maxlength="13"
                        placeholder="Nomor Aktif SMS / Whatsapp / Telegram">
                </div>
                <br>
                <label for="kontrol">Pilih Tempat <span style="color:red;">*</span></label>
                <select class="kontrol form-control" name="kontrol" id="kontrol" required></select>
            </div>
        </div>
        <div id="divTempat" class="col-lg-6" style="height:55vh;overflow-y:auto">
            <div class="form-group col-lg-12">
                <div id="process" style="display:none;text-align:center;">
                    <p>Please Wait, Searching Data <img src="{{asset('img/updating.gif')}}"/></p>
                </div>
                <div id="dataset">
                    <h3 class="text-center text-primary"><span id="kode"></span></h3>
                    <div class="form-check">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            name="keamananipk"
                            id="myCheck3"
                            data-related-item="myDiv3">
                        <label class="form-check-label" for="myCheck3">
                            Keamanan & IPK
                        </label>
                    </div>
                    <div class="form-group" style="display:none" id="displayKeamananIpk">
                        <label for="myDiv3">Kategori Tarif <span style="color:red;">*</span></label>
                        <select class="form-control" name="trfKeamananIpk" id="myDiv3">
                            <option selected hidden value="">--- Pilih Tarif ---</option>
                        </select>
                        <div class="col-sm-12">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="dis_keamananipk"
                                    id="dis_keamananipk"
                                    value="dis_keamananipk"
                                    data-related-item="diskonBayarKeamananIpk">
                                <label class="form-check-label" for="dis_keamananipk">
                                    Diskon
                                </label>
                            </div>
                            <div class="form-group" style="display:none" id="displayKeamananIpkDiskon">
                                <div class="col-sm-12" id="diskonBayarKeamananIpk">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                                        </div>
                                        <input 
                                            type="text" 
                                            autocomplete="off" 
                                            class="form-control"
                                            name="diskonKeamananIpk" 
                                            id="diskonKeamananIpk" 
                                            placeholder="Nominal" 
                                            aria-describedby="inputGroupPrepend">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <br>
    <div class="col-lg-12" style="text-align:center;">
        <input type="hidden" id="kd_kontrol" name="kd_kontrol"/>
        <input type="submit" class="btn btn-primary shadow col-lg-4" name="daftar" id="daftar" value="DAFTAR" />
    </div>
</form>
<br>
<span class="form_result"></span>
@endsection

@section('js')
<script src="{{asset('js/layanan.js')}}"></script>
@endsection