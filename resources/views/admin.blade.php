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
                    <div class="d-flex">
                        <div class="m-3">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahAdmin"><svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>Tambah Admin</button>
                            {{-- <button class="btn btn-primary"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>Cetak Semua Kartu GTK</button> --}}
                        </div>
                    </div>
                    <hr class="m-0">
                    <div class="table-responsive">
                      <table class="table table-vcenter card-table">
                        <thead>
                          <tr>
                            <th>NPA-PGRI</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Akses</th>
                            <th style="width: 300px"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($getAdmin as $admin)
                            <tr>
                              <td>{{$admin->id}}</td>
                              <td>
                                {{$admin->name}}
                              </td>
                              <td class="text-secondary"><a href="mailto:{{$admin->email}}" class="text-reset">{{$admin->email}}</a></td>
                              <td class="text-secondary">
                                {{$admin->akses}}
                              </td>
                              <td>
                                <a class="btn btn-warning btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#editAdmin{{$admin->id}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>Edit</a>
                                <a class="btn btn-danger btn-sm" href="{{route('admin.delete', $admin->id)}}" onclick="alert('Apakah Ingin Menghapus Data Ini?')"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>Delete</a>
                              </td>
                            </tr>
                            <div class="modal modal-blur fade" id="editAdmin{{$admin->id}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Edit Data Admin</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('admin.update', $admin->id)}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">ID</label>
                                                <input type="text" class="form-control" value="{{$admin->id}}" placeholder="NPA-PGRI" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Lengkap <span style="color: #FF0000;">*</span></label>
                                                <input type="text" class="form-control" name="nama" value="{{$admin->name}}" placeholder="Nama Lengkap" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">E-Mail</label>
                                                <input type="text" class="form-control" name="email" value="{{$admin->email}}" placeholder="E-Mail">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Hak Akses <span style="color: #FF0000;">*</span></label>
                                                <select type="text" name="akses" class="form-select" placeholder="Select a date" id="select-tags" value="">
                                                    <option value="">--Pilih Hak Akses--</option>
                                                    <option value="11" {{$admin->akses == "11" ? 'selected' : ''}}>Admin</option>
                                                    <option value="12" {{$admin->akses == "12" ? 'selected' : ''}}>Admin Biasa</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                                          <button type="submit" class="btn btn-primary">Save</button>
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

<div class="modal modal-blur fade" id="tambahAdmin" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah GTK</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/admin/data-admin/save" method="post">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span style="color: #FF0000;">*</span></label>
                    <input type="text" class="form-control" name="nama" placeholder="Nama Lengkap" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">E-Mail</label>
                    <input type="text" class="form-control" name="email" placeholder="E-Mail">
                </div>
                <div class="mb-3">
                    <label class="form-label">Hak Akses <span style="color: #FF0000;">*</span></label>
                    <select type="text" name="akses" class="form-select" placeholder="Select a date" id="select-tags" value="">
                        <option value="">--Pilih Hak Akses--</option>
                        <option value="11">Admin</option>
                        <option value="12">Admin Biasa</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="text" class="form-control" name="password" placeholder="Password">
                </div>
            <div class="modal-footer">
              <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection
