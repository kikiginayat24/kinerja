<!-- App Bottom Menu -->
<div class="appBottomMenu">
        <a href="{{ request()->is('dashboard') ? '#' : '/dashboard'}}" class="item {{ request()->is('dashboard') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="home-outline" role="img" class="md hydrated"
                    aria-label="home outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
        <a href="{{ request()->is('history') ? '#' : '/history'}}" class="item {{ request()->is('history') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="time-outline" role="img" class="md hydrated"
                    aria-label="time outline"></ion-icon>
                <strong>History</strong>
            </div>
        </a>
        <a href="/presensi/create" class="item">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="{{ request()->is('kegiatan') ? '#' : '/kegiatan'}}" class="item {{ request()->is('kegiatan') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="document-text-outline" role="img" class="md hydrated"
                    aria-label="document text outline"></ion-icon>
                <strong>Kegiatan</strong>
            </div>
        </a>
        <a href="{{ request()->is('profile') ? '#' : '/profile'}}" class="item {{ request()->is('profile') ? 'active' : ''}}">
            <div class="col">
                <ion-icon name="people-outline" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong>Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->
