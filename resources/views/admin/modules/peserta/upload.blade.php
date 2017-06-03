<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload Data Peserta</h4>
        </div>
        {!! Form::open(['route' => 'admin.peserta.upload.post', 'class' => 'form-horizontal', 'files' => true]) !!}
        <div class="modal-body">

            <div class="form-group line-dashed b-b">
                <label class="col-sm-4 control-label  p-r-none">KELAS <span>:</span></label> 
                <div class="col-sm-8">
                    {!! Form::select('kelas_id', App\Entities\Kelas::pluck('nama', 'id'), null, ['class' => 'form-control no-border']) !!}
                </div>
            </div>

            <div class="form-group line-dashed b-b">
                <label class="col-sm-4 control-label  p-r-none">FILE <span>:</span></label> 
                <div class="col-sm-8">
                    {!! Form::file('file', null, ['class' => 'form-control no-border']) !!}
                </div>
            </div>

            Format upload download <a href="{{ asset('format/peserta.xls') }}" style="color: #4cb6cb; font-weight: 600;">disini</a>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Unggah</button>
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
        </div>
        {!! Form::close() !!}
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->