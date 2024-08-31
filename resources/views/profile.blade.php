@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Profile</div>
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
            <div class="row">
                <div class="col">
                    @if (!empty(Auth::guard('gtk')->user()->foto))
                    @php
                    $path = Storage::url('uploads/foto_gtk/'.Auth::guard('gtk')->user()->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="mx-auto d-block imaged w120 rounded thumb-post">
                    @else
                    <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="mx-auto d-block imaged w120 rounded">
                    @endif
                    <h2 class="text-center mt-2 mb-0">{{$data->nama_lengkap}}</h2>
                    <p class="text-center text-muted">NPA. {{$data->id_user}}</p>
                </div>
            </div>
            @php
                $messageSuccess = Session::get('success');
                $messageError = Session::get('error');
            @endphp
            @if(Session::get('success'))
                <div class="alert alert-info" role="alert">
                  {{$messageSuccess}}
                </div>
            @elseif (Session::get('error'))
                <div class="alert alert-warning" role="alert">
                  {{$messageError}}
                </div>
            @endif
            <div class="row">
                <div class="col">
                    <a href="/profile/edit" class="btn btn-secondary btn-sm mb-2"><ion-icon name="create"></ion-icon>Edit Profil</a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>
                                    Jenis Kelamin
                                </th>
                                <th>
                                    :
                                </th>
                                <td>
                                    @php
                                        if($data->jk == "11"){
                                            echo "Laki-Laki";
                                        } else if ($data->jk == "12") {
                                            echo "Perempuan";
                                        }
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    TMT
                                </th>
                                <th>
                                    :
                                </th>
                                <td>
                                    {{$data->tmt}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Jabatan
                                </th>
                                <th>
                                    :
                                </th>
                                <td>
                                    {{$data->jabatan}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Nomor HP
                                </th>
                                <th>
                                    :
                                </th>
                                <td>
                                    {{$data->no_hp}}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Satminkal
                                </th>
                                <th>
                                    :
                                </th>
                                <td>
                                    SMA PGRI Cicalengka
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- * App Capsule -->
@endsection
