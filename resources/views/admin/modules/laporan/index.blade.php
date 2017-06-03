@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqgrid/css/ui.jqgrid.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqgrid/css/ui.jqgrid-bootstrap-ui.css') }}">
    <style type="text/css">
        .backdrop .loading {
            position: absolute;
            top: 50%;
            left: 50%;
            color: #fff;
            font-size: 18px;
        }
    </style>
@endsection

@section('content')
<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Laporan Hasil Ujian Peserta</strong></p>

    <div class="pull-right" style="margin-top: 10px;">
        <button class="btn btn-sm btn-success" data-item="koreksi" data-url="{{ route('admin.ujian.koreksi') }}">Koreksi Hasil Ujian</button>
        <button class="btn btn-sm btn-success btn-refresh" data-item="refresh"><i class="icon-refresh"></i></button>
        <a href="{{ route('admin.laporan.download', ['ujian_id' => request()->get('ujian_id'), 'time' => time()]) }}" class="btn btn-sm btn-info"><i class="icon-cloud-download"></i> Download</a>

    </div>
</header>
<section class="data-grid">
    <table id="laporan-table" data-url="{{ route('admin.laporan.data', ['ujian_id' => request()->get('ujian_id')]) }}"></table>
    <div id="pager"></div>
</section>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('vendor/jqgrid/js/i18n/grid.locale-id.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jqgrid/js/jquery.jqGrid.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            var grid = $('table#laporan-table').dataGrid({
                colModel: [
                    // { label: 'ID', name: 'id', key: true, width: 75, searchoptions:{sopt:['eq','ne','le','lt','gt','ge']}},
                    { label: ' ', name: 'action', width: 80, search:false, frozen:true},
                    { label: 'Ujian', name: 'ujian.nama', width: 150, searchoptions:{sopt:['cn','eq']}},
                    { label: 'NIS', name: 'user.nis', width: 100, searchoptions:{sopt:['eq','cn']}},
                    { label: 'Nama', name: 'user.name', width: 200, searchoptions:{sopt:['cn']}},
                    { label: 'IP Komputer', name: 'ip', width: 100, searchoptions:{sopt:['cn']}},
                    { label: 'Waktu Mulai Ujian', name: 'created_at', width: 150, searchoptions:{sopt:['ge','le','eq']}},
                    { label: 'Paket Soal', name: 'ujian.paket.nama', width: 150, searchoptions:{sopt:['cn','eq']}},
                    { label: 'Status', name: 'status', width: 150, searchoptions:{sopt:['cn','eq']}},
                    { label: 'Benar', name: 'benar', width: 80, searchoptions:{sopt:['ge','le','eq']}},
                    { label: 'Salah', name: 'salah', width: 80, searchoptions:{sopt:['ge','le','eq']}},
                    { label: 'Kosong', name: 'kosong', width: 80, searchoptions:{sopt:['ge','le','eq']}},
                    { label: 'Skor PG', name: 'skor_pg', width: 80, searchoptions:{sopt:['ge','le','eq']}},
                    { label: 'Skor Essay', name: 'skor_pg', width: 80, searchoptions:{sopt:['ge','le','eq']}},
                    { label: 'Skor Akhir', name: 'skor', width: 80, searchoptions:{sopt:['ge','le','eq']}},
                ],
            });

            grid.jqGrid('filterToolbar', {searchOperators : true});
            grid.jqGrid('setFrozenColumns');

            $('input[data-item="search"]').on('keypress', function(e) { 
                if(e.which == 13){
                    let rules = [], i, cm,
                        postData = grid.jqGrid("getGridParam", "postData"),
                        colModel = grid.jqGrid("getGridParam", "colModel"),
                        searchText = this.value,
                        l = colModel.length;

                    for (i = 0; i < l; i++) {
                        cm = colModel[i];
                        if (cm.search !== false && (typeof cm.stype === "undefined" || cm.stype === "text")) {
                            rules.push({
                                field: cm.name,
                                op: "cn",
                                data: searchText
                            });
                        }
                    }

                    let filters = { 
                            groupOp: "OR",
                            rules: rules
                        };

                    $.extend (postData, {
                        filters: JSON.stringify(filters)
                    });

                    grid.jqGrid("setGridParam", { search: true, postData: postData });
                    grid.trigger("reloadGrid", [{page: 1, current: true}]);
                    return false;
                }
                return;
            });

            $('button[data-item="delete"]').on('click', function(e){
                e && e.preventDefault();
                var ids = grid.jqGrid('getGridParam','selarrrow');
                var url = $(this).attr('href') || $(this).attr('data-url');
                // return error select first
                if(ids.length === 0){
                    swal("Oops...", "Please select first.." , "error");
                    return;
                }
                // delete process
                swal({   
                    title: "Are you sure?",   
                    text: "You will not be able to recover this data!",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Yes, delete it!",   
                    closeOnConfirm: false ,
                    showLoaderOnConfirm: true,
                }, function(){  
                    setTimeout(function(){
                        $.post(url, {ids: ids, _method: 'DELETE'}, function(res){
                            swal({
                                    title: "Deleted!!",
                                    text: "Your post has been deleted",
                                    type: "success",
                                    timer: 1000,   
                                    showConfirmButton: false 
                            });
                            grid.trigger('reloadGrid');
                        });
                    }, 1000);   
                });

            });

            $('button[data-item="refresh"]').on('click', function(e){
                e && e.preventDefault();
                grid.trigger('reloadGrid');
            });

            $('button[data-item="koreksi"]').on('click', function(e){
                e && e.preventDefault();
                var url = $(this).data('url') || $(this).attr('href');
                var backdrop = $('<div class="backdrop fade in bg-black"><div class="loading">Loading...</div></div>').appendTo('body');
                $.post(url, {}, function(res){
                    swal({
                            title: "Success !!!",
                            text: res.message,
                            type: "success",
                            timer: 1000,   
                            showConfirmButton: false 
                    });
                    grid.trigger('reloadGrid');
                    backdrop.remove();
                });  
            })
        });
 
    </script>
@endsection