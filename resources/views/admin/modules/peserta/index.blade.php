@extends('admin.layouts.app')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jquery-ui/jquery-ui.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqgrid/css/ui.jqgrid.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqgrid/css/ui.jqgrid-bootstrap-ui.css') }}">
@endsection

@section('content')
<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Data Peserta </strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.peserta.create') }}" class="btn btn-sm btn-primary" data-bjax>Create</a>
        <button class="btn btn-sm btn-success btn-refresh" data-item="refresh"><i class="icon-refresh"></i></button>
        <button class="btn btn-sm btn-danger btn-delete" data-item="delete" data-url="{{ route('admin.peserta.destroy', [0]) }}"><i class="icon-trash"></i></button>
        <button class="btn btn-sm btn-success" data-item="generate-ruang" data-url="{{ route('admin.peserta.generate') }}">Generate Ruang</button>
        <div class="btn-group">
            <button class="btn btn-sm btn-info"><i class="icon-cloud-download"></i> Unduh</button>
            <a href="{{ route('admin.peserta.upload') }}" class="btn btn-sm btn-warning" data-toggle="ajaxModal"><i class="icon-cloud-upload"></i> Unggah</a>
        </div>
    </div>
</header>
<section class="data-grid">
    <table id="peserta-table" data-url="{{ route('admin.peserta.data') }}"></table>
    <div id="pager"></div>
</section>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('vendor/jqgrid/js/i18n/grid.locale-id.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jqgrid/js/jquery.jqGrid.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {

            var grid = $('table#peserta-table').dataGrid({
                colModel: [
                    // { label: 'ID', name: 'id', key: true, width: 75, searchoptions:{sopt:['eq','ne','le','lt','gt','ge']}},
                    { label: ' ', name: 'action', width: 60, search:false, frozen:true},
                    { label: 'Username', name: 'username', width: 150, searchoptions:{sopt:['eq','ne','le','lt','gt','ge']}},
                    { label: 'Nama', name: 'name', width: 300, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                    { label: 'NIS', name: 'nis', width: 150, searchoptions:{sopt:['eq','ne','le','lt','gt','ge']}},
                    { label: 'Jenis Kelamin', name: 'gender', width: 150, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                    { label: 'Tanggal Lahir', name: 'tgl_lahir', width: 150, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                    { label: 'Kelas', name: 'kelas.nama', width: 100, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                    { label: 'Nomor', name: 'nomor', width: 70, search: false},
                    { label: 'Ruang', name: 'ruang', width: 70, search: false},
                    { label: 'Sesi', name: 'sesi', width: 70, search: false},
                    // { label: 'Password', name: 'password_text', width: 200, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}}
                ],
                onSelectRow: function(id){ 
                  console.log(id);
                },
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

            $('button[data-item="generate-ruang"').on('click', function(e){
                e && e.preventDefault();
                let url = $(this).data('url');
                swal({   
                    title: "Are you sure?",   
                    text: "Peserta akan di bagi ke ruang yang telah di set pada informasi sekolah",   
                    type: "warning",   
                    showCancelButton: true,   
                    confirmButtonColor: "#DD6B55",   
                    confirmButtonText: "Ya, Generate!",   
                    closeOnConfirm: false ,
                    showLoaderOnConfirm: true,
                }, function(){  
                    setTimeout(function(){
                        $.post(url, {}, function(res){
                            swal({
                                    title: "Generate!!",
                                    text: "Peserta berhasil di set",
                                    type: "success",
                                    timer: 1000,   
                                    showConfirmButton: false 
                            });
                            grid.trigger('reloadGrid');
                        });
                    }, 1000);  
                });
                grid.trigger('reloadGrid');
            });
        });
 
    </script>
@endsection