<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" print href="{{ asset('css/print.css') }}">
</head>
<body>
    

        
@php
    $counter = 1;
    $page = 1;
@endphp
@foreach($peserta->get() as $row)
{{-- page --}}
@if($page == 1)
<div class="page">
    <center>
        <table align="center">
            <tbody>
@endif

{!! ($counter % 2 == 1)? '<tr>': '' !!}

                <td style="padding:8px;">
                    <table style="width:9cm;border:1px solid black;" class="kartu">
                        <tbody><tr>
                            <td colspan="3" style="border-bottom:1px solid black">
                                <table width="100%" class="kartu">
                                <tbody><tr>
                                    <td><img src="{{ $setting->logo }}" height="40"></td>
                                    <td align="center" style="font-weight:bold">
                                        KARTU PESERTA UJIAN<br> 
                                        {{ strtoupper($setting->nama_sekolah) }}
                                    </td>
                                </tr>
                                </tbody></table>
                            </td>
                        </tr>
                        <tr><td width="115">Nama Peserta</td><td width="1">:</td><td>{{ $row->name }}</td></tr>
        
                        <tr><td>Kelas</td><td>:</td><td>{{ $row->kelas->nama }}</td></tr>
                        <tr><td>Username</td><td>:</td><td style="font-size:12px;font-weight:bold;">{{ $row->username }}</td></tr>
                        <tr><td>Password</td><td>:</td><td style="font-size:12px;font-weight:bold;">{{ $row->password_text }}</td></tr>
                        <tr><td>Ruang</td><td>:</td><td>RUANG {{ $row->ruang }}</td></tr>
                        <tr><td>Sesi</td><td>:</td><td>{{ $row->sesi }} </td></tr>
                        <tr><td>&nbsp;</td><td></td><td></td></tr>
                        </tbody>
                    </table>
                </td>

{!! ($counter % 2 == 0)? '</tr>': '' !!}

{{-- end page --}}
@if($page == 10) 
            </tbody>
        </table>
    </center>
</div>
@endif

@php
    $counter++;
    $page++;
    if(($counter % 2 == 1)){
        $counter = 1;
    }
    if($page > 10){
        $page=1;
    } 
@endphp

@endforeach 

</body>
</html>