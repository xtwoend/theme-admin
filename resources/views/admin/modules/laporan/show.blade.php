@extends('admin.layouts.app')

@section('css')
<style type="text/css">
    .pertanyaan > p {
        margin-left: 30px;
    }
    .pertanyaan > span {
        float: left;
        font-weight: 700;
    }
    .options {
        margin-left: 30px;
        margin-bottom: 5px;
    }
    .options > span {
        float: left;
        font-weight: 700;
        margin-right: 20px;
    }
    .options > span.red {
        color: red;
    }
    .soal {
        margin: 30px 0;
    }
    .ctr {
        float: right;
    }
</style>
@endsection


@section('content')

{!! Form::model($row, ['route' => ['admin.laporan.update', $row->id], 'class' => 'form', 'method' => 'PUT']) !!}

<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p><strong>Laporan Hasil Ujian Peserta</strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.laporan.index') }}"  class="btn btn-sm btn-info" data-bjax> <i class="fa fa-chevron-left"></i> Kembali</a>
    </div>
</header>
<section class="hbox stretch">   
    <section class="bg-white-only b-r col-sm-4 no-padder form-horizontal">
        <section class="vbox animated fadeInUp">
            <section class="scrollable hover wrapper w-f">
                
                <h4 class="m-t-none font-thin m-b">Informasi Peserta</h4>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">NIS <span>:</span></label>
                    <div class="col-md-8 p-l-none">
                        {!! Form::text('', $row->user->nis, ['class' => 'form-control no-border']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Nama <span>:</span></label>
                    <div class="col-md-8 p-l-none">
                        {!! Form::text('', $row->user->name, ['class' => 'form-control no-border']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Kelas <span>:</span></label>
                    <div class="col-md-8 p-l-none">
                        {!! Form::text('', $row->user->kelas->nama, ['class' => 'form-control no-border']) !!}
                    </div>
                </div>
                
                <h4 class="m-t-none font-thin m-b">Informasi Ujian</h4>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Nama <span>:</span></label>
                    <div class="col-md-8 p-l-none">
                        {!! Form::text('', $row->ujian->nama, ['class' => 'form-control no-border']) !!}
                    </div>
                </div>
                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Mata Pelajaran <span>:</span></label>
                    <div class="col-md-8 p-l-none">
                        {!! Form::text('', $row->ujian->mapel->nama, ['class' => 'form-control no-border']) !!}
                    </div>
                </div>
                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Tanggal / Jam <span>:</span></label>
                    <div class="col-md-8 p-l-none">
                        {!! Form::text('', $row->ujian->waktu_mulai, ['class' => 'form-control no-border']) !!}
                    </div>
                </div>
            </section>
        </section>
    </section>
    <section class="bg-white-only col-sm-8 no-padder">
        <section class="vbox">
            <section class="scrollable hover wrapper w-f">
                <h4 class="m-t-none font-thin m-b">Jawaban Siswa</h4>
                @php 
                    $soals = (! is_null($row->soals))? $row->soals: [];
                @endphp

                @foreach($soals as $no => $x)
                @php
                    $soal = App\Entities\Soal::find($x['id']);
                    $jawabansiswa = $row->detail()->where('soal_id', $soal->id)->first();
                    $ros = (count($jawabansiswa) > 0)? $jawabansiswa->jawaban: 0;
                    $opsiArray = ['A', 'B', 'C', 'D', 'E']; 
                @endphp
                <div class="soal">
                    <div class="pertanyaan">
                        <span>{{ $no }}.</span>
                        <div class="ctr">
                            @if($soal->type == 0)
                                @foreach($x['opsi'] as $key => $val)
                                    @php
                                        if($soal->kunci != $val) continue;
                                    @endphp
                                    <span style="color: green;">Kunci : {{ $opsiArray[$key]  }}</span>
                                @endforeach
                            @endif
                        </div>
                        <p> 
                            @if(! is_null($soal->audio))
                                <audio controls="controls" src="{{ $soal->audio }}"></audio>
                            @endif
                            {!! $soal->pertanyaan !!}
                        </p>
                    </div>

                    @if($soal->type == 0)
                        @foreach($x['opsi'] as $key => $val)
                        @php 
                            if(is_null($soal->opsi[$val]) || $val == ' ') continue;
                        @endphp
                        <div class="options">
                            <span class="{{ ($val == $ros)? 'red': '' }}">{{ $opsiArray[$key] }}.</span> {!! $soal->opsi[$val] !!}
                        </div>
                        @endforeach
                    @else
                        <div class="options">
                            <pre>{{ (count($jawabansiswa) > 0)? $jawabansiswa->jawaban_text: '' }}</pre>
                        </div>
                    @endif
                        
                </div>
                @endforeach

            </section>
        </section>
    </section>
</section>

{!! Form::close() !!}
@endsection