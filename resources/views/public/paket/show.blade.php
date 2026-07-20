@extends('layouts.public')

@section('title', $paket->nama_paket . ' - SIRUPI')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <a href="{{ route('publik.paket.index') }}" class="btn btn-outline-secondary mb-4">
                <i class="fas fa-arrow-left me-1"></i>Kembali
            </a>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">{{ $paket->nama_paket }}</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th style="width:160px">Kode Paket</th>
                                    <td class="font-mono">{{ $paket->kode_paket }}</td>
                                </tr>
                                <tr>
                                    <th>Unit Kerja</th>
                                    <td>{{ $paket->unitKerja->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pagu Anggaran</th>
                                    <td class="fw-bold">{{ formatRupiah($paket->pagu_anggaran) }}</td>
                                </tr>
                                <tr>
                                    <th>Sumber Dana</th>
                                    <td>{{ $paket->sumberDana->nama ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered mb-0">
                                <tr>
                                    <th style="width:160px">Jenis Pengadaan</th>
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
                                    <th>Tahun Anggaran</th>
                                    <td>{{ $paket->tahunAnggaran->tahun ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-file-alt me-2 text-primary"></i>Uraian Pekerjaan</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <p class="mb-0">{{ $paket->uraian_pekerjaan ?? '-' }}</p>
                </div>
            </div>

            @if($paket->paketJadwals->count() > 0)
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Jadwal</h5>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Tahapan</th>
                                    <th>Tanggal Mulai</th>
                                    <th class="pe-4">Tanggal Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paket->paketJadwals as $jadwal)
                                <tr>
                                    <td class="ps-4">{{ $jadwal->tahapan }}</td>
                                    <td>{{ formatTanggal($jadwal->tanggal_mulai) }}</td>
                                    <td class="pe-4">{{ formatTanggal($jadwal->tanggal_selesai) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @if($paket->paketLokasis->count() > 0)
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Lokasi</h5>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Provinsi</th>
                                    <th>Kab/Kota</th>
                                    <th>Kecamatan</th>
                                    <th class="pe-4">Kel/Desa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paket->paketLokasis as $lokasi)
                                <tr>
                                    <td class="ps-4">{{ $lokasi->provinsi }}</td>
                                    <td>{{ $lokasi->kabupaten_kota }}</td>
                                    <td>{{ $lokasi->kecamatan }}</td>
                                    <td class="pe-4">{{ $lokasi->kelurahan_desa }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            @php
                $publicDocs = $paket->dokumens->where('is_public', true);
            @endphp
            @if($publicDocs->count() > 0)
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 pt-4 px-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-file me-2 text-primary"></i>Dokumen</h5>
                </div>
                <div class="card-body px-0 pb-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Dokumen</th>
                                    <th class="pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($publicDocs as $dokumen)
                                <tr>
                                    <td class="ps-4">{{ $dokumen->nama_dokumen }}</td>
                                    <td class="pe-4">
                                        <a href="{{ asset('storage/' . $dokumen->file_path) }}" class="btn btn-sm btn-primary" target="_blank">
                                            <i class="fas fa-download me-1"></i>Unduh
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <div class="text-center mt-4">
                <a href="{{ route('publik.paket.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
