<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan RUP</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background: #e0e0e0; font-weight: bold; }
        h2, h4 { text-align: center; }
    </style>
</head>
<body>
    <h2>LAPORAN RENCANA UMUM PENGADAAN</h2>
    <h4>Dicetak: {{ date('d/m/Y H:i') }}</h4>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Paket</th>
                <th>Nama Paket</th>
                <th>Unit Kerja</th>
                <th>Pagu Anggaran</th>
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
                <td>{{ number_format($paket->pagu_anggaran, 0, ',', '.') }}</td>
                <td>{{ $paket->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
