@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/croppic/croppic.css') }}">
    <style type="text/css">
        #foto-croper {
            /*margin: 0 auto;*/
            width: 225px;
            height: 300px;
            position:relative; /* or fixed or absolute */
            border: 1px solid #eee;
        }
    </style>
@endsection

@section('content')

{!! Form::open(['route' => 'admin.peserta.store', 'class' => 'form']) !!}

<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Tambah Data Peserta </strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.peserta.index') }}"  class="btn btn-sm btn-info" data-bjax> <i class="fa fa-chevron-left"></i></a>
        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
    </div>
</header>

<section class="hbox stretch">   
    <section class="bg-white-only b-r col-sm-6 no-padder form-horizontal">
        <section class="vbox animated fadeInUp">
            <section class="scrollable hover wrapper w-f">
                
                <h4 class="m-t-none font-thin m-b">Informasi Peserta</h4>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Nama <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        {!! Form::text('name', null, ['class' => 'form-control no-border', 'placeholder' => 'Nama...']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Tanggal Lahir <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        <div class="input-group">
                            {!! Form::text('tgl_lahir', null, ['class' => 'form-control no-border date', 'placeholder' => 'Tanggal Lahir...']) !!}
                            <span class="input-group-addon no-border no-bg"><i class="icon icon-calendar"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Jenis Kelamin <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        {!! Form::select('gender', ['L' => 'Laki-laki', 'P' => 'Perempuan'], null, ['class' => 'form-control no-border', 'placeholder' => 'Jenis Kelamin...']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label p-r-none">Nis<span>:</span></label>
                    <div class="col-md-9 p-l-none">
                        {!! Form::text('nis', null, ['class' => 'form-control no-border', 'placeholder' => 'NIS...']) !!}
                    </div>
                </div>

                {{-- <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Nisn <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        <input type="email" class="form-control no-border" placeholder="Nisn...">
                    </div>
                </div> --}}
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Kelas <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        {!! Form::select('kelas_id', App\Entities\Kelas::pluck('nama', 'id'), null, ['class' => 'form-control no-border']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label p-r-none">Username <span>:</span></label>
                    <div class="col-md-9 p-l-none">
                        {!! Form::text('username', null, ['class' => 'form-control no-border', 'placeholder' => 'Username...']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label p-r-none">Password <span>:</span></label>
                    <div class="col-md-9 p-l-none">
                        <div class="input-group">
                            {!! Form::password('password', ['class' => 'form-control no-border password', 'placeholder' => 'Password...']) !!}
                            <span class="input-group-btn">
                                <a class="btn no-border" type="button" data-action="show-hide"><i class="icon-eye"></i></a>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- <textarea class="editor form-control"></textarea> --}}

            </section>
        </section>
    </section>
    <section class="bg-white-only col-sm-6 no-padder">
        <section class="vbox">
            <section class="scrollable hover wrapper w-f">
                <h4 class="m-t-none font-thin m-b">Upload Foto Peserta</h4>
                <div id="foto-croper"></div>
                {!! Form::text('foto', null, ['id' => 'foto-crop', 'class' => 'form-control no-border']) !!}
            </section>
        </section>
    </section>
</section>
{!! Form::close() !!}
@endsection



@section('js')
    <script src="{{ asset('vendor/croppic/croppic.js') }}"></script>
    <script>
        $('a[data-action="show-hide"]').on('click', function(e){
            e && e.preventDefault();
            if ($(".password").attr("type") == "password") {
                $(".password").attr("type", "text");
            } else {
                $(".password").attr("type", "password");
            }
        });

        var photo = new Croppic('foto-croper', {
            uploadUrl: '{{ route('admin.peserta.foto') }}',
            cropUrl: '{{ route('admin.peserta.foto.crop') }}',
            outputUrlId: 'foto-crop',
            zoomFactor: 10,
            doubleZoomControls:false,
            rotateFactor:10,
            rotateControls:true,
            modal:true
        });
    </script>
    @if (count($errors) > 0)
    <script>
        $(document).ready(function(){
            var html = '';
            @foreach ($errors->all() as $error)
                html += '{{ $error }} \n';
            @endforeach
            swal("Oops...", html , "error");
        });
    </script>
    @endif
@endsection