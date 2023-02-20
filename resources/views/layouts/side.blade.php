<div id="scrollbar">
    <div class="container-fluid">

        <div id="two-column-menu">
        </div>
        <ul class="navbar-nav" id="navbar-nav">
            @if (Auth::user()->role_id == 1)
            <li class="nav-item">
                <a class="nav-link menu-link" href="#masterdata" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="masterdata">
                    <i class="ri-archive-line"></i> <span data-key="t-landing">Master Data</span>
                </a>
                <div class="collapse menu-dropdown {{ (request()->is('master-data*')) ? 'show' : '' }}" id="masterdata">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ url('master-data/role') }}" class="nav-link {{ (request()->is('master-data/role*')) ? 'active' : '' }} " data-key="t-one-page"> Role User </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('master-data/user') }}" class="nav-link {{ (request()->is('master-data/user*')) ? 'active' : '' }}" data-key="t-one-page"> User </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ url('master-data/jenis-pengawasan') }}" class="nav-link {{ (request()->is('master-data/jenis-pengawasan*')) ? 'active' : '' }}" data-key="t-nft-landing"> Jenis Pengawasan</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('master-data/opd') }}" class="nav-link {{ (request()->is('master-data/opd*')) ? 'active' : '' }}" data-key="t-nft-landing"> OPD</a>
                        </li> --}}
                    </ul>
                </div>
            </li>
            @endif
            @if (Auth::user()->role_id >= 1 && Auth::user()->role_id <= 15 )
            <li class="nav-item">
                <a class="nav-link menu-link" href="{{ url('/Dashboard') }}">
                    <i class="ri-home-3-line"></i> <span data-key="t-widgets">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#perencanaan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="perencanaan">
                    <i class="ri-calendar-event-line"></i> <span data-key="t-landing">Perencanaan</span>
                </a>
                <div class="collapse menu-dropdown {{ (request()->is('perencanaan*')) ? 'show' : '' }}" id="perencanaan">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ url('perencanaan/pkpt') }}" class="nav-link {{ (request()->is('perencanaan/pkpt')) ? 'active' : '' }}" data-key="t-one-page"> PKPT</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('perencanaan/program-kerja-pengawasan') }}" class="nav-link {{ (request()->is('perencanaan/program-kerja-pengawasan')) ? 'active' : '' }}" data-key="t-nft-landing"> Program Kerja Pengawasan
                            {{-- <span class="badge badge-pill bg-danger" data-key="t-new">1</span> --}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('perencanaan/surat-perintah') }}" class="nav-link {{ (request()->is('perencanaan/surat-perintah')) ? 'active' : '' }}" data-key="t-nft-landing"> Surat Perintah
                            {{-- <span class="badge badge-pill bg-danger" data-key="t-new">1</span> --}}
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#pelaksanaan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="pelaksanaan">
                    <i class="ri-calendar-check-line"></i> <span data-key="t-landing">Pelaksanaan</span>
                </a>
                <div class="collapse menu-dropdown {{ (request()->is('pelaksanaan*')) ? 'show' : '' }}" id="pelaksanaan">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ url('pelaksanaan/kertas-kerja-pemeriksaan') }}" class="nav-link {{ (request()->is('pelaksanaan/kertas-kerja-pemeriksaan')) ? 'active' : '' }}" data-key="t-one-page"> Kertas Kerja Pemeriksaan</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ url('pelaksanaan/approve-kertas-kerja') }}" class="nav-link {{ (request()->is('pelaksanaan/approve-kertas-kerja')) ? 'active' : '' }}" data-key="t-nft-landing"> Approve Kertas Kerja Pemeriksaan></a>
                        </li> --}}
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link menu-link" href="#Pelaporan" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Pelaporan">
                    <i class="ri-slideshow-line"></i> <span data-key="t-landing">Pelaporan</span>
                </a>
                <div class="collapse menu-dropdown  {{ (request()->is('pelaporan*')) ? 'show' : '' }}" id="Pelaporan">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ url('pelaporan/review') }}" class="nav-link {{ (request()->is('pelaporan/review')) ? 'active' : '' }}" data-key="t-one-page"> LHP</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif
            <li class="nav-item">
                <a class="nav-link menu-link" href="#Tindak_lanjut" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="Tindak_lanjut">
                    <i class="ri-rocket-line"></i> <span data-key="t-landing">Tindak Lanjut</span>
                </a>
                <div class="collapse menu-dropdown {{ (request()->is('pelaporan*')) ? 'show' : '' }}" id="Tindak_lanjut">
                    <ul class="nav nav-sm flex-column">
                        <li class="nav-item">
                            <a href="{{ url('pelaporan/tindak-lanjut') }}" class="nav-link  {{ (request()->is('pelaporan/tindak-lanjut')) ? 'active' : '' }}" data-key="t-one-page"> Tindak Lanjut Hasil Pemeriksaan</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <!-- Sidebar -->
</div>
