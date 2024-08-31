@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Kegiatan</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<!-- App Capsule -->
<div class="fab-button bottom-right" style="margin-bottom:60px;">
    <a href="kegiatan/tambah" class="fab">
        <ion-icon name="add"></ion-icon>
    </a>
</div>
<div id="appCapsule">
    <div class="section full">
        <div class="section-title">Title</div>
        @if ($cekAbsen<1)
        <div class="alert alert-warning mt-5 m-2" role="alert">
            {{$pesan}}
        </div>
        @else
            <div class="row mt-2">
                <div class="col">
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
                    <div class="presencetab p-1">
                        <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                            <ul class="nav nav-tabs style1" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                        Hari Ini
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                        History Kegiatan
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content mt-2" style="margin-bottom:100px;">
                            <div class="tab-pane fade show active" id="home" role="tabpanel">
                                <ul class="listview image-listview">
                                    @if ($kegiatanHari->isEmpty())
                                        <div class="alert alert-warning" role="alert">
                                            Belum Ada Kegiatan Pada Hari Ini!
                                        </div>
                                    @endif
                                    @foreach ($kegiatanHari as $kegiatan)
                                        <li>
                                            <a href="{{route('kegiatan.detail',$kegiatan->id)}}" class="item">
                                                <div>
                                                    <p class="truncate">{{$kegiatan->judul}}</p>
                                                    <p class="text-muted mb-0">{{$kegiatan->tanggal}} {{$kegiatan->jam}}</p>
                                                </div>
                                            </a>
                                            <hr class="m-0">
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel">
                                <div class="input-group mb-1">
                                    <select class="custom-select" id="bulan" style="font-size: 13px !important;">
                                        <option selected>Bulan</option>
                                        @for ($i=1; $i<=12; $i++)
                                        <option value="{{$i}}" {{date("m") == $i ? 'selected' : ''}}>{{$namaBulan[$i]}}</option>
                                        @endfor
                                    </select>
                                    <select class="custom-select" id="tahun" style="font-size: 13px !important;">
                                        <option selected>Tahun</option>
                                        @for ($i=2024; $i<=date("Y"); $i++)
                                        <option value="{{$i}}" {{date("Y") == $i ? 'selected' : ''}}>{{$i}}</option>
                                        @endfor
                                    </select>
                                    <br>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm mb-1" id="getData"><ion-icon name="search"></ion-icon>Search</button>
                                <div id="showHistory"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- * App Capsule -->
@endsection
@push('kegiatan')
    <script>
        $(function(){
            $("#getData").click(function(e){
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();
                $.ajax({
                    type:"POST",
                    url:'/kegiatan/get',
                    data:{
                        _token: "{{csrf_token()}}",
                        bulan: bulan,
                        tahun: tahun
                    },
                    cache:false,
                    success:function(respond){
                        $('#showHistory').html(respond);
                    }
                });
            });
        });
    </script>
@endpush
