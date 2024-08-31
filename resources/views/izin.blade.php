@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Pengajuan Izin / Sakit</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<div class="fab-button bottom-right" style="margin-bottom:60px;">
    <a href="/izin/tambah" class="fab">
        <ion-icon name="add"></ion-icon>
    </a>
</div>
<!-- App Capsule -->
<div id="appCapsule">
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        @php
            $messageSuccess = Session::get('success');
            $messageError = Session::get('error');
        @endphp
        @if(Session::get('success'))
            <div class="alert alert-info mt-2" role="alert">
              {{$messageSuccess}}
            </div>
        @elseif (Session::get('error'))
            <div class="alert alert-warning mt-02" role="alert">
              {{$messageError}}
            </div>
        @endif
        <div class="presencetab p-2">
            <ul class="listview image-listview">
                @foreach ($dataIzin as $izin)
                    <li>
                        <div class="item">
                            <div class="in">
                                <div>{{$izin->status == '12' ? "Sakit" : "Izin"}}</div>
                                <div class="text-muted">{{$izin->tgl_awal}} {{$izin->tgl_akhir == NULL ? "" : "s/d"}} {{$izin->tgl_akhir}}</div>
                                @php
                                if($izin->status_approved == "12"){
                                    $status = "Diajukan";
                                    $badge = "warning";
                                } else if ($izin->status_approved == "13"){
                                    $status = "Diterima";
                                    $badge = "success";
                                } else if ($izin->status_approved == "14"){
                                    $status = "Ditolak";
                                    $badge = "danger";
                                }

                                @endphp
                                <span class="badge badge-{{$badge}}">{{$status}}</span>
                            </div>
                        </div>
                    </li>
                    <hr class="m-0">
                @endforeach
            </ul>
        </div>
    </div>
</div>
<div class="row mb-5"></div>
<div class="row mb-5"></div>
<!-- * App Capsule -->
@endsection
