@extends('admin.layouts.app')

@section('content')

{!! Form::open(['route' => 'admin.ujian.store', 'class' => 'form']) !!}

<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Buat Ujian </strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.ujian.index') }}"  class="btn btn-sm btn-info" data-bjax> <i class="fa fa-chevron-left"></i></a>
        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
    </div>
</header>

<section class="hbox stretch">   
    <section class="bg-white-only b-r col-sm-6 no-padder form-horizontal">
        <section class="vbox animated fadeInUp">
            <section class="scrollable hover wrapper w-f">
                
                <h4 class="m-t-none font-thin m-b">Informasi Test</h4>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Nama Ujian <span>:</span></label>
                    <div class="col-md-9 p-l-none">
                        {!! Form::text('nama', null, ['class' => 'form-control no-border', 'placeholder' => 'Nama ujian..']) !!}
                    </div>
                </div>
                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Mata Pelajaran <span>:</span></label>
                    <div class="col-md-9 p-l-none">
                        {!! Form::select('mapel_id', App\Entities\Mapel::pluck('nama', 'id') , null, ['class' => 'form-control no-border', 'placeholder' => 'Mata pelajaran...', 'id' => 'mapel', 'data-url' => route('admin.paket.get')]) !!}
                    </div>
                </div>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Paket Soal <span>:</span></label>
                    <div class="col-md-9 p-l-none">
                        {!! Form::select('paket_soal_id', App\Entities\PaketSoal::pluck('nama', 'id') , null, ['class' => 'form-control no-border', 'placeholder' => 'Paket soal...', 'id' => 'paketsoal']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Waktu Mulai <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        <div class="input-group">
                            {!! Form::text('waktu_mulai', null, ['class' => 'form-control no-border datetime', 'placeholder' => 'Waktu mulai...']) !!}
                            <span class="input-group-addon no-border no-bg"><i class="icon icon-calendar"></i></span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Lama Waktu <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        <div class="input-group">
                            {!! Form::text('lama_waktu', null, ['class' => 'form-control no-border', 'placeholder' => 'Lama waktu ujian...']) !!}
                            <span class="input-group-addon no-border no-bg">menit</span>
                        </div>
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Batas Terlambat <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        <div class="input-group">
                            {!! Form::text('batas_terlambat', null, ['class' => 'form-control no-border', 'placeholder' => 'Batas waktu terlambat ujian...']) !!}
                            <span class="input-group-addon no-border no-bg">menit</span>
                        </div>
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-3 control-label  p-r-none">Jumlah Soal <span>:</span></label>
                    <div class="col-md-9  p-l-none">
                        <div class="input-group">
                            {!! Form::text('jumlah_soal', null, ['class' => 'form-control no-border', 'placeholder' => 'Jumlah soal...']) !!}
                            <span class="input-group-addon no-border no-bg max-soal text-muted"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <div class="form-group line-dashed b-b">
                            <label class="col-md-2 control-label  p-r-none">PG <span>:</span></label>
                            <div class="col-md-10  p-l-none">
                                <div class="input-group">
                                    {!! Form::text('soal_pg', null, ['class' => 'form-control no-border', 'placeholder' => 'Soal PG']) !!}
                                    <span class="input-group-addon no-border no-bg max-pg text-muted"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-9">
                        <div class="form-group line-dashed b-b">
                            <label class="col-md-2 control-label  p-r-none">Essay <span>:</span></label>
                            <div class="col-md-10  p-l-none">
                                <div class="input-group">
                                    {!! Form::text('soal_essay', null, ['class' => 'form-control no-border', 'placeholder' => 'Soal Essay']) !!}
                                    <span class="input-group-addon no-border no-bg max-essay text-muted"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

            </section>
        </section>
    </section>
    <section class="bg-white-only col-sm-6 no-padder form-horizontal">
        <section class="vbox">
            <section class="scrollable hover wrapper w-f">
                
                <h4 class="m-t-none font-thin m-b">Opsi</h4>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Acak Soal<span>:</span></label>
                    <div class="col-lg-9 p-l-none">
                        <div class="radio radio-inline i-checks">
                            <label>
                                {!! Form::radio('soal_acak', 1, true) !!}
                                <i></i>
                                Ya
                            </label>
                        </div>
                        <div class="radio radio-inline i-checks">
                            <label>
                                {!! Form::radio('soal_acak', 0, false) !!}
                                <i></i>
                                Tidak
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Acak Opsi<span>:</span></label>
                    <div class="col-lg-9 p-l-none">
                        <div class="radio radio-inline i-checks">
                            <label>
                                {!! Form::radio('opsi_acak', 1, true) !!}
                                <i></i>
                                Ya
                            </label>
                        </div>
                        <div class="radio radio-inline i-checks">
                            <label>
                                {!! Form::radio('opsi_acak', 0, false) !!}
                                <i></i>
                                Tidak
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-lg-3 control-label  p-r-none">Aktifkan Ujian<span>:</span></label>
                    <div class="col-lg-9 p-l-none">
                        <div class="radio radio-inline i-checks">
                            <label>
                                {!! Form::radio('status', 1, true) !!}
                                <i></i>
                                Ya
                            </label>
                        </div>
                        <div class="radio radio-inline i-checks">
                            <label>
                                {!! Form::radio('status', 0, false) !!}
                                <i></i>
                                Tidak
                            </label>
                        </div>
                    </div>
                </div>

            </section>
        </section>
    </section>
</section>
{!! Form::close() !!}
@endsection

@section('js')
<script>
$('#mapel').on('change', function(e){
    e && e.preventDefault();
    var $id = $(this).val();
    var url = $(this).data('url');
    $.post(url, {mapel_id: $id}, function(res){
        $('#paketsoal').html('');
        $('#paketsoal').append($('<option>', { 
                value: null,
                text : 'Pilih paket soal'
            }));
        $.each(res, function (i, v) {
            $('#paketsoal').append($('<option>', { 
                value: i,
                text : v
            }));
        });
    });
});

$('#paketsoal').on('change', function(e){
    e && e.preventDefault();
    var $id = $(this).val();
    $.post('{{ route('admin.paket.sum') }}', {id: $id}, function(res){
        $('.max-soal').text('max: ' + res.max);
        $('.max-pg').text('max: ' + res.max_pg);
        $('.max-essay').text('max: ' + res.max_essay);
    });
});
</script>
@endsection
