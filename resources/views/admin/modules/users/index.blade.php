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
        <button class="btn btn-sm btn-info"><i class="icon-cloud-download"></i> Download</button>
        <button class="btn btn-sm btn-info"><i class="icon-cloud-upload"></i> Upload</button>
    </div>
</header>
<section class="data-grid">
    <table id="jqGrid"></table>
    <div id="jqGridPager"></div>
</section>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('vendor/jqgrid/js/i18n/grid.locale-id.js') }}"></script>
    <script type="text/javascript" src="{{ asset('vendor/jqgrid/js/jquery.jqGrid.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var $heightDiv = ($(".data-grid").height() - (56 + 28));
            
            var jqGridTable = $("#jqGrid").jqGrid({
                url: '{{ route('admin.peserta.data') }}',
                mtype: "POST",
                datatype: "json",
                colModel: [
                    // { label: 'ID', name: 'id', key: true, width: 75, searchoptions:{sopt:['eq','ne','le','lt','gt','ge']}},
                    { label: 'Nama', name: 'name', width: 400, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}},
                    { label: 'Email', name: 'email', width: 500, searchoptions:{sopt:['eq','bw','bn','cn','nc','ew','en']}}
                ],
                viewrecords: true,
                autowidth: true,
                scrollerbar:true,
                height: $heightDiv,
                maxHeight: 300,
                rowNum: 25,
                rowList:[25,50,100,200],
                rownumbers: true,
                shrinkToFit: false,
                multiselect: true,
                pager: "#jqGridPager"
            });

            jqGridTable.jqGrid('filterToolbar', {searchOperators : true});
        });
 
    </script>
@endsection