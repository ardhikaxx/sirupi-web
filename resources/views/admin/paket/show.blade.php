@extends('layouts.app')

@section('title', 'Detail Paket Pengadaan')

@php
    $menu = 'paket';
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.paket.index') }}">Paket Pengadaan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card mb-3">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Detail Paket Pengadaan</h5>
        <div class="d-flex gap-2">
            @if($paket->status === 'disetujui' && !$paket->is_published)
                <button class="btn btn-success btn-sm btn-publikasikan" data-id="{{ $paket->id }}">
                    <i class="fas fa-globe me-1"></i>Publikasikan
                </button>
                <form id="publikasikan-form-{{ $paket->id }}" action="{{ route('admin.paket.publish', $paket->id) }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endif
            <a href="{{ route('admin.paket.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width:180px">Kode Paket</th>
                        <td>{{ $paket->kode_paket }}</td>
                    </tr>
                    <tr>
                        <th>Nama Paket</th>
                        <td>{{ $paket->nama_paket }}</td>
                    </tr>
                    <tr>
                        <th>Uraian Pekerjaan</th>
                        <td>{{ $paket->uraian_pekerjaan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pagu Anggaran</th>
                        <td>{{ formatRupiah($paket->pagu_anggaran) }}</td>
                    </tr>
                    <tr>
                        <th>HPS</th>
                        <td>{{ formatRupiah($paket->hps) }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{!! statusBadge($paket->status) !!}</td>
                    </tr>
                    <tr>
                        <th>Versi</th>
                        <td>{{ $paket->versi }}</td>
                    </tr>
                    <tr>
                        <th>Revisi ke</th>
                        <td>{{ $paket->is_revised ? 'Ya' : 'Tidak' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th style="width:180px">Unit Kerja</th>
                        <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tahun Anggaran</th>
                        <td>{{ $paket->tahunAnggaran->nama ?? '-' }} ({{ $paket->tahunAnggaran->tahun ?? '-' }})</td>
                    </tr>
                    <tr>
                        <th>Program</th>
                        <td>{{ $paket->program->kode ?? '-' }} - {{ $paket->program->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kegiatan</th>
                        <td>{{ $paket->kegiatan->kode ?? '-' }} - {{ $paket->kegiatan->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Sub Kegiatan</th>
                        <td>{{ $paket->subKegiatan->kode ?? '-' }} - {{ $paket->subKegiatan->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Sumber Dana</th>
                        <td>{{ $paket->sumberDana->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Pengadaan</th>
                        <td>{{ $paket->jenisPengadaan->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Metode Pengadaan</th>
                        <td>{{ $paket->metodePengadaan->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $paket->kategori->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Satuan</th>
                        <td>{{ $paket->satuan->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Penyedia</th>
                        <td>{{ $paket->penyedia->nama ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Oleh</th>
                        <td>{{ $paket->user->name ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Pejabat</h6></div>
            <div class="card-body">
                <table class="table table-bordered mb-0">
                    <tr><th style="width:120px">PPTK</th><td>{{ $paket->pptk->nama ?? '-' }}</td></tr>
                    <tr><th>PP</th><td>{{ $paket->pp->nama ?? '-' }}</td></tr>
                    <tr><th>PA/KPA</th><td>{{ $paket->paKpa->nama ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h6 class="mb-0">Lokasi</h6></div>
            <div class="card-body">
                @if($paket->paketLokasis->count() > 0)
                    <table class="table table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Provinsi</th>
                                <th>Kab/Kota</th>
                                <th>Kecamatan</th>
                                <th>Kel/Desa</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paket->paketLokasis as $lokasi)
                            <tr>
                                <td>{{ $lokasi->provinsi }}</td>
                                <td>{{ $lokasi->kabupaten_kota }}</td>
                                <td>{{ $lokasi->kecamatan }}</td>
                                <td>{{ $lokasi->kelurahan_desa }}</td>
                                <td>{{ $lokasi->detail_alamat ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted mb-0">Tidak ada data lokasi.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Rincian Anggaran</h6></div>
    <div class="card-body">
        @if($paket->paketAnggarans->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Item</th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paket->paketAnggarans as $item)
                        <tr>
                            <td>{{ $item->nama_item }}</td>
                            <td>{{ $item->volume }}</td>
                            <td>{{ $item->satuan->nama ?? '-' }}</td>
                            <td>{{ formatRupiah($item->harga_satuan) }}</td>
                            <td>{{ formatRupiah($item->total) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-end">Total</th>
                            <th>{{ formatRupiah($paket->paketAnggarans->sum('total')) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <p class="text-muted mb-0">Tidak ada rincian anggaran.</p>
        @endif
    </div>
</div>

<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Jadwal</h6></div>
    <div class="card-body">
        @if($paket->paketJadwals->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tahapan</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paket->paketJadwals as $jadwal)
                        <tr>
                            <td>{{ $jadwal->tahapan }}</td>
                            <td>{{ formatTanggal($jadwal->tanggal_mulai) }}</td>
                            <td>{{ formatTanggal($jadwal->tanggal_selesai) }}</td>
                            <td>{{ $jadwal->keterangan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted mb-0">Tidak ada data jadwal.</p>
        @endif
    </div>
</div>

<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Dokumen</h6></div>
    <div class="card-body">
        @if($paket->dokumens->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Dokumen</th>
                            <th>Tipe</th>
                            <th>Ukuran</th>
                            <th>Diupload Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paket->dokumens as $dokumen)
                        <tr>
                            <td>{{ $dokumen->nama_dokumen }}</td>
                            <td>{{ $dokumen->tipe_dokumen ?? '-' }}</td>
                            <td>{{ $dokumen->file_size ? number_format($dokumen->file_size / 1024, 1) . ' KB' : '-' }}</td>
                            <td>{{ $dokumen->uploader->name ?? '-' }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $dokumen->file_path) }}" class="btn btn-sm btn-primary" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted mb-0">Tidak ada dokumen.</p>
        @endif
    </div>
</div>

<div class="card mb-3">
    <div class="card-header"><h6 class="mb-0">Riwayat Persetujuan</h6></div>
    <div class="card-body">
        @if($paket->riwayatPersetujuans->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>User</th>
                            <th>Aksi</th>
                            <th>Status Dari</th>
                            <th>Status Ke</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paket->riwayatPersetujuans as $riwayat)
                        <tr>
                            <td>{{ formatTanggal($riwayat->created_at, 'd-m-Y H:i') }}</td>
                            <td>{{ $riwayat->user->name ?? '-' }}</td>
                            <td>
                                @php
                                    $aksiColors = ['diajukan' => 'primary', ' diverifikasi' => 'info', ' dikembalikan' => 'warning', 'disetujui' => 'success', 'ditolak' => 'danger'];
                                @endphp
                                <span class="badge bg-{{ $aksiColors[$riwayat->aksi] ?? 'secondary' }}">{{ ucfirst($riwayat->aksi) }}</span>
                            </td>
                            <td>{!! statusBadge($riwayat->status_dari) !!}</td>
                            <td>{!! statusBadge($riwayat->status_ke) !!}</td>
                            <td>{{ $riwayat->catatan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-muted mb-0">Belum ada riwayat persetujuan.</p>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.btn-publikasikan').on('click', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Publikasikan Paket',
            text: 'Paket yang dipublikasikan akan tampil di halaman publik. Lanjutkan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Ya, publikasikan!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                $('#publikasikan-form-' + id).submit();
            }
        });
    });
</script>
@endpush
