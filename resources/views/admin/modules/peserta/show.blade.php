<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">{{ $row->name }}</h4>
    </div>
    <div class="modal-body row">
      <div class="col-sm-8">
        <div class="form-horizontal">
          <div class="form-group line-dashed b-b">
            <label class="col-sm-4 control-label  p-r-none">NIS <span>:</span></label> 
            <div class="col-sm-8 text-form">
              {{ $row->nis }}
            </div>
          </div>
          <div class="form-group line-dashed b-b">
            <label class="col-sm-4 control-label  p-r-none">Jenis Kelamin <span>:</span></label> 
            <div class="col-sm-8 text-form">
              {{ ($row->gender == 'L')? 'Laki-laki' : 'Perempuan' }}
            </div>
          </div>
          <div class="form-group line-dashed b-b">
            <label class="col-sm-4 control-label  p-r-none">Kelas <span>:</span></label> 
            <div class="col-sm-8 text-form">
              {{ $row->kelas->nama }}
            </div>
          </div>
          <div class="form-group line-dashed b-b">
            <label class="col-sm-4 control-label  p-r-none">Username <span>:</span></label> 
            <div class="col-sm-8 text-form">
              {{ $row->username }}
            </div>
          </div>
          <div class="form-group line-dashed b-b">
            <label class="col-sm-4 control-label  p-r-none">Password <span>:</span></label> 
            <div class="col-sm-8 text-form">
              {{ $row->password_text }}
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        @if(isset($row->foto))
          <img src="{{ $row->foto }}" class="img-responsive">
        @endif
      </div>
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->