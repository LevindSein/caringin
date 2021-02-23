@extends('layout.master')
@section('head')
<!-- Tambah Content Pada Head -->
@endsection

@section('content')
<!-- Tambah Content Pada Body Utama -->
<title>Neraca | BP3C</title>
<span id="form_result"></span>
<div class = "container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Neraca</h6>
            <div>
                <button 
                    type="button"
                    name="saldo"
                    id="saldo" 
                    class="btn btn-sm btn-success"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Saldo</b></button>
                &nbsp;
                <button 
                    type="button"
                    name="debit"
                    id="debit" 
                    class="btn btn-sm btn-warning"><b>
                    <i class="fas fa-fw fa-plus fa-sm text-white-50"></i> Debit</b></button>
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
                            <th>Record</th>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                            <th>Sisa Tagihan</th>
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
    id="myModal"
    tabIndex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title titles" id="exampleModalLabel"></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form class="user" id="form_neraca" method="POST">
                <div class="modal-body-short">
                    @csrf
                    <div class="col-lg-12">
                        <div class="input-group" id="myDiv3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="inputGroupPrepend">Rp.</span>
                            </div>
                            <input 
                                type="text" 
                                autocomplete="off" 
                                class="form-control"
                                name="nominal"
                                id="nominal"
                                maxlength="19"
                                placeholder="Masukkan Nominal"
                                aria-describedby="inputGroupPrepend">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="action" id="action" />
                    <input type="submit" class="btn btn-primary btn-sm" name="action_btn" id="action_btn" value="Tambah" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/neraca.js')}}"></script>
@endsection