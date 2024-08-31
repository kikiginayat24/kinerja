@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Tambah Kegiatan</div>
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
            <form action="/kegiatan/tambah/save" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group row">
                    <label for="judul" class="col-sm-2 col-form-label">Judul Kegiatan <span style="color:#FF0000;">*</span></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="judul" id="judul" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="jurnal" class="col-sm-2 col-form-label">Jurnal Kegiatan <span style="color:#FF0000;">*</span></label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="jurnal" name="jurnal" rows="3" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="foto" class="col-sm-2 col-form-label">Foto Kegiatan <span style="color:#FF0000;">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" name="foto" id="foto" accept=".png, .jpg, .jpeg" required>
                    </div>
                </div>
                @if ($cekJenis->jenis_presensi == "32211")
                <div class="form-group row">
                    <label for="st" class="col-sm-2 col-form-label">Surat Tugas <span style="color:#FF0000;">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" name="st" id="st" accept=".pdf" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="sppd" class="col-sm-2 col-form-label">Dokumen SPPD <span style="color:#FF0000;">*</span></label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" name="sppd" id="sppd" accept=".pdf" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="undangan" class="col-sm-2 col-form-label">Surat Undangan <i>(Optional)</i></label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" name="undangan" id="undangan" accept=".pdf">
                    </div>
                </div>
                @endif
                <hr>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <div class="row mb-5"></div>
    <div class="row mb-5"></div>
</div>
<!-- * App Capsule -->
@endsection

