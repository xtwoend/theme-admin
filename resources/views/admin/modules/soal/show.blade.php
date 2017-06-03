<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Soal ID #{{ $row->id }}</h4>
    </div>
    <div class="modal-body">
      <h4 class="m-t-none font-thin m-b">Pertanyaan</h4>
      
      @if(! is_null($row->audio))
        <audio controls="" src="{{ $row->audio }}"></audio>
      @endif
      
      {!! $row->pertanyaan !!}

      <div class="line line-dashed b-b line-lg pull-in"></div>
      @if(!$row->type)
      <h4 class="m-t-none font-thin m-b">Opsi Jawaban</h4>
        
        @foreach($row->opsi as $key => $val)
          
          #{{ $key }} <span class="text-success font-bold">{{ ($row->kunci == $key)? 'Jawaban benar' : '' }} </span><br>
          {!! $val !!} 
          <div class="line line-dashed b-b line-lg pull-in"></div>
        @endforeach

      @endif
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->