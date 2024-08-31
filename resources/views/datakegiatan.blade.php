@extends('layouts.admin.tabler')
@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="table-responsive">
                      <table class="table table-vcenter card-table">
                        <thead>
                          <tr>
                            <th>Id</th>
                            <th>Waktu</th>
                            <th>Nama GTK</th>
                            <th>Judul</th>
                            <th>Foto</th>
                            <th style="width: 200px"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($getKegiatan as $kegiatan)
                            <tr>
                              <td>{{$kegiatan->id}}</td>
                              <td class="text-muted">
                                {{$kegiatan->tanggal}} {{$kegiatan->jam}}
                              </td>
                              <td class="text-muted">
                                {{$kegiatan->nama_lengkap}}
                              </td>
                              <td class="text-muted">{{$kegiatan->judul}}</td>
                              <td class="text-muted">
                                <img src="/storage/uploads/kegiatan/foto/{{$kegiatan->fotoKegiatan}}" alt="kegiatan {{$kegiatan->fotoKegiatan}}"  style="width: 100px">
                              </td>
                              <td class="text-end">
                                <button class="btn btn-primary btn-sm"  data-bs-toggle="modal" data-bs-target="#dataKegiatan{{$kegiatan->id}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>Cek</button>
                                <a href="{{route('kegiatan.delete', $kegiatan->id)}}" onclick="alert('Apakah anda yakin akan menghapus data ini?')" class="btn btn-danger btn-sm"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>Hapus</a>
                              </td>
                            </tr>
                            <div class="modal modal-blur fade" id="dataKegiatan{{$kegiatan->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Cek Kegiatan</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <p>ID : {{$kegiatan->id}}</p>
                                      <p>Nama : {{$kegiatan->nama_lengkap}}</p>
                                      <p>Tanggal : {{$kegiatan->tanggal}}</p>
                                      <p>Jam : {{$kegiatan->jam}}</p>
                                      <div class="d-flex justify-content-center">
                                          <img src="/storage/uploads/kegiatan/foto/{{$kegiatan->fotoKegiatan}}" alt="tes" style="width:300px;">
                                      </div>

                                        @if ($kegiatan->st != NULL)
                                            <p class="mt-3 text-center"><strong>DOKUMEN PENDUKUNG</strong></p>
                                            <div class="d-flex justify-content-evenly mt-3">
                                                <a href="/storage/uploads/kegiatan/foto/dinas-luar/surat-tugas/{{$kegiatan->st}}" class="btn btn-success" target="_blank">Surat Tugas</a>
                                                <a href="/storage/uploads/kegiatan/foto/dinas-luar/sppd/{{$kegiatan->sppd}}" class="btn btn-success" target="_blank">SPPD</a>
                                                @if ($kegiatan->undangan != NULL)
                                                <a href="/storage/uploads/kegiatan/foto/dinas-luar/undangan/{{$kegiatan->undangan}}" class="btn btn-success" target="_blank">Undangan</a>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                              </div>
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
