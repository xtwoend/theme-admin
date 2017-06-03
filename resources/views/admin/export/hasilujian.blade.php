<html>
<table>
    <tr>
        <th>No</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Paket Soal</th>
        <th>Benar</th>
        <th>Salah</th>
        <th>Kosong</th>
        <th>Hasil</th>
    </tr>
    @php
        $no = 1;
    @endphp
    @foreach($rows as $row)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $row->user->nis }}</td>
        <td>{{ $row->user->name }}</td>
        <td>{{ $row->user->kelas->nama }}</td>
        <td>{{ $row->ujian->paket->nama }}</td>
        <td>{{ $row->benar }}</td>
        <td>{{ $row->salah }}</td>
        <td>{{ $row->kosong }}</td>
        <td></td>
    </tr>
    @endforeach
</table>
</html>