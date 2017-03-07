<aside class="bg-white bg-light-ga nav-xs aside-md hidden-print box-shadow b-r hidden-print" id="nav">          
    <section class="vbox">
        <section class="w-f-md scrollable">
            <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
                
                <div class="clearfix search b-b">
                    <form class="navbar-form navbar-left hidden-xs search" role="search">
                        <div class="input-group">
                            <span class="input-group-btn icon-search">
                                <a type="submit" href="#nav" data-toggle="class:nav-xs" class="btn bg-white btn-icon">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
                            <input type="text" class="form-control no-border search" placeholder="Search ...">
                        </div>
                    </form>
                </div>

                <!-- nav -->                 
                <nav class="nav-primary hidden-xs">
                    <ul class="nav clearfix">
                        <li class="hidden-nav-xs padder m-t m-b-sm text-xs text-muted">
                            Peserta Didik
                        </li>
                        <li class="active">
                            <a href="{{ route('admin.peserta.index') }}">
                                <i class="icon-users icon"></i>
                                <span>Data Peserta</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="icon-users icon"></i>
                                <span>Data Guru</span>
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