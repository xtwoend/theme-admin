<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tambah soal ke paket soal</h4>
        </div>
        <section class="data-grid" style="width: 100%;">
            <table id="soal-table" data-url="{{ route('admin.paket.datasoal', $row->id) }}"></table>
            <div id="pager-soal"></div>
        </section>
        <div class="modal-footer">
            <a class="btn btn-primary" data-item="add-soal" data-url="{{ route('admin.paket.addsoal.submit', $row->id) }}">Add</a>
            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
        </div>
    </div>
</div>