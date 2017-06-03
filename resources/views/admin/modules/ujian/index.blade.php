@extends('admin.layouts.app')

@section('css')
   
@endsection

@section('content')
<header class="header bg-light lter hidden-print bg-white box-shadow">
    <p> <strong>Daftar Test Berlangsung</strong></p>
    <div class="pull-right" style="margin-top: 10px;">
        <a href="{{ route('admin.ujian.create') }}" class="btn btn-sm btn-primary" data-bjax>Create</a>
        <a class="btn btn-sm btn-success btn-refresh" href="{{ url()->current() }}"><i class="icon-refresh"></i></a>
    </div>
</header>
<section class="scrollable wrapper">
    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-9">
            <section class="panel panel-default">
                <header class="panel-heading">Daftar Test</header>
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                            <tr>
                                <th style="width:20px;">No.</th>
                                <th class="th-sortable" data-toggle="class">
                                    Nama Ujian
                                </th>
                                <th class="th-sortable" data-toggle="class">
                                    Mata Pelajaran
                                </th>
                                <th class="th-sortable" data-toggle="class">
                                    Paket Soal
                                </th>
                                <th>Waktu Mulai</th>
                                <th>Status</th>
                                <th>Token</th>
                                <th style="width:120px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp
                            @foreach($rows as $row)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $row->nama }}</td>
                                <td>{{ $row->mapel->nama }}</td>
                                <td>{{ $row->paket->nama }}</td>
                                <td>{{ $row->waktu_mulai->format('Y-m-d H:i') }}</td>
                                <td>{{ ($row->status)? 'Aktif': 'Tidak Aktif' }}</td>
                                {{-- <td>{{ ($row->waktu_berakhir > Carbon\Carbon::now())?$row->waktu_berakhir->diff(Carbon\Carbon::now())->format('%H:%I'): 'Telah berakhir' }}</td> --}}
                                <td>{{ $row->token }}</td>
                                <td>
                                    <a href="{{ route('admin.ujian.edit', $row->id) }}" data-bjax style="margin-right: 10px;"><i class="icon-pencil"></i></a>
                                    
                                    <a href="{{ route('admin.ujian.index', ['id' => $row->id]) }}" data-target="#content" data-el="#bjax-el" data-replace="true"><i class="icon-screen-desktop"></i></a>

                                    <a href="{{ route('admin.laporan.index', ['ujian_id' => $row->id]) }}" class="btn btn-primary btn-xs">Hasil</a>

                                </td>
                            </tr>
                            @php $no++; @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-4 hidden-xs">
                            {{-- <select class="input-sm form-control input-s inline v-middle">
                                <option value="0">Semua</option>
                                <option value="1">Sedang Berlangsung</option>
                                <option value="2">Belum Mulai</option>
                                <option value="3">Sudah Selesai</option>
                            </select>
                            <button class="btn btn-sm btn-default">Filter</button>  --}}                 
                        </div>
                        <div class="col-sm-4 text-center">
                            {{-- <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small> --}}
                        </div>
                        <div class="col-sm-4 text-right text-center-xs">                
                            {{ $rows->links() }}
                        </div>
                    </div>
                </footer>
            </section>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-3">
            @if($ujian)
            <section class="panel panel-default">
                <div class="text-center wrapper bg-light lt">
                    @if($ujian->waktu_berakhir > Carbon\Carbon::now())
                        @php 
                            $seconds = $ujian->waktu_berakhir->diffInSeconds(Carbon\Carbon::now());
                        @endphp
                        <div class="expired_date" data-timer="{{ $seconds }}"></div>
                    @else
                        <h4>Ujian Telah Berakhir</h4>
                    @endif
                </div>
                <ul class="list-group no-radius">
                    <li class="list-group-item text-center text-success">
                        <button class="btn btn-success btn-sm pull-right" style="margin-top: 5px;" data-item="get-token" data-url="{{ route('admin.ujian.refreshtoken', $ujian->id) }}"><i class="icon-refresh"></i></button>
                        <h4 class="token">{{ $ujian->token }}</h4>
                    </li>
                    <li class="list-group-item">
                        <span class="pull-right font-bold">{{ $ujian->mapel->nama }}</span>
                        <span class="text-muted">Mata pelajaran</span>
                    </li>
                    <li class="list-group-item">
                        <span class="pull-right font-bold">{{ $ujian->waktu_mulai->format('Y-m-d H:i') }}</span>
                        Waktu Mulai
                    </li>
                    <li class="list-group-item">
                        <span class="pull-right font-bold">{{ $ujian->waktu_berakhir->format('Y-m-d H:i') }}</span>
                        Waktu Berakhir
                    </li>
                    <li class="list-group-item">
                        <span class="pull-right font-bold">{{ $ujian->jumlah_soal }}</span>
                        Jumlah Soal
                    </li>
                    <li class="list-group-item">    
                        @if($ujian->status == 1)
                        <span class="btn btn-block btn-success">Aktif</span>
                        @else
                        <span class="btn btn-block btn-danger">Tidak Aktif</span>
                        @endif
                    </li>
                </ul>
            </section>
            @endif
        </div>
    </div>
</section>
@endsection

@section('js')
<script>
    $(".expired_date").TimeCircles({ time: { Days: { show: false }, Hours: { show: true }, Seconds: { show: false } }}); 
    $('button[data-item="get-token"]').on('click', function(e){
        e && e.preventDefault();
        $.post($(this).data('url'), {}, function(res){
            $('.token').text(res);
        });
    });
</script>
@endsection