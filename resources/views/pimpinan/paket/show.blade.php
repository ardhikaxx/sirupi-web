@extends('layouts.app')

@section('title', 'Detail Persetujuan Paket')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pimpinan.paket.index') }}">Persetujuan Paket</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="fas fa-box me-2 text-primary"></i>Detail Paket Pengadaan</h5>
        <a href="{{ route('pimpinan.paket.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali
        </a>
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
                        <th class="pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paket->dokumens as $dokumen)
                    <tr>
                        <td class="ps-4">{{ $dokumen->nama_dokumen }}</td>
                        <td>{{ $dokumen->tipe_dokumen ?? '-' }}</td>
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

@if($paket->status === 'diverifikasi')
<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-header bg-white border-0 pt-4 px-4">
        <h5 class="fw-bold mb-0"><i class="fas fa-sticky-note me-2 text-primary"></i>Catatan Verifikator</h5>
    </div>
    <div class="card-body px-4 pb-4">
        @php
            $riwayatVerif = $paket->riwayatPersetujuans->where('aksi', 'diverifikasi')->first();
        @endphp
        @if($riwayatVerif && $riwayatVerif->catatan)
            <p>{{ $riwayatVerif->catatan }}</p>
        @else
            <p class="text-muted mb-0">Tidak ada catatan dari verifikator.</p>
        @endif
    </div>
</div>

<div class="d-flex gap-2 justify-content-end">
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#setujuiModal">
        <i class="fas fa-check me-1"></i>Setujui
    </button>
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tolakModal">
        <i class="fas fa-times me-1"></i>Tolak
    </button>
</div>
@endif

<div class="modal fade" id="setujuiModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('pimpinan.paket.setujui', $paket->id) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Setujui Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan menyetujui paket <strong>{{ $paket->nama_paket }}</strong>.</p>
                    <div class="mb-3">
                        <label class="form-label">Nomor Persetujuan <span class="text-danger">*</span></label>
                        <input type="text" name="nomor_persetujuan" class="form-control" placeholder="Contoh: 027/SP/2024" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Catatan (opsional)</label>
                        <textarea name="catatan" class="form-control" rows="3" placeholder="Tambahkan catatan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Ya, Setujui</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="tolakModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('pimpinan.paket.tolak', $paket->id) }}" method="POST" id="formTolak">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Paket</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Anda akan menolak paket <strong>{{ $paket->nama_paket }}</strong>.</p>
                    <div class="mb-3">
                        <label class="form-label">Catatan <span class="text-danger">*</span></label>
                        <textarea name="catatan" id="catatanTolak" class="form-control" rows="3" placeholder="Minimal 10 karakter" required></textarea>
                        <small class="text-muted">Minimal 10 karakter</small>
                        <div class="invalid-feedback">Catatan harus diisi minimal 10 karakter.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger" id="btnTolak">Ya, Tolak</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $('#formTolak').on('submit', function(e) {
        var catatan = $('#catatanTolak').val().trim();
        if (catatan.length < 10) {
            e.preventDefault();
            $('#catatanTolak').addClass('is-invalid');
            Swal.fire({
                icon: 'error',
                title: 'Validasi',
                text: 'Catatan harus diisi minimal 10 karakter.'
            });
        }
    });

    $('#tolakModal').on('hidden.bs.modal', function() {
        $('#catatanTolak').removeClass('is-invalid');
    });
</script>
@endpush
