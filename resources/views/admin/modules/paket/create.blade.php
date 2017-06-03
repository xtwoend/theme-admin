@extends('admin.layouts.app')

@section('content')

{!! Form::open(['route' => 'admin.paket.store', 'class' => 'form']) !!}

<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Tambah Data Peserta </strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.paket.index') }}"  class="btn btn-sm btn-info" data-bjax> <i class="fa fa-chevron-left"></i></a>
        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
    </div>
</header>

<section class="hbox stretch">   
    <section class="bg-white-only b-r col-sm-4 no-padder form-horizontal">
        <section class="vbox animated fadeInUp">
            <section class="scrollable hover wrapper w-f">
                
                <h4 class="m-t-none font-thin m-b">Informasi paket soal</h4>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Mata Pelajaran <span>:</span></label>
                    <div class="col-md-8 p-l-none">
                        {!! Form::select('mapel_id', App\Entities\Mapel::pluck('nama', 'id') , null, ['class' => 'form-control no-border', 'placeholder' => 'mata pelajaran...']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Nama Paket Soal<span>:</span></label>
                    <div class="col-md-8  p-l-none">
                        {!! Form::text('nama', null, ['class' => 'form-control no-border', 'placeholder' => 'Nama...']) !!}
                    </div>
                </div>
                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Jumlah Soal <span>:</span></label>
                    <div class="col-md-8  p-l-none">
                        <div class="input-group">
                            {!! Form::text('jumlah_soal', 0, ['class' => 'form-control no-border', 'placeholder' => 'Jumlah soal...', 'readonly' => 'readonly']) !!}
                            <span class="input-group-addon no-border no-bg max-soal text-muted"></span>
                        </div>
                    </div>
                </div>
               {{--  <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <div class="form-group line-dashed b-b">
                            <label class="col-md-4 control-label  p-r-none">PG <span>:</span></label>
                            <div class="col-md-8 p-l-none">
                                <div class="input-group">
                                    {!! Form::text('soal_pg', null, ['class' => 'form-control no-border', 'placeholder' => 'Soal PG']) !!}
                                    <span class="input-group-addon no-border no-bg max-pg text-muted"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <div class="form-group line-dashed b-b">
                            <label class="col-md-4 control-label  p-r-none">Essay <span>:</span></label>
                            <div class="col-md-8 p-l-none">
                                <div class="input-group">
                                    {!! Form::text('soal_essay', null, ['class' => 'form-control no-border', 'placeholder' => 'Soal Essay']) !!}
                                    <span class="input-group-addon no-border no-bg max-essay text-muted"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label p-r-none">Keterangan<span>:</span></label>
                    <div class="col-md-8 p-l-none">
                        {!! Form::textarea('keterangan', null, ['class' => 'form-control no-border', 'placeholder' => 'Keterangan...', 'rows' => 4]) !!}
                    </div>
                </div>
                
            </section>
        </section>
    </section>
    <section class="bg-white-only col-sm-8 no-padder">
        <section class="vbox">
            <section class="scrollable hover wrapper w-f">
                
                
            </section>
        </section>
    </section>
</section>
{!! Form::close() !!}
@endsection
