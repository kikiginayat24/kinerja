@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Detail Kegiatan</div>
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
            <table class="table table-bordered table-stripped">
                <tbody>
                    <tr>
                        <th>Judul</th><th>{{$detailKegiatan->id}} - {{$detailKegiatan->judul}}</th>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <!-- <span class="badge badge-warning">Disetujui</span> -->
                            <!-- &nbsp; -->
                            <span class="text-sm text-success text-bold">Revisi ke #1</span>
                        </td>
                    </tr>
                    <tr>
		    		    <th class="text-center" colspan="2">
                            Jurnal Kegiatan
		    		    </th>
                    </tr>
                    <tr>
		    		    <td colspan="2">
                            {{$detailKegiatan->jurnal}}
		    		    </td>
                    </tr>
                    </tr>
		    		<tr>
                        <th class="text-center" colspan="2">Informasi Laporan</th>
                    </tr>
                    <tr>
                        <td colspan="2">
                            @php
                                $path = Storage::url('uploads/kegiatan/foto/'.$detailKegiatan->foto);
                            @endphp
                            <img src="{{url($path)}}" alt="" style="width: 250px;">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- * App Capsule -->
@endsection
