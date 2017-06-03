@extends('admin.layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqgrid/css/ui.jqgrid.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqgrid/css/ui.jqgrid-bootstrap-ui.css') }}">
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
    .soal {
        margin: 30px 0;
    }
    .ctr {
        float: right;
    }
</style>
@endsection

@section('content')

{!! Form::model($row, ['route' => ['admin.paket.update', $row->id], 'class' => 'form', 'method' => 'PUT']) !!}

<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Edit Paket Soal </strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.paket.index') }}"  class="btn btn-sm btn-info" data-bjax> <i class="fa fa-chevron-left"></i></a>
        <a href="{{ route('admin.paket.addsoal', $row->id) }}" data-toggle="modal" class="btn btn-sm btn-primary" title="Tambah Soal" data-target="#soalModal">Tambah Soal</a>
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
                            {!! Form::text('jumlah_soal', null, ['class' => 'form-control no-border', 'placeholder' => 'Jumlah soal...', 'readonly' => 'readonly']) !!}
                            <span class="input-group-addon no-border no-bg max-soal text-muted"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <div class="form-group line-dashed b-b">
                            <label class="col-md-4 control-label  p-r-none">PG <span>:</span></label>
                            <div class="col-md-8 p-l-none">
                                <div class="input-group">
                                    {!! Form::text('soal_pg', null, ['class' => 'form-control no-border', 'placeholder' => 'Soal PG', 'readonly' => 'readonly']) !!}
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
                                    {!! Form::text('soal_essay', null, ['class' => 'form-control no-border', 'placeholder' => 'Soal Essay', 'readonly' => 'readonly']) !!}
                                    <span class="input-group-addon no-border no-bg max-essay text-muted"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

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
                <h4 class="m-t-none font-thin m-b">List Soal</h4>
                @php 
                    $ids = (! is_null($row->soal))? $row->soal: [];
                    $no = 1;
                @endphp
                @foreach(App\Entities\Soal::where('mapel_id', $row->mapel_id)->whereIn('id', $ids)->where('type', 0)->get() as $soal)
                <div class="soal">
                    <div class="pertanyaan">
                        <span>{{ $no++ }}.</span>
                        <div class="ctr">
                            <a href="{{ route('admin.soal.quickedit', $soal->id) }}" class="btn btn-xs btn-success" data-toggle="ajaxModal"><i class="icon-pencil"></i></a>
                            <a href="{{ route('admin.paket.remove.soal', [$row->id, $soal->id]) }}" class="btn btn-xs btn-danger" data-item="remove"><i class="icon-trash"></i></a>
                        </div>
                        <p> 
                            @if(! is_null($soal->audio))
                                <audio controls="controls" src="{{ $soal->audio }}"></audio>
                            @endif
                            {!! $soal->pertanyaan !!}
                        </p>
                    </div>
                    @php
                        $opsiArray = [1 => 'A', 'B', 'C', 'D', 'E']; 
                    @endphp
                    @foreach($soal->opsi as $key => $val)
                    <div class="options">
                        <span>{{ $opsiArray[$key] }}.</span> {!! $val !!}
                    </div>
                    @endforeach
                </div>
                @endforeach
                <h4 class="m-t-none font-thin m-b">Essay</h4>
                @foreach(App\Entities\Soal::where('mapel_id', $row->mapel_id)->whereIn('id', $ids)->where('type', 1)->get() as $soalEssay)
                <div class="soal">
                    <div class="pertanyaan">
                        <span>{{ $no++ }}.</span>
                        <div class="ctr">
                            <a href="{{ route('admin.soal.quickedit', $soalEssay->id) }}" class="btn btn-xs btn-success" data-toggle="ajaxModal"><i class="icon-pencil"></i></a>
                            <a href="{{ route('admin.paket.remove.soal', [$row->id, $soalEssay->id]) }}" class="btn btn-xs btn-danger" data-item="remove"><i class="icon-trash"></i></a>
                        </div>
                        <p> 
                            @if(! is_null($soalEssay->audio))
                                <audio controls="controls" src="{{ $soalEssay->audio }}"></audio>
                            @endif
                            {!! $soalEssay->pertanyaan !!}
                        </p>
                    </div>
                </div>
                @endforeach
            </section>
        </section>
    </section>
</section>

<div class="modal fade" id="soalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"></div>
    </div>
</div>

{!! Form::close() !!}
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('vendor/jqgrid/js/i18n/grid.locale-id.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/jqgrid/js/jquery.jqGrid.min.js') }}"></script>
<script>
$(document).ready(function() {

    $('#soalModal').on('loaded.bs.modal', function(e){
        var gridSoal = $('table#soal-table').dataGrid({
            colModel: [
                { label: ' ', name: 'action', width: 30, search:false, frozen:true},
                { label: 'Type Soal', name: 'type', width: 80, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                { label: 'Kategori', name: 'kategori', width: 80, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                { label: 'Pertanyaan', name: 'pertanyaan', width: 500, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                { label: 'Kunci', name: 'kunci', width: 50, search:false},
            ],
            pager: '#pager-soal',
            // shrinkToFit: false,
            autowidth: true,
            width: "100%",
            height: "450"
        });
        gridSoal.jqGrid('filterToolbar', {searchOperators : true});

        $('a[data-item="add-soal"]').on('click', function(e){
            var ids = gridSoal.jqGrid('getGridParam','selarrrow');
            var url = $(this).data('url');
            $.post(url, {id: ids}, function(res){
                gridSoal.trigger('reloadGrid');
                if(res.success){
                   location.reload();
                }
            });
        });
    });

    $('a[data-item="remove"]').on('click', function(e){
        e && e.preventDefault();
        var url = $(this).attr('href');
        var $that = $(this);
        swal({   
            title: "Are you sure?",   
            text: "You will not be able to recover this data!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "Yes, remove it!",   
            closeOnConfirm: false ,
            showLoaderOnConfirm: true,
        }, function(){  
            setTimeout(function(){
                $.post(url, {_method: 'DELETE'}, function(res){
                    swal({
                            title: "Removed!!",
                            text: "Soal berhasil di hapus dari paket soal ini",
                            type: "success",
                            timer: 1000,   
                            showConfirmButton: false 
                    });
                    location.reload();
                    // $that.parent().closest('div.soal').remove();
                });
            }, 1000);   
        });
    });
});
</script>
@endsection
