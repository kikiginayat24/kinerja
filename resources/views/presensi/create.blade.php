@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    @if ($cek_presensi > 0)
    <div class="pageTitle">Presensi Keluar</div>
    @else
    <div class="pageTitle">Presensi Masuk</div>
    @endif
    <div class="right"></div>
</div>
<!-- * App Header -->
<style>
    .webcam-capture, .webcam-capture video {
        display: inline-block;
        width: 100% !important;
        height: auto !important;
        border-radius: 15px;
    }

    #map {
        height: 180px;
        border-radius: 15px;
    }

</style>
@endsection
@section('content')
<!-- App Capsule -->
<div id="appCapsule">
    <div class="section full mt-2">
        <div class="section-title">Title</div>
        <div class="wide-block pt-2 pb-2">
            @if ($cek_presensi < 1)
            <div class="row">
                <div class="col">
                    <select class="custom-select custom-select-sm mb-3" id="jenis_presensi">
                      <option value="11223">Dinas Dalam</option>
                      <option value="32211">Dinas Luar</option>
                    </select>
                </div>
            </div>
            @endif
            @php
                $message = Session::get('warning');
            @endphp
            @if(Session::get('warning'))
                <div class="alert alert-warning" role="alert">
                  {{$message}}
                </div>
            @endif
           <div class="row">
                <div class="col">
                    <input type="hidden" name="lokasi" id="lokasi">
                    <div class="webcam-capture"></div>
                </div>
           </div>
           <div class="row">
               <div class="col">
                   <div class="mb-2 mt-3" id="map"></div>
               </div>
           </div>
           <div class="row">
                @if ($cek_presensi > 0)
                    <button id="takepulang" class="btn btn-danger btn-block mb-5"> <ion-icon name="camera-outline"></ion-icon>Capture</button>
                @else
                    <button id="takeabsen" class="btn btn-success btn-block mb-5"> <ion-icon name="camera-outline"></ion-icon>Capture</button>
                @endif
           </div>
           <div class="row mb-3"></div>
        </div>
    </div>
</div>
<!-- * App Capsule -->
@endsection

@push('webcam')
<script>
    Webcam.set({
        height:480,
        width:640,
        image_format:'jpeg',
        jpeg_quality:80
    });

    Webcam.attach('.webcam-capture');

    var lokasi = document.getElementById('lokasi');
    if (navigator.geolocation){
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position){
        lokasi.value = position.coords.latitude+ "," +position.coords.longitude;
        var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 16);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        var circle = L.circle([-6.981878, 107.829737], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 80
        }).addTo(map);
    }

    function errorCallback(){

    }

    $('#takeabsen').click(function(e){
        Webcam.snap(function(uri){
            image = uri;
        });
        // var jenis_presensi = $('#jenis_presensi').val();
        var selectItem = document.getElementById('jenis_presensi');
        var jenis_presensi = selectItem.value;
        var lokasi = $('#lokasi').val();
        $.ajax({
            type:'POST',
            url:"{{route('presensi.save')}}",
            data:{
                _token:"{{csrf_token()}}",
                image:image,
                lokasi:lokasi,
                jenis_presensi:jenis_presensi
            },
            cache:false,
            success:function(respond){
                var status = respond.split("|");
                if (status[0] == 'success'){
                    Swal.fire({
                      title: 'Success',
                      text: status[1],
                      icon: 'success',
                      confirmButtonText: 'OK'
                    })
                    setTimeout("location.href='/dashboard'",3000);
                } else {
                    Swal.fire({
                      title: 'Error',
                      text: status[1],
                      icon: 'error',
                      confirmButtonText: 'OK'
                    })
                }
            }
        });
    });
    $('#takepulang').click(function(e){
        Webcam.snap(function(uri){
            image = uri;
        });
        var lokasi = $('#lokasi').val();
        $.ajax({
            type:'POST',
            url:"{{route('presensi.save')}}",
            data:{
                _token:"{{csrf_token()}}",
                image:image,
                lokasi:lokasi,
            },
            cache:false,
            success:function(respond){
                var status =respond.split("|");
                if (status[0] == 'success'){
                    Swal.fire({
                      title: 'Success',
                      text: status[1],
                      icon: 'success',
                      confirmButtonText: 'OK'
                    })
                    setTimeout("location.href='/dashboard'",3000);
                } else {
                    Swal.fire({
                      title: 'Error',
                      text: status[1],
                      icon: 'error',
                      confirmButtonText: 'OK'
                    })
                }
            }
        });
    });
</script>
@endpush