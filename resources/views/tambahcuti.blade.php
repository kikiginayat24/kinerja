@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin/Sakit</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<!-- App Capsule -->
<div id="appCapsule">
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            <form action="/cuti/tambah/save" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col">
                        @php
                        $messageSuccess = Session::get('success');
                        $messageError = Session::get('error');
                        @endphp
                        @if(Session::get('success'))
                            <div class="alert alert-info mb-2" role="alert">
                              {{$messageSuccess}}
                            </div>
                        @elseif (Session::get('error'))
                            <div class="alert alert-warning mb-2" role="alert">
                              {{$messageError}}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label">Jenis Cuti  <span style="color:#FF0000;">*</span></label>
                    <div class="col-sm-10">
                        <select class="custom-select" name="jenis" id="jenis">
                            @foreach ($jenisCuti as $cuti)
                            <option value="{{$cuti->kode}}">{{$cuti->jenis}} - {{$cuti->hari}} Hari</option>
                            @endforeach
                          </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="judul" class="col-sm-2 col-form-label">Tanggal Cuti <span style="color:#FF0000;">*</span></label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" required>
                        <span class="text-muted">Tanggal Awal <span style="color:#FF0000;">*</span></span>
                    </div>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" required>
                        <span class="text-muted">Tanggal Akhir <span style="color:#FF0000;">*</span></span>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="foto" class="col-sm-2 col-form-label">Dokumen Pendukung <span style="color:#FF0000;">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" name="dokumen" id="dokumen" accept=".png, .jpg, .jpeg, .pdf" required>
                    </div>
                </div>
                <hr>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<div class="row mb-5"></div>
<div class="row mb-5"></div>
<!-- * App Capsule -->
@endsection
