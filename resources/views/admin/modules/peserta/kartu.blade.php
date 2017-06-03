@extends('admin.layouts.app')

@section('content')
<header class="header bg-light lter hidden-print bg-white box-shadow">
    <a href="#" class="btn btn-sm btn-info pull-right printarea" data-print="printf"><i class="icon-printer"></i></a>
</header>
<section id="print-area">
    <iframe src="{{ route('admin.peserta.kartu.cetak') }}" style="border: 0; width: 100%; height: 100%" id="printf" name="printf"></iframe>
</section>

@endsection

@section('js')

@endsection