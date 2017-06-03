@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqgrid/css/ui.jqgrid.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqgrid/css/ui.jqgrid-bootstrap-ui.css') }}">
@endsection

@section('content')
<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Data Mata Pelajaran</strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.soal.create') }}" class="btn btn-sm btn-primary" data-bjax>Create</a>
        <button class="btn btn-sm btn-success btn-refresh" data-item="refresh"><i class="icon-refresh"></i></button>
        <button class="btn btn-sm btn-danger btn-delete" data-item="delete" data-url="{{ route('admin.soal.destroy', [0]) }}"><i class="icon-trash"></i></button>
        <div class="btn-group">
            <button class="btn btn-sm btn-info"><i class="icon-cloud-download"></i> Unduh</button>
            <a href="{{ route('admin.soal.upload') }}" class="btn btn-sm btn-warning" data-toggle="ajaxModal"><i class="icon-cloud-upload"></i> Unggah</a>
        </div>
    </div>
</header>
<section class="data-grid">
    <table id="soal-table" data-url="{{ route('admin.soal.data') }}"></table>
    <div id="pager"></div>
</section>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('vendor/jqgrid/js/i18n/grid.locale-id.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jqgrid/js/jquery.jqGrid.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            var grid = $('table#soal-table').dataGrid({
                colModel: [
                    { label: ' ', name: 'action', width: 60, search:false, frozen:true},
                    { label: 'Mata Pelajaran', name: 'mapel.nama', width: 200, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                    { label: 'Type Soal', name: 'type', width: 80, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                    { label: 'Kategori', name: 'kategori', width: 80, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                    { label: 'Pertanyaan', name: 'pertanyaan', width: 600, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                    { label: 'Kunci', name: 'kunci', width: 50, search:false},
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
        });
 
    </script>
@endsection