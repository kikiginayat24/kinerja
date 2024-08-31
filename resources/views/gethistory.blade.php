@if($historyMonth->isEmpty())
<div class="alert alert-warning" role="alert">
    Belum Ada Histori Pada Bulan Tersebut!
</div>
@endif
<ul class="listview image-listview">
    @foreach ($historyMonth as $history)
        <li>
            <div class="row item">
                <!-- <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image"> -->
                <div class="col in">
                    <div style="font-size: 13px !important;">{{$history->tgl_presensi}}</div>
                    <span class="badge badge-pill badge-success">{{$history->jam_masuk}}</span>
                    <span class="badge badge-pill badge-danger">{{$history->jam_keluar}}</span>
                </div>
            </div>
        </li>
        <hr class="mt-0 mb-0">
    @endforeach
</ul>
