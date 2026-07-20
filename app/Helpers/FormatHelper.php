<?php
if (!function_exists('formatRupiah')) {
    function formatRupiah($angka)
    {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

if (!function_exists('formatTanggal')) {
    function formatTanggal($tanggal, $format = 'd F Y')
    {
        if (!$tanggal) return '-';
        $hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $t = strtotime($tanggal);
        $d = date('j', $t);
        $m = (int)date('n', $t);
        $y = date('Y', $t);
        if ($format === 'd F Y') return $d . ' ' . $bulan[$m] . ' ' . $y;
        if ($format === 'd-m-Y') return date('d-m-Y', $t);
        return date($format, $t);
    }
}

if (!function_exists('statusBadge')) {
    function statusBadge($status)
    {
        $colors = [
            'draft' => 'secondary',
            'diajukan' => 'primary',
            'diverifikasi' => 'info',
            'dikembalikan' => 'warning',
            'disetujui' => 'success',
            'ditolak' => 'danger',
            'dipublikasikan' => 'dark',
        ];
        $labels = [
            'draft' => 'Draft',
            'diajukan' => 'Diajukan',
            'diverifikasi' => 'Terverifikasi',
            'dikembalikan' => 'Dikembalikan',
            'disetujui' => 'Disetujui',
            'ditolak' => 'Ditolak',
            'dipublikasikan' => 'Dipublikasikan',
        ];
        $color = $colors[$status] ?? 'secondary';
        $label = $labels[$status] ?? ucfirst($status);
        return '<span class="badge bg-' . $color . '">' . $label . '</span>';
    }
}

if (!function_exists('generateKodePaket')) {
    function generateKodePaket($unitKerja, $tahun, $urutan)
    {
        $kodeUnit = str_pad($unitKerja, 5, '0', STR_PAD_LEFT);
        $noUrut = str_pad($urutan, 4, '0', STR_PAD_LEFT);
        return 'RUP-' . $tahun . '-' . $kodeUnit . '-' . $noUrut;
    }
}
