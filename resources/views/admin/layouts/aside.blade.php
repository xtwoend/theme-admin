<aside class="bg-white bg-light-ga nav-xs aside-md hidden-print box-shadow b-r hidden-print" id="nav">          
    <section class="vbox">
        <section class="w-f scrollable">
            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                
                <div class="clearfix search b-b">
                    <div class="navbar-form navbar-left hidden-xs search" role="search">
                        <div class="input-group">
                            <span class="input-group-btn icon-search">
                                <a href="#nav" data-toggle="class:nav-xs" class="btn bg-white btn-icon">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
                            <input type="text" data-item="search" class="form-control no-border search" placeholder="Search ...">
                        </div>
                    </div>
                </div>

                <!-- nav -->                 
                <nav class="nav-primary hidden-xs">
                    <ul class="nav clearfix" data-ride="collapse">
                        <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted">
                            Pelaksanan Ujian
                        </li>

                        <li class="{{ (config('site.menu') == 'dashboard')? 'active': '' }}">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="icon-speedometer icon"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
    
                        <li class="{{ (config('site.menu') == 'ujian')? 'active': '' }}">
                            <a href="{{ route('admin.ujian.index') }}">
                                <i class="icon-note icon"></i>
                                <span>Test</span>
                            </a>
                        </li>

                        <li class="{{ (config('site.menu') == 'paket')? 'active': '' }}">
                            <a href="{{ route('admin.paket.index') }}">
                                <i class="icon-drawer icon"></i>
                                <span>Paket Soal</span>
                            </a>
                        </li>

                        <li class="{{ (config('site.menu') == 'unlock')? 'active': '' }}">
                            <a href="{{ route('admin.status.index') }}">
                                <i class="icon-lock-open icon"></i>
                                <span>Unlock Login</span>
                            </a>
                        </li>

                        <li class="{{ (config('site.menu') == 'print')? 'active': '' }}">
                            <a href="#" class="auto">
                                <span class="pull-right text-muted">
                                    <i class="fa fa-angle-left text"></i>
                                    <i class="fa fa-angle-down text-active"></i>
                                </span>
                                <i class="icon-printer icon">
                                </i>
                                <span>Cetak</span>
                            </a>
                            <ul class="nav text-sm">
                                <li class="{{ (config('site.submenu') == 'daftarhadir')? 'active': '' }}">
                                    <a href="{{ route('admin.peserta.daftarhadir') }}" data-target="#content" data-el="#bjax-el" data-replace="true">
                                        <i class="fa fa-angle-right text-xs"></i>
                                        <span>Daftar Hadir Peserta</span>
                                    </a>
                                </li>
                                <li class="{{ (config('site.submenu') == 'kartuperserta')? 'active': '' }}">
                                    <a href="{{ route('admin.peserta.kartu') }}" data-target="#content" data-el="#bjax-el" data-replace="true">
                                        <i class="fa fa-angle-right text-xs"></i>
                                        <span>Kartu Peserta</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="{{ (config('site.menu') == 'laporan')? 'active': '' }}">
                            <a href="#" class="auto">
                                <span class="pull-right text-muted">
                                    <i class="fa fa-angle-left text"></i>
                                    <i class="fa fa-angle-down text-active"></i>
                                </span>
                                <i class="icon-doc icon">
                                </i>
                                <span>Laporan</span>
                            </a>
                            <ul class="nav text-sm">
                                <li>
                                    <a href="{{ route('admin.laporan.index') }}">
                                        <i class="fa fa-angle-right text-xs"></i>
                                        <span>Hasil Test</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('admin.peserta.kartu') }}" data-target="#content" data-el="#bjax-el" data-replace="true">
                                        <i class="fa fa-angle-right text-xs"></i>
                                        <span>Rekap Nilai</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>

                        <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted">
                            Data Master
                        </li>
                        <li class="{{ (config('site.menu') == 'peserta')? 'active': '' }}">
                            <a href="{{ route('admin.peserta.index') }}">
                                <i class="icon-users icon"></i>
                                <span>Data Peserta</span>
                            </a>
                        </li>
                        <li class="{{ (config('site.menu') == 'kelas')? 'active': '' }}">
                            <a href="{{ route('admin.kelas.index') }}">
                                <i class="icon-home icon"></i>
                                <span>Kelas</span>
                            </a>
                        </li>
                        <li class="{{ (config('site.menu') == 'jurusan')? 'active': '' }}">
                            <a href="{{ route('admin.jurusan.index') }}">
                                <i class="icon-grid icon"></i>
                                <span>Jurusan</span>
                            </a>
                        </li>
                        <li class="{{ (config('site.menu') == 'mapel')? 'active': '' }}">
                            <a href="{{ route('admin.mapel.index') }}">
                                <i class="icon-book-open icon"></i>
                                <span>Mata Pelajaran</span>
                            </a>
                        </li>
                        <li class="{{ (config('site.menu') == 'soal')? 'active': '' }}">
                            <a href="{{ route('admin.soal.index') }}">
                                <i class="icon-layers icon"></i>
                                <span>Gudang Soal</span>
                            </a>
                        </li>
                        <li class="{{ (config('site.menu') == 'setting')? 'active': '' }}">
                            <a href="{{ route('admin.setting.index') }}">
                                <i class="icon-settings icon"></i>
                                <span>Informasi Sekolah</span>
                            </a>
                        </li>
                            
                    </ul>
                </nav>
                <!-- / nav -->
                
            </div>
        </section>
        <footer class="footer bg-light hidden-xs no-padder text-center-nav-xs">
            <ul class="nav-collapse">
                {{-- <li></li> --}}
                <li class="b-t">
                    <a href="#nav" data-toggle="class:nav-xs" class="text-muted ">
                        <i class="fa fa-angle-right text"></i>
                        <i class="fa fa-angle-left text-active"></i>
                    </a> 
                </li>
            </ul> 
        </footer>
    </section>
</aside>