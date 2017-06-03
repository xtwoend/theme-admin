@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row wrapper">
        <div class="col-md-8 col-md-offset-2">
            @if(count($errors) > 0)
            <div class="alert alert-warning alert-block">
                @foreach($errors->all() as $error)
                <h4 class="font-thin">{{ $error }}</h4>
                @endforeach
            </div>
            @endif
            {!! Form::open(['route' => 'ujian.informasi', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="panel panel-default">
                <div class="panel-heading">Selamat datang di {{ config('app.name') }}</div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Nama</label>
                        <div class="col-md-9">
                            <input type="text" value="{{ $row->name }}" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">NIS</label>
                        <div class="col-md-9">
                            <input type="text" value="{{ $row->nis }}" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Kelas</label>
                        <div class="col-md-9">
                            <input type="text" value="{{ $row->kelas->nama }}" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Program Keahlian</label>
                        <div class="col-md-9">
                            <input type="text" value="{{ $row->kelas->jurusan->nama }}" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-md-3 control-label">Status Ujian</label>
                        <div class="col-md-9">
                            <input type="text" value="{{ (count($ujian) > 0)? 'Ujian Aktif': 'Tidak ada ujian berlangsung' }}" class="form-control" id="name" placeholder="Input field" readonly="true">
                        </div>
                    </div>
                    @if(count($ujian) > 0)
                    <div class="form-group {{ $errors->has('token') ? ' has-error' : '' }}">
                        <label for="token" class="col-md-3 control-label">Token Ujian</label>
                        <div class="col-md-3">
                            {!! Form::text('token', null, ['class' => 'form-control input-lg', 'placeholder' => 'Token Ujian']) !!}
                            @if ($errors->has('token'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('token') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                            <div class="col-md-9 col-md-offset-3">
                                <button type="submit" class="btn btn-primary pull-right" style="width: 200px;">
                                    Kirim
                                </button>
                            </div>
                        </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
