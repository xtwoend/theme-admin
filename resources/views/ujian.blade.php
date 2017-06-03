@extends('layouts.app')

@section('css')

@endsection

@section('content')
@php
    $soal = $soal->first();
    $pertanyaan = App\Entities\Soal::find($soal['id']);
    $jawaban = [];
    foreach (App\Entities\UjianSiswaDetail::where('ujian_siswa_id', $row->id)->get() as $jw) {
       $jawaban[$jw->soal_id] = [
            'jawaban' => $jw->jawaban,
            'jawaban_text' => $jw->jawaban_text,
            'status'    => $jw->status
       ];
    }                  
@endphp
<section class="hbox stretch">
    <section id="ajax-content">
        <section class="vbox animated fadeInUp">
            <header class="header bg-white box-shadow">
                <p class="font-bold">No. {{ $number }}</p>
                <div class="action pull-right" style="padding: 10px;">
                    @php 
                        $numberBack = ($number > 1)? $number -1 : 1;
                        $numberNext = ($number >= $row->ujian->jumlah_soal)? $row->ujian->jumlah_soal : $number+1;
                    @endphp
                    <a href="{{ route('ujian.show', [$row->ujian->id, $numberBack]) }}" class="btn btn-success btn-sm"><i class="fa fa-angle-double-left"></i> SOAL SEBELUMNYA </a>
                    @if($number == $row->ujian->jumlah_soal)
                    <a href="{{ route('ujian.finish', $row->ujian->id) }}" class="btn btn-primary btn-sm">SELESAI <i class="fa fa-angle-double-right"></i></a>
                    @else
                    <a href="{{ route('ujian.show', [$row->ujian->id, $numberNext]) }}" class="btn btn-success btn-sm">SOAL BERIKUTNYA <i class="fa fa-angle-double-right"></i></a>
                    @endif
                </div> 
            </header>
            <section class="scrollable hover wrapper question">
                <header class="header b-b bg-white-only">
                    <div class="ragu-ragu pull-right" style="margin-top: 5px;">
                        @php
                            $selectedx = (isset($jawaban[$pertanyaan->id]))? ($jawaban[$pertanyaan->id]['status'] == 2)? true: false : false ;
                        @endphp
                        <div class="checkbox i-checks">
                            <label>
                                {!! Form::checkbox('ragu-ragu', 1, $selectedx, ['data-url'=> route('update.setstatus'), 'data-soal' => $pertanyaan->id, 'data-ujian' => $row->id, 'class'=>'ragu-ragu']) !!}
                                <i></i> RAGU-RAGU
                            </label>
                        </div>
                    </div>
                </header>
                <div class="bg-white-only wrapper" id="content-soal">
                    <div class="pertanyaan" style="margin-right: 115px;">
                        {!! $pertanyaan->pertanyaan !!}
                    </div>
                    @php 
                        $alpabet = ['A', 'B', 'C', 'D', 'E'];
                    @endphp
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="jawaban">
                        @if($pertanyaan->type == 0)
                            @foreach($soal['opsi'] as $key => $val)
                            @php 
                                if(is_null($pertanyaan->opsi[$val]) || $val == ' ') continue;
                            @endphp
                            <div class="options">
                                <span>
                                    @php
                                        $selected = (isset($jawaban[$pertanyaan->id]))? ($jawaban[$pertanyaan->id]['jawaban'] == $val)? true: false : false ;
                                    @endphp
                                    {!! Form::radio("opsi[{$pertanyaan->id}]", $val, $selected,[ "class" => "option-input radio {$alpabet[$key]} opsi", 'data-soal' => $pertanyaan->id, 'data-opsi' => $val, 'data-url' => route('update.jawaban'), 'data-opsix' => $alpabet[$key], 'data-ujian' => $row->id ]) !!}
                                </span>
                                <p>{!! $pertanyaan->opsi[$val] !!}</p>
                            </div>
                            @endforeach
                        @else
                            <div class="form-group">
                            @php
                                $jawaban_text = (isset($jawaban[$pertanyaan->id]))? $jawaban[$pertanyaan->id]['jawaban_text'] : null;
                            @endphp
                            {!! Form::textarea('jawaban', $jawaban_text, ['class' => 'form-control', 'rows' => 3]) !!}
                            </div>
                            <button data-action="jawab" class="btn btn-primary" data-url="{{ route('update.jawaban') }}"  data-soal="{{ $pertanyaan->id }}" data-ujian="{{ $row->id }}" >Simpan</button>
                        @endif
                    </div>
                </div>
            </section>
        </section>          
    </section>
    <aside class="bg-white-only hide-sm" style="width: 376px;">
        @php
            $ujian = $row->ujian;
            $lama_waktu = $ujian->lama_waktu;
            $bataswaktu = $row->created_at->addMinutes($lama_waktu);
            $sisawaktu = $bataswaktu->diffInSeconds(Carbon\Carbon::now());
            if($bataswaktu < Carbon\Carbon::now()){
                $sisawaktu = 0;
            }
            $sisawaktu = gmdate('H:i:s', $sisawaktu);
        @endphp
        <section class="vbox animated fadeInUp">
            <header class="header text-center box-shadow no-padder">
                <div class="col-sm-6 bg-primary" style="min-height: 50px; padding:14px;">
                    <a class="jfontsize-button font-bold h4" id="jfontsize-m2" href="#" style="margin-right: 15px;">a</a> 
                    <a class="jfontsize-button font-bold h4" id="jfontsize-p2" href="#">A</a>
                </div>
                <div class="col-sm-6 bg-dark" style="min-height: 50px; padding:15px;">Sisa Waktu 
                    <span class="counter-down font-bold" data-time="{{ $sisawaktu }}"></span>
                </div>
            </header>
            <section class="scrollable hover wrapper">
                <div class="nomor">
                    @php
                        $status = ['red', 'green', 'yellow'];
                    @endphp
                    @foreach($soals as $i => $val)
                    <a href="{{ route('ujian.show', [$row->ujian->id, $i]) }}">           
                        <div class="item {{ (isset($jawaban[$val['id']]))? $status[$jawaban[$val['id']]['status']]: 'red' }}">
                            <p>{{ $i }}</p>
                            <span>{{ (isset($jawaban[$val['id']]))? str_limit($jawaban[$val['id']]['jawaban_text'], 1): '' }}</span>
                        </div>
                    </a>
                    @endforeach
                </div>
            </section>
        </section>
    </aside>
</section>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('vendor/jquery.countdownTimer.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jfontsize/jstorage.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jfontsize/jquery.jfontsize-2.0.js') }}"></script>
<script>
$(document).ready(function(){

    $('.counter-down').each(function(){
        var $this = $(this), 
            $time = $this.data('time').split(':');
        $this.countdowntimer({
            hours: $time[0],
            minutes: $time[1],
            seconds: $time[2],
            timeUp: timeisUp,
            tickInterval: 1
        });
    });

    function timeisUp(){
        alert('time out');
    }

    $('.question').jfontsize({
        btnMinusClasseId: '#jfontsize-m2', // Defines the class or id of the decrease button
        btnDefaultClasseId: '#jfontsize-d2', // Defines the class or id of default size button
        btnPlusClasseId: '#jfontsize-p2', // Defines the class or id of the increase button
        btnMinusMaxHits: 1, // How many times the size can be decreased
        btnPlusMaxHits: 5, // How many times the size can be increased
        sizeChange: 2 // Defines the range of change in pixels
    });

    $(document).on('click', 'input[type="radio"].opsi', function(e){
        var $this = $(this),
            soal_id = $this.data('soal'),
            opsi_id = $this.data('opsi'),
            opsi = $this.data('opsix'),
            ujian_id = $this.data('ujian'),
            url = $this.data('url');
        
        $.post(url, {soal_id: soal_id, opsi_id: opsi_id, opsi: opsi, ujian_id: ujian_id}, function(res){
            console.log(res);
        });
    });

    $(document).on('change', 'input[type="checkbox"].ragu-ragu', function(e){
        e && e.preventDefault();
        var $this = $(this),
            soal_id = $this.data('soal'),
            ujian_id = $this.data('ujian'),
            url = $this.data('url'),
            state = this.checked;
        $.post(url, {soal_id: soal_id, ujian_id: ujian_id, state: state}, function(res){
            console.log(res);
        });
    });

    $(document).on('click', 'button[data-action="jawab"]', function(e){
        e && e.preventDefault();
        var $this = $(this),
            soal_id = $this.data('soal'),
            ujian_id = $this.data('ujian'),
            url = $this.data('url');

        $.post(url, {soal_id: soal_id, ujian_id: ujian_id, jawaban: $('textarea[name="jawaban"]').val()}, function(res){
            console.log(res);
        });
    });
});
</script>
@endsection