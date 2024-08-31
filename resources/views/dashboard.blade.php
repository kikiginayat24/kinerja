@extends('layouts.presensi')
@section('content')
<div class="section" id="user-section">
    <div class="container-greetings clearfix">
    @if (date("H")<12)
            <div class="float-left">
                    <lord-icon
                    src="https://cdn.lordicon.com/ucjpmssl.json"
                    trigger="loop"
                    delay="1000"
                    style="width:45px;height:45px">
                </lord-icon>
                <span class="greeting vertical-center ml-1">Selamat Pagi</span>
            </div>
    @elseif (date("H")>=12 && date("H")<15)
        <div class="float-left">
                <lord-icon
                src="https://cdn.lordicon.com/ucjpmssl.json"
                trigger="loop"
                delay="1000"
                style="width:45px;height:45px">
            </lord-icon>
            <span class="greeting vertical-center ml-1">Selamat Siang</span>
        </div>
    @elseif (date("H")>=15 && date("H")<18)
        <div class="float-left">
            <lord-icon
                src="https://cdn.lordicon.com/ucjpmssl.json"
                trigger="loop"
                delay="1000"
                style="width:45px;height:45px">
            </lord-icon>
            <span class="greeting vertical-center ml-1">Selamat Sore</span>
        </div>
    @else
        <div class="float-left">
            <lord-icon
                src="https://cdn.lordicon.com/wibvszhx.json"
                trigger="loop"
                delay="1000"
                style="width:45px;height:45px">
            </lord-icon>
            <span class="greeting vertical-center ml-1">Selamat Malam</span>
        </div>
        @endif
        <div class="float-right">
            <a href="/logout" class="white" style="font-size: 25px;">
                <ion-icon name="log-out-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="user-detail">
        <div class="avatar">
            @if (!empty(Auth::guard('gtk')->user()->foto))
            @php
            $path = Storage::url('uploads/foto_gtk/'.Auth::guard('gtk')->user()->foto);
            @endphp
            <img src="{{ url($path) }}" alt="avatar" class="imaged w64 rounded thumb-post">
            @else
            <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w64 rounded">
            @endif
        </div>
        <div id="user-info">
            <h2 id="user-name">{{Auth::guard('gtk')->user()->nama_lengkap}}</h2>
            <span id="user-role">{{Auth::guard('gtk')->user()->jabatan}}</span>
        </div>
    </div>
</div>

<div class="section" id="menu-section">
    <div class="card">
        <div class="card-body text-center">
            <span class="mt-0 mb-0" id="jam"></span>

            <p class="mt-0 mb-0">Lokasi : SMA PGRI Cicalengka</p>
            <!-- <p class="mt-0 mb-0">Radius Realtime : <span id="radius"></span> Meter</p> -->
            <p>Dinas :
                @php
                if ($presensiToday->jenis_presensi ?? ''){
                    if ($presensiToday->jenis_presensi=="11223"){
                        echo "Dalam";
                    } else {
                        echo "Luar";
                    }
                }
                @endphp
            </p>
            <hr>
            <div class="list-menu">
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="/izin" class="green" style="font-size: 35px;">
                            <ion-icon name="bed"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center" style="font-size:14px;">Izin/Sakit</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="/cuti" class="danger" style="font-size: 35px;">
                            <ion-icon name="calendar-number"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center" style="font-size:14px;">Cuti</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="/kegiatan" class="warning" style="font-size: 35px;">
                            <ion-icon name="document-text"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name">
                        <span class="text-center" style="font-size:14px;">Kegiatan</span>
                    </div>
                </div>
                <div class="item-menu text-center">
                    <div class="menu-icon">
                        <a href="#" class="orange" style="font-size: 35px;">
                            <ion-icon name="settings"></ion-icon>
                        </a>
                    </div>
                    <div class="menu-name" style="font-size:14px;">
                        Pengaturan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="section mt-2" id="presence-section">
    <div class="todaypresence">
        <div class="row">
            <div class="col-6">
                <div class="card gradasigreen">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                <ion-icon name="camera"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Masuk</h4>
                                <span style="font-size: 12px;">{{$presensiToday != NULL ? $presensiToday->jam_masuk : 'Belum Absen'}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card gradasired">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence">
                                <ion-icon name="camera"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="presencetitle">Pulang</h4>
                                <span style="font-size: 12px;">{{$presensiToday != NULL && $presensiToday->jam_keluar !== NULL ? $presensiToday->jam_keluar : 'Belum Absen'}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rekappresence">
        <div class="row">
            <div class="col-12 text-center">
                <p class="text-muted">Rekap Bulan {{$namaBulan[$thisMonth-1]}} {{$thisYear}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence primary">
                                <ion-icon name="log-in"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Hadir</h4>
                                <span class="rekappresencedetail">{{$rekapPresensi->jumlahHadir}} Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence green">
                                <ion-icon name="document-text"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Izin</h4>
                                <span class="rekappresencedetail">{{$rekapIzin}} Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence warning">
                                <ion-icon name="sad"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Sakit</h4>
                                <span class="rekappresencedetail">{{$rekapSakit}} Hari</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <div class="presencecontent">
                            <div class="iconpresence danger">
                                <ion-icon name="alarm"></ion-icon>
                            </div>
                            <div class="presencedetail">
                                <h4 class="rekappresencetitle">Terlambat</h4>
                                <span class="rekappresencedetail">{{$rekapTelat->jumlahTelat}} x</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="chartdiv"></div>
        <div class="row mb-5"></div>
        <div class="row mb-5"></div>
    </div>
</div>
@endsection
@push('statistic')
<script>
        am4core.ready(function () {

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end

            var chart = am4core.create("chartdiv", am4charts.PieChart3D);
            chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

            chart.legend = new am4charts.Legend();

            chart.data = [
                {
                    kategori: "Hadir",
                    jumlah: "{{$rekapPresensi->jumlahHadir}}"
                },
                {
                    kategori: "Sakit",
                    jumlah: "{{$rekapSakit}}"
                },
                {
                    kategori: "Izin",
                    jumlah: "{{$rekapIzin}}"
                },
            ];
            var series = chart.series.push(new am4charts.PieSeries3D());
            series.dataFields.value = "jumlah";
            series.dataFields.category = "kategori";
            series.alignLabels = false;
            series.labels.template.text = "{value.percent.formatNumber('#.0')}%";
            series.labels.template.radius = am4core.percent(-40);
            series.labels.template.fill = am4core.color("white");
            series.colors.list = [
                am4core.color("#1171ba"),
                am4core.color("#fca903"),
                am4core.color("#37db63"),
                am4core.color("#ba113b"),
            ];
        }); // end am4core.ready()
    </script>
@endpush
