@extends('layout.keuangan')

@section('breadcrumb')
<title>Tagihan Fasilitas | BP3C</title>
<div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <div>
        <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item" aria-current="page">Laporan</li>
            <li class="breadcrumb-item" aria-current="page">Tagihan</li>
            <li class="breadcrumb-item active" aria-current="page">Fasilitas</li>
        </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Akumulasi Tagihan Fasilitas <span class="text-primary">{{$bulan}} (Terbaru)</span></h4>
    </div>
    <hr>
    <div class="text-center">
        <button type="button" data-toggle="modal" data-target="#myGenerate" title="Cetak Tagihan Fasilitas" class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="printer"></i> Generate</button>
    </div>
</div>
@endsection

@section('content')
<input type="hidden" id="fasilitas" value="tagihan" />
<table 
    id="tabel" 
    class="table table-bordered" 
    cellspacing="0"
    width="100%">
    <thead>
        <tr>
            <th class="wd-20p"><b>Kontrol</b></th>
            <th class="wd-25p"><b>Pedagang</b></th>
            <th class="wd-20p"><b>Ket</b></th>
            <th class="wd-15p"><b>Selisih</b></th>
        </tr>
    </thead>
</table>

<div
    class="modal fade"
    id="myRincian"
    tabIndex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="user" id="form_rincian">
                <div class="modal-header">
                    <h3 class="modal-title" id="judulRincian">Rincian</h3>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12 justify-content-between" style="display: flex;flex-wrap: wrap;">
                        <div>
                            <span style="color:#3f6ad8;"><strong>Rekening</strong></span>
                        </div>
                        <div>
                            <span style="color:#3f6ad8;"><strong>Selisih</strong></span>
                        </div>
                    </div>
                    <hr>
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
                    <div class="col-lg-12 justify-content-between" style="display:flex;flex-wrap: wrap;">
                        <div>
                            <h4 style="color:#3f6ad8;"><strong>Total Selisih</strong></h5>
                        </div>
                        <div>
                            <h4><strong><span id="nominalTotal" style="color:#3f6ad8;"></span></strong></h4>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="okbutton btn btn-primary btn-sm" data-dismiss="modal">OK</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div
    class="modal fade"
    id="myGenerate"
    tabIndex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cetak Bulan Apa ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" action="{{url('keuangan/laporan/tagihan/generate/tagihan')}}" method="GET" target="_blank">
                <div class="modal-body-short">
                    <div class="form-group col-lg-12">
                        <label for="bulan">Bulan</label>
                        <select class="form-control" name="bulan" id="bulan">
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="tahun">Tahun</label>
                        <select class="form-control" name="tahun" id="tahun">
                            @foreach($dataTahun as $d)
                            <option value="{{$d->thn_tagihan}}">{{$d->thn_tagihan}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary btn-sm" value="Submit" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/keuangan/laporan-tagihan.js')}}"></script>
@endsection