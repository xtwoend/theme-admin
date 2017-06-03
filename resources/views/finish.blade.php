@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row wrapper">
        <div class="col-md-8 col-md-offset-2">
            {!! Form::open(['route' => 'ujian.informasi', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
            <div class="panel panel-default">
                <div class="panel-heading">Apakah anda yakin untuk menyelesaikan ujian ini?</div>
                <div class="panel-body">
                    <p>
                        Pastikan semua jawaban terisi dengan baik dan benar, setelah anda tekan finish maka anda tidak bisa menperbaiki jawaban anda.
                    </p>
                    <div class="form-group">
                            <div class="col-md-6">
                                <a href="{{ route('ujian', [$row->id]) }}" class="btn btn-success">
                                    <i class="fa fa-angle-double-left"></i>  Kembali
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary pull-right">
                                    Kirim <i class="fa fa-angle-double-right"></i>
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
