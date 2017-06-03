@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row wrapper">
        <div class="col-md-8 col-md-offset-2">
            {!! Form::open(['route' => 'ujian.mulai', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('id', $row->id) !!}
            <div class="panel panel-default">
                <div class="panel-heading">Informasi Paket Soal</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Paket Soal</label>
                        <div class="col-md-8">
                            <input type="text" value="{{ $row->paket->nama }}" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Jumlah Soal</label>
                        <div class="col-md-8">
                            <input type="text" value="{{ $row->jumlah_soal }}" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Jumlah Soal PG</label>
                        <div class="col-md-8">
                            <input type="text" value="{{ $row->soal_pg }}" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Jumlah Soal Essay</label>
                        <div class="col-md-8">
                            <input type="text" value="{{ $row->soal_essay }}" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-4 control-label">Lama Waktu Pengerjaan</label>
                        <div class="col-md-8">
                            <input type="text" value="{{ $row->lama_waktu }} menit" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    
                    <div class="alert alert-success alert-block">
                        <h4 class="font-thin">Catatan Paket Soal</h4>
                        {{ $row->paket->keterangan }}
                    </div>
                    @if(! $open)
                    <div class="alert alert-warning alert-block">
                        <h4 class="font-thin">Anda telah selesai dengan paket ujian ini / status ujian anda sedang aktif</h4>
                    </div>
                    @endif
                    <div class="form-group">
                            <div class="col-md-12">
                                <a href="{{ url('/') }}" class="btn btn-primary" style="width: 200px;"><i class="fa fa-angle-double-left"></i> Kembali</a>
                                @if($open)
                                <button type="submit" class="btn btn-primary pull-right" style="width: 200px;">
                                    Mulai <i class="fa fa-angle-double-right"></i>
                                </button>
                                @endif
                            </div>
                        </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection