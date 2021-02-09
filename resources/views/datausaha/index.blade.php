@extends('layout.master')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Data Usaha | BP3C</title>
<div class = "container-fluid">
    <ul class="tabs-animated-shadow tabs-animated nav">
        <li class="nav-item">
            <a role="tab" class="nav-link active" id="tab-c-0" data-toggle="tab" href="#tab-animated-0">
                <span>Tagihan</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-c-1" data-toggle="tab" href="#tab-animated-1">
                <span>Tunggakan</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-c-2" data-toggle="tab" href="#tab-animated-2">
                <span>Bongkaran</span>
            </a>
        </li>
        <li class="nav-item">
            <a role="tab" class="nav-link" id="tab-c-3" data-toggle="tab" href="#tab-animated-3">
                <span>Penghapusan</span>
            </a>
        </li>
    </ul>
</div>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Usaha</h6>
        </div>
        <div class="card-body">
            
            <div class="tab-content">
                <div class="tab-pane active" id="tab-animated-0" role="tabpanel">
                    @include('datausaha.tagihan')
                </div>
                <div class="tab-pane" id="tab-animated-1" role="tabpanel">
                    @include('datausaha.tunggakan')
                </div>
                <div class="tab-pane" id="tab-animated-2" role="tabpanel">
                    @include('datausaha.bongkaran')
                </div>
                <div class="tab-pane" id="tab-animated-3" role="tabpanel">
                    @include('datausaha.penghapusan')
                </div>
            </div>
        </div>
    </div>    
</div>
@endsection

@section('modal')
<!-- Tambah Content pada Body modal -->
@endsection

@section('js')
<!-- Tambah Content pada Body JS -->
<script src="{{asset('js/data-usaha.js')}}"></script>
@endsection