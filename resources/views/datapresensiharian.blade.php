@extends('layouts.admin.tabler')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-12">
                    <div class="card">
                      <div class="card-header">
                        <h3 class="card-title">Data Presensi {{date("d M Y")}}</h3>
                      </div>
                      <div class="card-body border-bottom py-3">
                        <div class="d-flex">
                          <div class="ms-auto text-secondary">
                            Search:
                            <form action="/admin/data/presensiHarian" method="get">
                                <div class="ms-2 d-inline-block">
                                    <input type="text" name="nama" class="form-control form-control-sm" placeholder="Nama Lengkap" aria-label="Search guru" value="{{Request('nama')}}">
                                </div>
                                <div class="ms-2 d-inline-block">
                                    <button type="submit" class="btn btn-primary btn-sm"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg> Search</button>
                                </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable">
                          <thead>
                            <tr>
                              <th class="w-1">No. <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-sm icon-thick"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 15l6 -6l6 6"></path></svg>
                              </th>
                              <th>Id Presensi</th>
                              <th>Nama Guru</th>
                              <th>Presensi Masuk</th>
                              <th>Presensi Keluar</th>
                              <th>Status</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>
                            @php
                                $x=1;
                            @endphp
                            @foreach ($dataPresensi as $presensi)
                            <tr>
                              <td><span class="text-secondary">{{$loop->iteration + $dataPresensi->firstItem()-1}}</span></td>
                              <td>{{$presensi->id}}</td>
                              <td>
                                {{$presensi->nama_lengkap}}
                              </td>
                              <td>
                                {{$presensi->jam_masuk}}
                              </td>
                              <td>
                                {{$presensi->jam_keluar}}
                              </td>
                              <td>
                                @php
                                    if($presensi->status_presensi == "TEPAT"){
                                        $badge = "success";
                                        $pesan = "Tepat Waktu";
                                    } else if ($presensi->status_presensi == "TELAT") {
                                        $badge = "danger";
                                        $pesan = "Telat";
                                    } else {
                                        $badge = "danger";
                                        $pesan = $presensi->izin;
                                    }
                                @endphp
                                <span class="badge bg-{{$badge}} me-1"></span> {{$pesan}}
                              </td>
                              <td class="text-end">
                                @if (empty($presensi->izin))
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#cekPresensi{{$presensi->id}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>Cek</button>
                                @endif
                              </td>
                            </tr>
                            <div class="modal modal-blur fade" id="cekPresensi{{$presensi->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Cek Presensi {{$presensi->nama_lengkap}}</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body mx-auto">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h3 class="text-center">Presensi Masuk</h3>
                                                <img src="/storage/uploads/absensi/{{$presensi->foto_masuk}}" alt="tes" style="width:300px;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="d-flex justify-content-between">
                                                    <span class="mt-3">Jam Masuk : {{$presensi->jam_masuk}}</span>
                                                    <a href="https://maps.google.com/?q={{$presensi->location_in}}" class="btn btn-success mt-2 mb-2" target="_blank"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-google-maps"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" /><path d="M6.428 12.494l7.314 -9.252" /><path d="M10.002 7.935l-2.937 -2.545" /><path d="M17.693 6.593l-8.336 9.979" /><path d="M17.591 6.376c.472 .907 .715 1.914 .709 2.935a7.263 7.263 0 0 1 -.72 3.18a19.085 19.085 0 0 1 -2.089 3c-.784 .933 -1.49 1.93 -2.11 2.98c-.314 .62 -.568 1.27 -.757 1.938c-.121 .36 -.277 .591 -.622 .591c-.315 0 -.463 -.136 -.626 -.593a10.595 10.595 0 0 0 -.779 -1.978a18.18 18.18 0 0 0 -1.423 -2.091c-.877 -1.184 -2.179 -2.535 -2.853 -4.071a7.077 7.077 0 0 1 -.621 -2.967a6.226 6.226 0 0 1 1.476 -4.055a6.25 6.25 0 0 1 4.811 -2.245a6.462 6.462 0 0 1 1.918 .284a6.255 6.255 0 0 1 3.686 3.092z" /></svg>Google Maps</a>
                                                </div>
                                            </div>
                                        </div>
                                        @if (!empty($presensi->jam_keluar))
                                        <div class="row mt-2">
                                            <div class="col-lg-12">
                                                <h3 class="text-center">Presensi Keluar</h3>
                                                <img src="/storage/uploads/absensi/{{$presensi->foto_keluar}}" alt="tes" style="width:300px;">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="d-flex justify-content-between">
                                                    <span class="mt-3">Jam Keluar : {{$presensi->jam_keluar}}</span>
                                                    <a href="https://maps.google.com/?q={{$presensi->location_out}}" class="btn btn-success mt-2" target="_blank"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-google-maps"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9.5m-2.5 0a2.5 2.5 0 1 0 5 0a2.5 2.5 0 1 0 -5 0" /><path d="M6.428 12.494l7.314 -9.252" /><path d="M10.002 7.935l-2.937 -2.545" /><path d="M17.693 6.593l-8.336 9.979" /><path d="M17.591 6.376c.472 .907 .715 1.914 .709 2.935a7.263 7.263 0 0 1 -.72 3.18a19.085 19.085 0 0 1 -2.089 3c-.784 .933 -1.49 1.93 -2.11 2.98c-.314 .62 -.568 1.27 -.757 1.938c-.121 .36 -.277 .591 -.622 .591c-.315 0 -.463 -.136 -.626 -.593a10.595 10.595 0 0 0 -.779 -1.978a18.18 18.18 0 0 0 -1.423 -2.091c-.877 -1.184 -2.179 -2.535 -2.853 -4.071a7.077 7.077 0 0 1 -.621 -2.967a6.226 6.226 0 0 1 1.476 -4.055a6.25 6.25 0 0 1 4.811 -2.245a6.462 6.462 0 0 1 1.918 .284a6.255 6.255 0 0 1 3.686 3.092z" /></svg>Google Maps</a>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    {{-- <div class="modal-footer">
                                      <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                                    </div> --}}
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
                      <div class="card-footer d-flex align-items-center">
                        {{ $dataPresensi->links('vendor.pagination.bootstrap-5')}}
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
