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
                    <div class="d-flex m-3">
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahJadwal">Tambah Jadwal</button>
                    </div>
                    <div class="table-responsive">
                      <table class="table table-vcenter card-table">
                        <thead>
                          <tr>
                            <th>Hari</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th style="width: 150px"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($jadwalGuru as $jadwal)
                            <tr>
                              <td>{{$hari[$jadwal->kode_hari]}}</td>
                              <td class="text-secondary">
                                {{$jadwal->jam_masuk}}
                              </td>
                              <td class="text-secondary">
                                {{$jadwal->jam_keluar}}
                              </td>
                              <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editJadwal{{$jadwal->id}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>Edit</button>
                                <a href="{{route('jadwal.delete', $jadwal->id)}}" class="btn btn-danger btn-sm" onclick="alert('Apakah Ingin Menghapus Data Ini?')"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>Delete</a>
                              </td>
                            </tr>
                            <div class="modal modal-blur fade" id="editJadwal{{$jadwal->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Edit Jadwal</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('jadwal.update', $jadwal->id)}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <input type="hidden" name="id_user" value="{{$jadwal->id_user}}">
                                            <div class="mb-3">
                                                <label class="form-label">Hari</label>
                                                <select type="text" name="hari" class="form-select" placeholder="Select a date" id="select-tags" value="">
                                                    <option value="">--Pilih Hari--</option>
                                                    <option value="0" {{$jadwal->kode_hari == 0 ? 'selected' : ''}}>Minggu</option>
                                                    <option value="1" {{$jadwal->kode_hari == 1 ? 'selected' : ''}}>Senin</option>
                                                    <option value="2" {{$jadwal->kode_hari == 2 ? 'selected' : ''}}>Selasa</option>
                                                    <option value="3" {{$jadwal->kode_hari == 3 ? 'selected' : ''}}>Rabu</option>
                                                    <option value="4" {{$jadwal->kode_hari == 4 ? 'selected' : ''}}>Kamis</option>
                                                    <option value="5" {{$jadwal->kode_hari == 5 ? 'selected' : ''}}>Jum'at</option>
                                                    <option value="6" {{$jadwal->kode_hari == 6 ? 'selected' : ''}}>Sabtu</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jam Masuk</label>
                                                <input type="time" class="form-control" value="{{$jadwal->jam_masuk}}" name="jam_masuk">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jam Keluar</label>
                                                <input type="time" class="form-control" value="{{$jadwal->jam_keluar}}" name="jam_keluar">
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
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</div>
<div class="modal modal-blur fade" id="tambahJadwal" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Jadwal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('jadwal.tambah')}}" method="post">
            @csrf
            <div class="modal-body">
                <input type="hidden" name="id_user" value="{{$guru->id_user}}">
                <div class="mb-3">
                    <label class="form-label">Hari</label>
                    <select type="text" name="hari" class="form-select" placeholder="Select a date" id="select-tags" value="">
                        <option value="">--Pilih Hari--</option>
                        <option value="0">Minggu</option>
                        <option value="1">Senin</option>
                        <option value="2">Selasa</option>
                        <option value="3">Rabu</option>
                        <option value="4">Kamis</option>
                        <option value="5">Jum'at</option>
                        <option value="6">Sabtu</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam Masuk</label>
                    <input type="time" class="form-control" name="jam_masuk">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jam Keluar</label>
                    <input type="time" class="form-control" name="jam_keluar">
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
@endsection
