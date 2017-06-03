@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/croppic/croppic.css') }}">
    <style type="text/css">
        #logo-croper {
            /*margin: 0 auto;*/
            width: 225px;
            height: 275px;
            position:relative; /* or fixed or absolute */
            border: 1px solid #eee;
        }
    </style>
@endsection

@section('content')

@if(App\Entities\Setting::count() > 0)
    @php 
        $row = App\Entities\Setting::first(); 
    @endphp
    {!! Form::model($row, ['route' => ['admin.setting.update', $row->id], 'class' => 'form', 'method' => 'PUT']) !!}
@else
    {!! Form::open(['route' => 'admin.setting.store', 'class' => 'form']) !!}
@endif

<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Data Sekolah </strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
    </div>
</header>

<section class="hbox stretch">   
    <section class="bg-white-only b-r col-sm-6 no-padder form-horizontal">
        <section class="vbox animated fadeInUp">
            <section class="scrollable hover wrapper w-f">
                
                <h4 class="m-t-none font-thin m-b">Informasi Sekolah</h4>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Nama Sekolah<span>:</span></label>
                    <div class="col-lg-9  p-l-none">
                        {!! Form::text('nama_sekolah', null, ['class' => 'form-control no-border', 'placeholder' => 'Nama...']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Jenjang<span>:</span></label>
                    <div class="col-lg-9 p-l-none">
                        <div class="radio radio-inline i-checks">
                            <label>
                                {!! Form::radio('jenjang', 'SMP', false) !!}
                                <i></i>
                                SMP
                            </label>
                        </div>
                        <div class="radio radio-inline  i-checks">
                            <label>
                                {!! Form::radio('jenjang', 'SMA', false) !!}
                                <i></i>
                                SMA
                            </label>
                        </div>
                        <div class="radio radio-inline  i-checks">
                            <label>
                                {!! Form::radio('jenjang', 'SMK', false) !!}
                                <i></i>
                                SMK
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Status Sekolah<span>:</span></label>
                    <div class="col-lg-9 p-l-none">
                        <div class="radio radio-inline i-checks">
                            <label>
                                {!! Form::radio('status_sekolah', 'Negeri', false) !!}
                                <i></i>
                                Negeri
                            </label>
                        </div>
                        <div class="radio radio-inline  i-checks">
                            <label>
                                {!! Form::radio('status_sekolah', 'Swasta', false) !!}
                                <i></i>
                                Swasta
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label p-r-none">Alamat<span>:</span></label>
                    <div class="col-lg-9 p-l-none">
                        {!! Form::textarea('alamat', null, ['class' => 'form-control no-border', 'placeholder' => 'Keterangan...', 'rows' => 4]) !!}
                    </div>
                </div>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Telp <span>:</span></label>
                    <div class="col-lg-9  p-l-none">
                        {!! Form::text('telp', null, ['class' => 'form-control no-border', 'placeholder' => 'Telp...']) !!}
                    </div>
                </div>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Email <span>:</span></label>
                    <div class="col-lg-9  p-l-none">
                        {!! Form::email('email', null, ['class' => 'form-control no-border', 'placeholder' => 'Email...']) !!}
                    </div>
                </div>

            </section>
        </section>
    </section>
    <section class="bg-white-only col-sm-6 no-padder form-horizontal">
        <section class="vbox">
            <section class="scrollable hover wrapper w-f">

                <h4 class="m-t-none font-thin m-b">Informasi Ruang</h4>
                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Jumlah Ruang<span>:</span></label>
                    <div class="col-lg-9  p-l-none">
                        {!! Form::text('jumlah_ruang', null, ['class' => 'form-control no-border', 'placeholder' => 'Jumlah ruang komputer...']) !!}
                    </div>
                </div>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Jumlah Unit/Ruang<span>:</span></label>
                    <div class="col-lg-9  p-l-none">
                        {!! Form::text('jumlah_unit', null, ['class' => 'form-control no-border', 'placeholder' => 'Jumlah unit / ruang...']) !!}
                    </div>
                </div>

                <h4 class="m-t-none font-thin m-b">Logo Sekolah</h4>
                <div id="logo-croper">
                    @if(isset($row))
                        <img src="{{ $row->logo }}">
                    @endif
                </div>
                {!! Form::text('logo', null, ['id' => 'logo-crop', 'class' => 'form-control no-border']) !!}

            </section>
        </section>
    </section>
</section>
{!! Form::close() !!}
@endsection

@section('js')
<script src="{{ asset('vendor/croppic/croppic.js') }}"></script>
<script>
    var logo = new Croppic('logo-croper', {
        uploadUrl: '{{ route('admin.setting.logo') }}',
        cropUrl: '{{ route('admin.setting.logo.crop') }}',
        outputUrlId: 'logo-crop',
        zoomFactor: 10,
        doubleZoomControls:false,
        rotateFactor:10,
        rotateControls:true,
        modal: true
    });

</script>
@endsection
