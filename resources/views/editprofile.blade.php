@extends('layouts.presensi')
@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Edit Profile</div>
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
            <div class="row mb-5">
                <div class="col">
                    <div class="form-group row">
                        <label for="nama" class="col-3 col-form-label">Nama</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="nama" value="{{$data->nama_lengkap}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="npa" class="col-3 col-form-label">NPA</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="npa" value="{{$data->id_user}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="ttl" class="col-3 col-form-label">TTL</label>
                        <div class="col-9">
                            <input type="date" class="form-control" id="ttl" name="ttl" value="{{$data->ttl}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="jabatan" class="col-3 col-form-label">Jabatan</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="jabatan" value="{{$data->jabatan}}" disabled>
                        </div>
                    </div>
                    <!-- <fieldset class="form-group">
                        <div class="row">
                            <legend class="col-form-label col-3 pt-0">JK</legend>
                            <div class="col-9">
                                <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="jk" id="gridRadios1" value="11" {{$data->jk == 11 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="gridRadios1">
                                      Laki-Laki
                                    </label>
                                </div>
                                <div class="form-check disabled">
                                    <input class="form-check-input" type="radio" name="jk" id="gridRadios2" value="12" {{$data->jk == 12 ? 'checked' : ''}}>
                                    <label class="form-check-label" for="gridRadios2">
                                      Perempuan
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset> -->
                    <div class="form-group row">
                        <label for="no_hp" class="col-3 col-form-label">No. HP</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{$data->no_hp}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-3 col-form-label">Password</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="password" name="password">
                        </div>
                    </div>
                    <!-- <div class="custom-file-upload" id="fileUpload1">
                        <input type="file" name="foto" id="fileuploadinput" accept=".png, .jpg, .jpeg">
                        <label for="fileuploadinput">
                            <span>
                                <strong>
                                    <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                                    <i>Tap to Upload</i>
                                </strong>
                            </span>
                        </label>
                    </div> -->
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Foto Profil</label>
                        <input type="file" class="form-control-file" name="foto" id="exampleFormControlFile1" accept=".png, .jpg, .jpeg">
                    </div>
                    <div class="card text-center" id="uploadimage" style="display: none;">
                        <div class="card-header">Crop Image</div>
                        <div class="card-body">
                            <div id="image-crop" style="width:300px; margin-top:30px"></div>
                        </div>
                    </div>
                    <!-- <div id="preview-crop-image" style="background:#9d9d9d;width:300px;padding:50px 50px;height:300px;"></div> -->
                    <button id="upload" class="upload btn btn-secondary mt-2">Submit</button>
                </div>
            </div>
            <div class="row mb-3"></div>
        </div>
    </div>
</div>
<!-- * App Capsule -->
@endsection

@push('crop')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var resize = $('#image-crop').croppie({
        enableExif:true,
        enableOrientation:true,
        viewport: {
            width:200,
            height:200,
            type: 'circle'
        },
        boundary:{
            width:250,
            height:250
        }
    });

    $('#exampleFormControlFile1').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event){
            resize.croppie('bind', {
                url: event.target.result
            }).then(function(){
                console.log('jQuery bind complete');
            });
        }
        reader.readAsDataURL(this.files[0]);
        $('#uploadimage').show();
    });

    $('#upload').on('click',function(e){
        let ttl =document.getElementById('ttl');
        let valueTtl =ttl.value;
        // let jk =document.getElementById('jk');
        // for (i=0; i<jk.length;i++){
        //     if(jk.checked){
        //         let valueJk = jk.value;
        //     }
        // }
        let no_hp =document.getElementById('no_hp');
        let valueHp =no_hp.value;
        let password =document.getElementById('password');
        let valuePassword =password.value;
        resize.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(img){
            $.ajax({
                type:'POST',
                url:'/profile/edit/save/{{$data->id_user}}',
                //url:'/profile/edit/save/coba',
                data: {
                    _token:"{{csrf_token()}}",
                    ttl : valueTtl,
                    // jk : valueJk,
                    no_hp:valueHp,
                    password:valuePassword,
                    image:img},
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
                    setTimeout("location.href='/profile'",2000);
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
    });
</script>
@endpush
