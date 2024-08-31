@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">History</div>
    <div class="right"></div>
</div>
<!-- * App Header -->
@endsection
@section('content')
<!-- App Capsule -->
<div id="appCapsule">
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        <div class="presencetab p-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Bulan Ini
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Semua Histori
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                        @foreach ($historyMonth as $history)
                            <li>
                                <!-- <div class="row item">
                                    <div class="col in mb-0">
                                        <span>Tanggal</span>
                                        <span>Masuk</span>
                                        <span>Keluar</span>
                                    </div>
                                </div> -->
                                <div class="row item mt-0">
                                    <!-- <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image"> -->
                                    <div class="col in">
                                        <div style="font-size: 13px !important;">{{$history->tgl_presensi}}</div>
                                        <span class="badge badge-pill badge-primary">{{$history->jam_masuk}}</span>
                                        <span class="badge badge-pill badge-danger">{{$history->jam_keluar}}</span>
                                    </div>
                                </div>
                            </li>
                            <hr class="mt-0 mb-0">
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
<!-- * App Capsule -->
@endsection
@push('history')
    <script>
        $(function(){
            $("#getData").click(function(e){
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();
                $.ajax({
                    type:"POST",
                    url:'/history/get',
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
