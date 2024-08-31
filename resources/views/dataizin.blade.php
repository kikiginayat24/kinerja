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
                    <div class="card-body border-bottom py-3">
                        <div class="d-flex">
                          <div class="ms-auto text-secondary">
                            Search:
                            <form action="/admin/history/izin" method="get">
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
                            @foreach ($getIzin as $izin)
                            <tr>
                              <td>{{$loop->iteration + $getIzin->firstItem()-1}}</td>
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
                                  <a href="{{route('izin.delete', $izin->id)}}" class="btn btn-danger btn-sm" onclick="alert('Apakah anda yakin ingin menghapus data?')"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>Hapus</a>
                              </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="card-footer align-items-center">
                        {{ $getIzin->links('vendor.pagination.bootstrap-5')}}
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
@endsection
