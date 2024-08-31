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
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahGtk"><svg xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>Tambah GTK</button>
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
                            {{-- <th>Email</th> --}}
                            <th>Jabatan</th>
                            <th class="w-1">Kepegawaian</th>
                            <th style="width: 300px"></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataGtk as $gtk)
                            <tr>
                              <td>{{$gtk->id_user}}</td>
                              <td>
                                {{$gtk->nama_lengkap}}
                              </td>
                              {{-- <td class="text-secondary"><a href="mailto:{{$gtk->email}}" class="text-reset">{{$gtk->email}}</a></td> --}}
                              <td class="text-secondary">
                                {{$gtk->jabatan}}
                              </td>
                              <td>
                                {{$gtk->nama_pangkat}}
                              </td>
                              <td>
                                <a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#printGuru{{$gtk->id_user}}" target="_blank"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-printer"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2" /><path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4" /><path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z" /></svg>Print</a>
                                <a class="btn btn-success btn-sm" href="{{route('guru.jadwal', $gtk->id_user)}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-month"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M7 14h.013" /><path d="M10.01 14h.005" /><path d="M13.01 14h.005" /><path d="M16.015 14h.005" /><path d="M13.015 17h.005" /><path d="M7.01 17h.005" /><path d="M10.01 17h.005" /></svg>Jadwal</a>
                                <a class="btn btn-warning btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#editGtk{{$gtk->id_user}}"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-edit"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>Edit</a>
                                <a class="btn btn-danger btn-sm" href="{{route('guru.delete', $gtk->id_user)}}" onclick="alert('Apakah Ingin Menghapus Data Ini?')" target="_blank"><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>Delete</a>
                              </td>
                            </tr>
                            <div class="modal modal-blur fade" id="editGtk{{$gtk->id_user}}" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Edit Data GTK</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{route('guru.update', $gtk->id_user)}}" method="post">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">NPA-PGRI <span style="color: #FF0000;">*</span></label>
                                                <input type="text" class="form-control" name="npa" value="{{$gtk->id_user}}" placeholder="NPA-PGRI" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nama Lengkap <span style="color: #FF0000;">*</span></label>
                                                <input type="text" class="form-control" name="nama_lengkap" value="{{$gtk->nama_lengkap}}" placeholder="Nama Lengkap" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nomor HP</label>
                                                <input type="text" class="form-control" name="no_hp" value="{{$gtk->no_hp}}" placeholder="Nomor HP">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">E-Mail</label>
                                                <input type="text" class="form-control" name="email" value="{{$gtk->email}}" placeholder="E-Mail">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">TMT</label>
                                                <div class="input-icon mb-2">
                                                  <input class="form-control" name="tmt" value="{{$gtk->tmt}}" placeholder="TMT" id="datepicker-icon">
                                                  <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
                                                  </span>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jabatan <span style="color: #FF0000;">*</span></label>
                                                <input type="text" class="form-control" name="jabatan" value="{{$gtk->jabatan}}" placeholder="Jabatan" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Status Kepegawaian <span style="color: #FF0000;">*</span></label>
                                                <select type="text" name="pangkat" class="form-select" placeholder="Select a date" id="select-tags" value="">
                                                    <option value="">--Pilih Golongan--</option>
                                                    @foreach ($jenisPangkat as $golongan)
                                                    <option value="{{$golongan->kode}}" {{$gtk->pangkat == $golongan->kode ? 'selected' : ''}}>{{$golongan->nama_pangkat}}</option>
                                                    @endforeach
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
                            <div class="modal modal-blur fade" id="printGuru{{$gtk->id_user}}" tabindex="-1" role="dialog" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title">Cetak Kartu</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <form action="{{route('guru.print', $gtk->id_user)}}" method="get">
                                    <div class="modal-body">
                                      <div class="mb-3">
                                          <label class="form-label">Ukuran Cetak <span style="color: #FF0000;">*</span></label>
                                          <select type="text" name="print" class="form-select" placeholder="Select a date" id="select-tags" value="">
                                            <option value="">--Pilih Ukuran Kertas--</option>
                                            <option value="57">Thermal 57mm</option>
                                            <option value="80">Thermal 80mm</option>
                                          </select>
                                        </div>
                                      </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary">Print</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                            @endforeach
                        </tbody>
                      </table>
                    </div>
                    <div class="card-footer d-flex align-items-center">
                        {{ $dataGtk->links('vendor.pagination.bootstrap-5')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="tambahGtk" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah GTK</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/admin/data/guru/save" method="post">
            @csrf
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">NPA-PGRI <span style="color: #FF0000;">*</span></label>
                    <input type="text" class="form-control" name="npa" placeholder="NPA-PGRI" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span style="color: #FF0000;">*</span></label>
                    <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" class="form-control" name="no_hp" placeholder="Nomor HP">
                </div>
                <div class="mb-3">
                    <label class="form-label">E-Mail</label>
                    <input type="text" class="form-control" name="email" placeholder="E-Mail">
                </div>
                <div class="mb-3">
                    <label class="form-label">TMT</label>
                    <div class="input-icon mb-2">
                      <input class="form-control" name="tmt" placeholder="TMT" id="datepicker-icon">
                      <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path d="M11 15h1"></path><path d="M12 15v3"></path></svg>
                      </span>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Jabatan <span style="color: #FF0000;">*</span></label>
                    <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Pangkat <span style="color: #FF0000;">*</span></label>
                    <select type="text" name="pangkat" class="form-select" placeholder="Select a date" id="select-tags" value="">
                        <option value="">--Pilih Golongan--</option>
                        @foreach ($jenisPangkat as $golongan)
                        <option value="{{$golongan->kode}}" {{Request('pangkat') == $golongan->kode ? 'selected' : ''}}>{{$golongan->nama_pangkat}}</option>
                        @endforeach
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
@endsection
@push('datepicker')
<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
    	window.Litepicker && (new Litepicker({
    		element: document.getElementById('datepicker-icon'),
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
