@extends('admin.layouts.app')

@section('content')

{!! Form::model($row, ['route' => ['admin.jurusan.update', $row->id], 'class' => 'form', 'method' => 'PUT']) !!}

<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Tambah Data Peserta </strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.jurusan.index') }}"  class="btn btn-sm btn-info" data-bjax> <i class="fa fa-chevron-left"></i></a>
        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
    </div>
</header>

<section class="hbox stretch">   
    <section class="bg-white-only b-r col-sm-6 no-padder form-horizontal">
        <section class="vbox animated fadeInUp">
            <section class="scrollable hover wrapper w-f">
                
                <h4 class="m-t-none font-thin m-b">Informasi Jurusan</h4>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Nama <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        {!! Form::text('nama', null, ['class' => 'form-control no-border', 'placeholder' => 'Nama...']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label p-r-none">Keterangan<span>:</span></label>
                    <div class="col-md-9 p-l-none">
                        {!! Form::textarea('keterangan', null, ['class' => 'form-control no-border', 'placeholder' => 'Keterangan...', 'rows' => 4]) !!}
                    </div>
                </div>

            </section>
        </section>
    </section>
    <section class="bg-white-only col-sm-6 no-padder">
        <section class="vbox">
            <section class="scrollable hover wrapper w-f">
                
                
            </section>
        </section>
    </section>
</section>
{!! Form::close() !!}
@endsection
