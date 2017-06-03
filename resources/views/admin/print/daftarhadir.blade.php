<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" print href="{{ asset('css/print.css') }}">
</head>
<body>

@php
    $maxr = $peserta->max('ruang');
    $maxs = $peserta->max('sesi'); 
@endphp
@for($i=1; $i<=$maxs; $i++)
    @for($j=1; $j<=$maxr; $j++)
    @php
        $collect = $peserta->where('sesi', $i)->where('ruang', $j)->get();
        $collect2 = $collect->slice(25);
        if(! count($collect) > 0) continue;
    @endphp
<div class="page">
    <table width="100%">
        <tbody>
            <tr>
                <td width="100">
                    <img src="{{ $setting->logo }}" height="75">
                </td>
                <td>
                    <center>
                        <strong class="f12">
                            DAFTAR HADIR PESERTA<br>
                            UJIAN BERBASIS KOMPUTER <br>
                            {{ strtoupper($setting->nama_sekolah) }}<br>
                            TAHUN PELAJARAN 2016/2017
                        </strong>
                    </center>
                </td>
                <td width="100">
                    
                </td>
            </tr>
        </tbody>
    </table>
    
    <table class="detail">
        <tbody>
            {{-- <tr>
                <td>KOTA/KABUPATEN</td><td>:</td>
                <td>
                    <span style="width:300px;">KOTA TANGERANG</span>
                </td>
                <td>KODE</td><td>:</td>
                <td>
                    <span style="width:100px;">02</span>
                </td>
            </tr> --}}
            <tr>
                <td>SEKOLAH/MADRASAH</td><td>:</td>
                <td>
                    <span style="width:300px;">
                    {{ strtoupper($setting->nama_sekolah) }}
                    </span>
                </td>
                <td>KODE</td><td>:</td>
                <td>
                    <span style="width:100px;">004</span>
                </td>
            </tr>
            <tr>
                <td>RUANG</td><td>:</td><td><span style="width:300px;">RUANG {{ $j}}</span></td>
                <td>SESI</td><td>:</td><td><span style="width:50px;">{{ $i }}</span></td>
            </tr>
            <tr>
                <td>HARI</td><td>:</td>
                <td><span style="width:100px;">Senin</span>TANGGAL : <span style="width:130px;">06 Maret 2017</span></td>
                <td>PUKUL</td><td>:</td><td><span style="width:100px;">07.30 - 09:30</span></td>
            </tr>
            <tr>
                <td>MATA PELAJARAN</td><td>:</td><td colspan="4"><span style="width:300px;">Matematika</span></td>
            </tr>
        </tbody>
    </table>

    <table class="table tbl-print" width="100%">
        <thead>
            <tr style="height:30px">
                <th>No.</th>
                <th>Username</th>
                <th>Nama Peserta</th>
                <th>Tanda Tangan</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($collect->take(25) as $row)
            <tr>
                <td width="15" align="center">{{ $row->nomor }}</td>
                <td width="120" align="center">{{ $row->username }}</td>
                <td width="250">{{ $row->name }}</td>
                <td width="150"><span style="float:{{($row->nomor % 2 == 1)? 'left' : 'right'}};width:70px;">{{ $row->nomor }}</span></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    

    <div class="footer">
        <table width="100%" height="30">
            <tbody>
                <tr>
                    <td width="25px" style="border:1px solid black"></td>
                    <td width="5px">&nbsp;</td>
                    <td style="border:1px solid black;font-weight:bold;font-size:14px;text-align:center;">
                        {{ strtoupper($setting->nama_sekolah) }}
                    </td>
                    <td width="5px">&nbsp;</td>
                    <td width="25px" style="border:1px solid black"></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<div class="page">
    <table width="100%">
        <tbody>
            <tr>
                <td width="100">
                    <img src="{{ $setting->logo }}" height="75">
                </td>
                <td>
                    <center>
                        <strong class="f12">
                            DAFTAR HADIR PESERTA<br>
                            UJIAN BERBASIS KOMPUTER <br>
                            {{ strtoupper($setting->nama_sekolah) }}<br>
                            TAHUN PELAJARAN 2016/2017
                        </strong>
                    </center>
                </td>
                <td width="100">
                    
                </td>
            </tr>
        </tbody>
    </table>
    
    <table class="detail">
        <tbody>
            {{-- <tr>
                <td>KOTA/KABUPATEN</td><td>:</td>
                <td>
                    <span style="width:300px;">KOTA TANGERANG</span>
                </td>
                <td>KODE</td><td>:</td>
                <td>
                    <span style="width:100px;">02</span>
                </td>
            </tr> --}}
            <tr>
                <td>SEKOLAH/MADRASAH</td><td>:</td>
                <td>
                    <span style="width:300px;">
                    {{ strtoupper($setting->nama_sekolah) }}
                    </span>
                </td>
                <td>KODE</td><td>:</td>
                <td>
                    <span style="width:100px;">004</span>
                </td>
            </tr>
            <tr>
                <td>RUANG</td><td>:</td><td><span style="width:300px;">RUANG {{ $j }}</span></td>
                <td>SESI</td><td>:</td><td><span style="width:50px;">{{ $i }}</span></td>
            </tr>
            <tr>
                <td>HARI</td><td>:</td>
                <td><span style="width:100px;">Senin</span>TANGGAL : <span style="width:130px;">06 Maret 2017</span></td>
                <td>PUKUL</td><td>:</td><td><span style="width:100px;">07.30 - 09:30</span></td>
            </tr>
            <tr>
                <td>MATA PELAJARAN</td><td>:</td><td colspan="4"><span style="width:300px;">Matematika</span></td>
            </tr>
        </tbody>
    </table>
    
    <table class="table tbl-print" width="100%">
        <thead>
            <tr style="height:30px">
                <th>No.</th>
                <th>Username</th>
                <th>Nama Peserta</th>
                <th>Tanda Tangan</th>
                <th>Ket</th>
            </tr>
        </thead>
        <tbody>
            @foreach($collect2 as $row)
            <tr>
                <td width="15" align="center">{{ $row->nomor }}</td>
                <td width="120" align="center">{{ $row->username }}</td>
                <td width="250">{{ $row->name }}</td>
                <td width="150"><span style="float:{{($row->nomor % 2 == 1)? 'left' : 'right'}};width:70px;">{{ $row->nomor }}</span></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>&nbsp;</p>
    <table>
        <tbody>
            <tr><td colspan="2"><strong><i>Keterangan : </i></strong></td></tr>
            <tr><td>1. Dibuat rangkap 3 (tiga), masing-masing untuk sekolah, kota/kab dan Provinsi.</td></tr>
            <tr><td>2. Pengawas ruang menyilang Nama Peserta yang tidak hadir.</td></tr>
            <tr><td>3. Daftar hadir untuk pusat di upload melalui web UNBK.</td></tr>
        </tbody>
    </table>

    <table width="100%">
        <tbody>
            <tr>
                <td>
                    <table style="border:1px solid black">
                        <tbody>
                            <tr>
                                <td>Jumlah Peserta yang Seharusnya Hadir</td>
                                <td>:</td>
                                <td>_____ orang</td>
                            </tr>
                            <tr>
                                <td>Jumlah Peserta yang Tidak Hadir</td>
                                <td>:</td>
                                <td>_____ orang</td>
                            </tr>
                            <tr style="border-top:1px solid black">
                                <td>Jumlah Peserta Hadir</td>
                                <td>:</td>
                                <td>_____ orang</td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td align="center" width="200">
                    Proktor<br><br><br><br><br>(<nip></nip>)<br><br>&nbsp;&nbsp;&nbsp;&nbsp;NIP. <nip></nip>
                </td>
                <td align="center" width="175">
                    Pengawas<br><br><br><br><br>(<nip></nip>)<br><br>&nbsp;&nbsp;&nbsp;&nbsp;NIP. <nip></nip>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <table width="100%" height="30">
            <tbody>
                <tr>
                    <td width="25px" style="border:1px solid black"></td>
                    <td width="5px">&nbsp;</td>
                    <td style="border:1px solid black;font-weight:bold;font-size:14px;text-align:center;">
                        {{ strtoupper($setting->nama_sekolah) }}
                    </td>
                    <td width="5px">&nbsp;</td>
                    <td width="25px" style="border:1px solid black"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
    @endfor
@endfor

</body>
</html>