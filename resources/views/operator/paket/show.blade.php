@extends('layouts.app')

@section('title', 'Detail Paket')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('operator.paket.index') }}">Paket Saya</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-box me-2 text-primary"></i>Detail Paket Pengadaan</h5>
        <div class="d-flex gap-2">
            @if(in_array($paket->status, ['draft', 'dikembalikan']))
                <a href="{{ route('operator.paket.edit', $paket->id) }}" class="btn btn-warning btn-sm">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
            @endif
            @if($paket->status === 'draft')
                <button class="btn btn-primary btn-sm btn-ajukan" data-id="{{ $paket->id }}">
                    <i class="fas fa-paper-plane me-1"></i>Ajukan Verifikasi
                </button>
                <form id="ajukan-form-{{ $paket->id }}" action="{{ route('operator.paket.submit', $paket->id) }}" method="POST" class="d-none">
                    @csrf
                </form>
            @endif
            <a href="{{ route('operator.paket.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body px-4 pb-4">
        <div class="row">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th style="width:180px">Kode Paket</th><td>{{ $paket->kode_paket ?? '-' }}</td></tr>
                    <tr><th>Nama Paket</th><td>{{ $paket->nama_paket }}</td></tr>
                    <tr><th>Uraian Pekerjaan</th><td>{{ $paket->uraian_pekerjaan ?? '-' }}</td></tr>
                    <tr><th>Pagu Anggaran</th><td>{{ formatRupiah($paket->pagu_anggaran) }}</td></tr>
                    <tr><th>HPS</th><td>{{ $paket->hps ? formatRupiah($paket->hps) : '-' }}</td></tr>
                    <tr><th>Status</th><td>{!! statusBadge($paket->status) !!}</td></tr>
                    <tr><th>Versi</th><td>{{ $paket->versi ?? 1 }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr><th style="width:180px">Unit Kerja</th><td>{{ $paket->unitKerja->nama ?? '-' }}</td></tr>
                    <tr><th>Tahun Anggaran</th><td>{{ $paket->tahunAnggaran->nama ?? '-' }} ({{ $paket->tahunAnggaran->tahun ?? '-' }})</td></tr>
                    <tr><th>Program</th><td>{{ $paket->program->kode ?? '-' }} - {{ $paket->program->nama ?? '-' }}</td></tr>
                    <tr><th>Kegiatan</th><td>{{ $paket->kegiatan->kode ?? '-' }} - {{ $paket->kegiatan->nama ?? '-' }}</td></tr>
                    <tr><th>Sub Kegiatan</th><td>{{ $paket->subKegiatan->kode ?? '-' }} - {{ $paket->subKegiatan->nama ?? '-' }}</td></tr>
                    <tr><th>Sumber Dana</th><td>{{ $paket->sumberDana->nama ?? '-' }}</td></tr>
                    <tr><th>Jenis Pengadaan</th><td>{{ $paket->jenisPengadaan->nama ?? '-' }}</td></tr>
                    <tr><th>Metode Pengadaan</th><td>{{ $paket->metodePengadaan->nama ?? '-' }}</td></tr>
                    <tr><th>Kategori</th><td>{{ $paket->kategori->nama ?? '-' }}</td></tr>
                    <tr><th>Satuan</th><td>{{ $paket->satuan->nama ?? '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-calculator me-2 text-primary"></i>Rincian Anggaran</h5>
    </div>
    <div class="card-body px-0 pb-0">
        @if($paket->paketAnggarans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nama Item</th>
                        <th>Volume</th>
                        <th>Satuan</th>
                        <th>Harga Satuan</th>
                        <th class="pe-4">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paket->paketAnggarans as $item)
                    <tr>
                        <td class="ps-4">{{ $item->nama_item }}</td>
                        <td>{{ $item->volume }}</td>
                        <td>{{ $item->satuan->nama ?? '-' }}</td>
                        <td>{{ formatRupiah($item->harga_satuan) }}</td>
                        <td class="pe-4">{{ formatRupiah($item->total) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="4" class="text-end pe-4">Total</th>
                        <th class="pe-4">{{ formatRupiah($paket->paketAnggarans->sum('total')) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-4"><i class="fas fa-info-circle me-2"></i>Tidak ada rincian anggaran.</div>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Jadwal</h5>
    </div>
    <div class="card-body px-0 pb-0">
        @if($paket->paketJadwals->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Tahapan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th class="pe-4">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paket->paketJadwals as $jadwal)
                    <tr>
                        <td class="ps-4">{{ $jadwal->tahapan }}</td>
                        <td>{{ formatTanggal($jadwal->tanggal_mulai) }}</td>
                        <td>{{ formatTanggal($jadwal->tanggal_selesai) }}</td>
                        <td class="pe-4">{{ $jadwal->keterangan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-4"><i class="fas fa-info-circle me-2"></i>Tidak ada data jadwal.</div>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Lokasi</h5>
    </div>
    <div class="card-body px-0 pb-0">
        @if($paket->paketLokasis->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Provinsi</th>
                        <th>Kab/Kota</th>
                        <th>Kecamatan</th>
                        <th>Kel/Desa</th>
                        <th class="pe-4">Detail Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paket->paketLokasis as $lokasi)
                    <tr>
                        <td class="ps-4">{{ $lokasi->provinsi }}</td>
                        <td>{{ $lokasi->kabupaten_kota }}</td>
                        <td>{{ $lokasi->kecamatan }}</td>
                        <td>{{ $lokasi->kelurahan_desa }}</td>
                        <td class="pe-4">{{ $lokasi->detail_alamat ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-4"><i class="fas fa-info-circle me-2"></i>Tidak ada data lokasi.</div>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-upload me-2 text-primary"></i>Dokumen</h5>
    </div>
    <div class="card-body px-0 pb-0">
        @if($paket->dokumens->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Nama Dokumen</th>
                        <th>Tipe</th>
                        <th>Ukuran</th>
                        <th class="pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paket->dokumens as $dokumen)
                    <tr>
                        <td class="ps-4">{{ $dokumen->nama_dokumen }}</td>
                        <td>{{ $dokumen->tipe_dokumen ?? '-' }}</td>
                        <td>{{ $dokumen->file_size ? number_format($dokumen->file_size / 1024, 1) . ' KB' : '-' }}</td>
                        <td class="pe-4">
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
        <div class="text-center text-muted py-4"><i class="fas fa-info-circle me-2"></i>Tidak ada dokumen.</div>
        @endif
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-history me-2 text-primary"></i>Riwayat Persetujuan</h5>
    </div>
    <div class="card-body px-0 pb-0">
        @if($paket->riwayatPersetujuans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Tanggal</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Status Dari</th>
                        <th>Status Ke</th>
                        <th class="pe-4">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paket->riwayatPersetujuans as $riwayat)
                    <tr>
                        <td class="ps-4">{{ formatTanggal($riwayat->created_at, 'd-m-Y H:i') }}</td>
                        <td>{{ $riwayat->user->name ?? '-' }}</td>
                        <td>
                            @php
                                $aksiColors = ['diajukan' => 'primary', 'diverifikasi' => 'info', 'dikembalikan' => 'warning', 'disetujui' => 'success', 'ditolak' => 'danger'];
                            @endphp
                            <span class="badge bg-{{ $aksiColors[$riwayat->aksi] ?? 'secondary' }}">{{ ucfirst($riwayat->aksi) }}</span>
                        </td>
                        <td>{!! statusBadge($riwayat->status_dari) !!}</td>
                        <td>{!! statusBadge($riwayat->status_ke) !!}</td>
                        <td class="pe-4">{{ $riwayat->catatan ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center text-muted py-4"><i class="fas fa-info-circle me-2"></i>Belum ada riwayat persetujuan.</div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('.btn-ajukan').on('click', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Ajukan Verifikasi',
            text: 'Paket akan diajukan untuk diverifikasi. Lanjutkan?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#0d6efd',
            confirmButtonText: 'Ya, ajukan!',
            cancelButtonText: 'Batal'
        }).then(result => {
            if (result.isConfirmed) {
                $('#ajukan-form-' + id).submit();
            }
        });
    });
</script>
@endpush
