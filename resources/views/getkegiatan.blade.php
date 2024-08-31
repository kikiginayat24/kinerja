@if($activityMonth->isEmpty())
<div class="alert alert-warning" role="alert">
    Belum Ada Kegiatan Pada Bulan Tersebut!
</div>
@endif
<ul class="listview image-listview">
    @foreach ($activityMonth as $activity)
        <li>
            <a href="{{route('kegiatan.detail',$activity->id)}}" class="item">
                <div>
                    <p class="truncate">{{$activity->judul}}</p>
                    <p class="text-muted mb-0">{{$activity->tanggal}} {{$activity->jam}}</p>
                </div>
            </a>
            <hr class="m-0">
        </li>
        <hr class="mt-0 mb-0">
    @endforeach
</ul>
