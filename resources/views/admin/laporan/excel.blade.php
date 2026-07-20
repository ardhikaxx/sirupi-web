<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan RUP</title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background: #ccc; }
    </style>
</head>
<body>
    <h2>Laporan Rencana Umum Pengadaan</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Paket</th>
                <th>Nama Paket</th>
                <th>Unit Kerja</th>
                <th>Tahun Anggaran</th>
                <th>Pagu (Rp)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pakets as $paket)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $paket->kode_paket }}</td>
                <td>{{ $paket->nama_paket }}</td>
                <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                <td>{{ $paket->tahunAnggaran->tahun ?? '-' }}</td>
                <td>{{ number_format($paket->pagu_anggaran, 0, ',', '.') }}</td>
                <td>{{ $paket->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
