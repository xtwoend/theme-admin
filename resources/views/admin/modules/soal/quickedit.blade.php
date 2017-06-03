<div class="modal-dialog modal-lg">
    {!! Form::model($row, ['route' => ['admin.soal.update', $row->id], 'class' => 'form', 'method' => 'PUT']) !!}
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Soal ID #{{ $row->id }}</h4>
        </div>
        <div class="modal-body">
            <h4 class="m-t-none font-thin m-b">Pertanyaan</h4>
            
            {!! Form::hidden('mapel_id') !!}
            {!! Form::hidden('kategori') !!}

            @if(! is_null($row->audio))
                <audio controls="" src="{{ $row->audio }}"></audio>
            @endif
          
            <div class="form-group">
                {!! Form::textarea('pertanyaan', null, ['class' => 'form-control editor', 'data-item'=>'editor', 'data-upload' => route('admin.media.upload') ]) !!}
            </div>
            <div class="line line-dashed b-b line-lg pull-in"></div>
            @if(!$row->type)
                <h4 class="m-t-none font-thin m-b">Opsi Jawaban</h4>
                @foreach($row->opsi as $key => $val)
                    #{{ $key }} <span class="text-success font-bold">{{ ($row->kunci == $key)? 'Jawaban benar' : '' }} </span><br>
                    {!! Form::textarea("opsi[{$key}]", null, ['class' => 'form-control editor', 'data-item'=>'editor', 'data-upload' => route('admin.media.upload'), 'rows' => 2 ]) !!}
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                @endforeach
            @endif
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" data-action="ajax">Simpan</button>
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
        </div>
    </div><!-- /.modal-content -->
    {!! Form::close() !!}
</div><!-- /.modal-dialog -->