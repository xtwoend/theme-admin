@extends('admin.layouts.app')

@section('css')
<style type="text/css">
    .trumbowyg-box,
    .trumbowyg-editor {
        min-height: 200px;
    }

    .opsi .trumbowyg-box,
    .opsi .trumbowyg-editor {
        min-height: 80px;
    }   
</style>
@endsection

@section('content')

{!! Form::model($row, ['route' => ['admin.soal.update', $row->id], 'class' => 'form', 'method' => 'PUT']) !!}

<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Tambah Soal </strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.soal.index') }}"  class="btn btn-sm btn-info" data-bjax> <i class="fa fa-chevron-left"></i></a>
        <button type="reset" class="btn btn-sm btn-warning">Reset</button>
        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Simpan</button>
    </div>
</header>

<section class="hbox stretch">   
    <section class="bg-white-only b-r col-sm-8 no-padder">
        <section class="vbox animated fadeInUp">
            <section class="scrollable hover wrapper w-f">
                
                <h4 class="m-t-none font-thin m-b">Pertanyaan</h4>
                
                <div class="form-group">
                    {!! Form::textarea('pertanyaan', null, ['class' => 'form-control editor', 'data-item'=>'editor', 'data-upload' => route('admin.media.upload') ]) !!}
                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>

                @for($i=1; $i<=5; $i++)
                <div class="option">
                    <div class="radio radio-inline i-checks pull-right">
                        <label>
                            {!! Form::radio("kunci", $i, false) !!}
                            <i></i>
                            Jadikan jawaban benar
                        </label>
                    </div>
                    <div class="form-group opsi">
                        <label>Opsi {{ $i }}</label>
                        {!! Form::textarea("opsi[{$i}]", null, ['class' => 'form-control editor', 'data-item'=>'editor', 'data-upload' => route('admin.media.upload') ]) !!}
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                </div>
                @endfor
            </section>
        </section>
    </section>
    <section class="bg-white-only col-sm-4 no-padder form-horizontal">
        <section class="vbox">
            <section class="scrollable hover wrapper w-f">
                
                <h4 class="m-t-none font-thin m-b">Opsi</h4>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Mata Pelajaran <span>:</span></label>
                    <div class="col-md-8  p-l-none">
                        {!! Form::select('mapel_id', App\Entities\Mapel::pluck('nama', 'id') , null, ['class' => 'form-control no-border', 'placeholder' => 'mata pelajaran...']) !!}
                    </div>
                </div>

                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Tipe Soal<span>:</span></label>
                    <div class="col-md-8 p-l-none">
                        <div class="radio radio-inline i-checks">
                            <label>
                                {!! Form::radio('type', 0, true) !!}
                                <i></i>
                                Pilihan Ganda
                            </label>
                        </div>
                        <div class="radio radio-inline  i-checks">
                            <label>
                                {!! Form::radio('type', 1, false) !!}
                                <i></i>
                                Essay
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Kategori <span>:</span></label>
                    <div class="col-md-8  p-l-none">
                        {!! Form::select('kategori', ['Mudah', 'Sedang', 'Sulit'] , null, ['class' => 'form-control no-border', 'placeholder' => 'Tingkat kesulitan...']) !!}
                    </div>
                </div>
                
                <div class="form-group line-dashed b-b">
                    <label class="col-md-4 control-label  p-r-none">Audio <span>:</span></label>
                    <div class="col-md-8  p-l-none">
                        {!! Form::file('upload', ['class' => 'upload', 'data-url' => route('admin.media.upload')]) !!}
                        {!! Form::hidden('audio', null,['id' => 'audio']); !!}
                    </div>
                </div>
                <div class="preview">
                    @if(! is_null($row->audio))
                    <audio controls="" src="{{ $row->audio }}"></audio>
                    @endif
                </div>
                
            </section>
        </section>
    </section>
</section>
{!! Form::close() !!}
@endsection


@section('js')
<script>
$(function(){
    $('input[type="radio"][name="type"]').on('change', function(e){
        var val = $(this).val();
        if(val == 1){
            $('.option').hide();
        }else{
            $('.option').show();
        }
    });

    $('input[type="file"].upload').off().on('change',  function(e){
        e && e.preventDefault();
        var self = $(this),
            url = self.attr('data-url');

        if(self[0].files.length == 0){
            return;
        }

        var formData = new FormData();
        formData.append('file', self[0].files[0]);
        $.ajax({
            url: url,
            type: 'POST',
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        // console.log(percentComplete*100);
                    }
                }, false);
                return xhr; 
            },
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                // self.closest('div').append('<i class="fa fa-spin fa-spinner show inline" id="spin"></i>');
            },
            complete : function(res) {
                var data = $.parseJSON(res.responseText); 
                if(data.success){
                    var row = data.data;
                    if(row.type=='audio'){
                        var html = '<audio controls';
                        if (row.url) {
                            html += ' src=\'' + row.url + '\'';
                        }
                        html += '></audio>';
                        var node = $(html)[0];
                        $('.preview').html(node);
                        $('#audio').val(row.url);
                    }
                }
            }
        });
    });
});
</script>
@if (count($errors) > 0)
<script>
    $(document).ready(function(){
        var html = '';
        @foreach ($errors->all() as $error)
            html += '{{ $error }} \n';
        @endforeach
        swal("Oops...", html , "error");
    });
</script>
@endif
@endsection