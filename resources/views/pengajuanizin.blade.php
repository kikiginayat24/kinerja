@extends('layouts.admin.tabler')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                @php
                    $messageSuccess = Session::get('success');
                    $messageError = Session::get('error');
                    @endphp
                    @if (Session::get('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <div class="d-flex">
                          <div>
                            <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                          </div>
                          <div>
                            {{$messageSuccess}}
                          </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                    @elseif(Session::get('error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <div class="d-flex">
                          <div>
                            <!-- Download SVG icon from http://tabler-icons.io/i/check -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon alert-icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                          </div>
                          <div>
                            {{$messageError}}
                          </div>
                        </div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                    @endif
                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Izin / Sakit</h3>
                    </div>
                    <div class="table-responsive">
                      <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                          <tr>
                            <th class="w-1">No.</th>
                            <th style="width: 100px;">ID Pengajuan</th>
                            <th>Nama</th>
                            <th>Alasan</th>
                            <th>Tanggal Awal</th>
                            <th>Tanggal Akhir</th>
                            <th class="w-1"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $x=1;
                            @endphp
                            @foreach ($getIzin as $izin)
                            <tr>
                              <td>{{$x}}</td>
                              <td><span class="text-secondary">{{$izin->id}}</span></td>
                              <td>{{$izin->nama_lengkap}}</td>
                              @php
                                  if($izin->status == '12'){
                                    $alasan = "Sakit";
                                  } else {
                                    $alasan = "Izin";
                                  }
                              @endphp
                              <td>
                                {{$alasan}}
                              </td>
                              <td>
                                {{$izin->tgl_awal}}
                              </td>
                              <td>
                                {{$izin->tgl_akhir}}
                              </td>
                              <td class="text-end">
                                  <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#approveIzin{{$izin->id}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>Tinjau</button>
                              </td>
                            </tr>
                            <div class="modal modal-blur fade" id="approveIzin{{$izin->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Tinjau Permintaan</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('izin.update', $izin->id)}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="id_user" id="id_user" value="{{$izin->id_user}}">
                                            <input type="hidden" name="alasan" id="alasan" value="{{$alasan}}">
                                            <p>ID Pengajuan : {{$izin->id}}</p>
                                            <p>Nama Lengkap: {{$izin->nama_lengkap}}</p>
                                            <p>Alasan: {{$alasan}}</p>
                                            <hr class="m-1">
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Awal</label>
                                                <div class="input-icon">
                                                    <input class="form-control " placeholder="Select a date" name="tgl_awal" id="tgl_awal" value="{{$izin->tgl_awal}}">
                                                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Tanggal Akhir</label>
                                                <div class="input-icon">
                                                    <input class="form-control " placeholder="Select a date" name="tgl_akhir" id="tgl_akhir" value="{{$izin->tgl_akhir}}">
                                                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="select-tags">Hasil Tinjauan</label>
                                                <select type="text" name="status" class="form-select" placeholder="Select a date" id="select-tags" value="">
                                                    <option value="12">--Pilih Hasil Tinjauan--</option>
                                                    <option value="13">Diterima</option>
                                                    <option value="14">Ditolak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <a href="/storage/uploads/izin/{{$izin->dokumen}}" target="_blank" class="btn btn-success"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-download"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 11l5 5l5 -5" /><path d="M12 4l0 12" /></svg>Dokumen Pendukung</a>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">Save changes</button>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                              @php
                                  $x++;
                              @endphp
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('datepicker2')
<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
    	window.Litepicker && (new Litepicker({
    		element: document.getElementById('tgl_awal'),
    		buttonText: {
    			previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
    			nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
    		},
    	}));
    });
    // @formatter:on
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
    	window.Litepicker && (new Litepicker({
    		element: document.getElementById('tgl_akhir'),
    		buttonText: {
    			previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
    			nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
    		},
    	}));
    });
    // @formatter:on
  </script>
@endpush
