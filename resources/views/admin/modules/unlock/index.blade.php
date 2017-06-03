@extends('admin.layouts.app')

@section('css')
   
@endsection

@section('content')
<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Status Peserta</strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.ujian.create') }}" class="btn btn-sm btn-primary" data-bjax>Create</a>
        <a class="btn btn-sm btn-success btn-refresh" href="{{ url()->current() }}"><i class="icon-refresh"></i></a>
    </div>
</header>
<section class="scrollable wrapper">
    <div class="row">
        <div class="col-sm-12 col-md-12">
            @if(count($errors) > 0)
            <div class="alert alert-warning alert-block">
                @foreach($errors->all() as $error)
                <h4 class="font-thin">{{ $error }}</h4>
                @endforeach
            </div>
            @endif

            @if(session()->has('message'))
            <div class="alert alert-warning alert-block">
                <h4 class="font-thin">{{ session()->get('message') }}</h4>
            </div>
            @endif

            <section class="panel panel-default">
                <header class="panel-heading">Daftar Peserta </header>
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light" id="unlock-table" data-ride="datatables">
                        <thead>
                            <tr>
                                <th style="width:20px;">No.</th>
                                <th>No Ujian</th>
                                <th>Nama</th>
                                <th>No IP</th>
                                <th>Waktu Mulai Ujian</th>
                                <th>Paket Soal</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $no = 1; 
                                $status = ['Ready', 'Sedang Mengerjakan', 'Selesai'];
                            @endphp
                            @foreach($rows as $row)
                            <tr>
                                <td>{{ $no + ((request()->get('page', 1) - 1) * 25) }}</td>
                                <td>{{ $row->user->nis }}</td>
                                <td>{{ $row->user->name }}</td>
                                <td>{{ $row->ip }}</td>
                                <td>{{ $row->created_at }}</td>
                                <td>{{ $row->ujian->paket->nama }}</td>
                                <td>{{ $status[$row->status] }}</td>
                                <td>
                                    @if(in_array($row->status, [1,2]))
                                        <a href="{{ route('admin.status.unlock', $row->id) }}" class="btn btn-xs">Unlock</a>
                                    @endif
                                </td>
                            </tr>
                            @php $no++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        {{-- <div class="col-sm-4 hidden-xs">
                            <select class="input-sm form-control input-s inline v-middle">
                                <option value="0">Semua</option>
                                <option value="1">Sedang Berlangsung</option>
                                <option value="2">Belum Mulai</option>
                                <option value="3">Sudah Selesai</option>
                            </select>
                            <button class="btn btn-sm btn-default">Filter</button>                  
                        </div> --}}
                        <div class="col-sm-8 text-center">
                            {{-- <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small> --}}
                        </div>
                        <div class="col-sm-4 text-right text-center-xs">                
                            {{-- {{ $rows->links() }} --}}
                        </div>
                    </div>
                </footer>
            </section>
        </div>
        
    </div>
</section>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $('#unlock-table').DataTable({
            "sDom": "<'row'<'col-sm-6'l><'col-sm-6'f>r>t<'row'<'col-sm-6'i><'col-sm-6'p>>"
        });
    });
</script>
@endsection