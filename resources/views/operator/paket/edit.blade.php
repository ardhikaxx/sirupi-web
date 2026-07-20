@extends('layouts.app')

@section('title', 'Edit Paket')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('operator.paket.index') }}">Paket Saya</a></li>
    <li class="breadcrumb-item"><a href="{{ route('operator.paket.show', $paket->id) }}">Detail Paket</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<form action="{{ route('operator.paket.update', $paket->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')
    <input type="hidden" name="action" id="formAction" value="draft">

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Informasi Umum</h5>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Paket <span class="text-danger">*</span></label>
                    <input type="text" name="nama_paket" class="form-control @error('nama_paket') is-invalid @enderror" value="{{ old('nama_paket', $paket->nama_paket) }}" required>
                    @error('nama_paket')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tahun Anggaran <span class="text-danger">*</span></label>
                    <select name="tahun_anggaran_id" class="form-control select2 @error('tahun_anggaran_id') is-invalid @enderror" required>
                        <option value="">Pilih Tahun Anggaran</option>
                        @foreach($tahunAnggarans as $ta)
                            <option value="{{ $ta->id }}" {{ (old('tahun_anggaran_id', $paket->tahun_anggaran_id) == $ta->id) ? 'selected' : '' }}>{{ $ta->tahun }} - {{ $ta->nama }}</option>
                        @endforeach
                    </select>
                    @error('tahun_anggaran_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                    <label class="form-label">Uraian Pekerjaan <span class="text-danger">*</span></label>
                    <textarea name="uraian_pekerjaan" rows="4" class="form-control @error('uraian_pekerjaan') is-invalid @enderror" required>{{ old('uraian_pekerjaan', $paket->uraian_pekerjaan) }}</textarea>
                    @error('uraian_pekerjaan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Program <span class="text-danger">*</span></label>
                    <select name="program_id" id="program_id" class="form-control select2 @error('program_id') is-invalid @enderror" required>
                        <option value="">Pilih Program</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ (old('program_id', $paket->program_id) == $program->id) ? 'selected' : '' }}>{{ $program->kode }} - {{ $program->nama }}</option>
                        @endforeach
                    </select>
                    @error('program_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kegiatan <span class="text-danger">*</span></label>
                    <select name="kegiatan_id" id="kegiatan_id" class="form-control select2 @error('kegiatan_id') is-invalid @enderror" required>
                        <option value="">Pilih Kegiatan</option>
                    </select>
                    @error('kegiatan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Sub Kegiatan <span class="text-danger">*</span></label>
                    <select name="sub_kegiatan_id" id="sub_kegiatan_id" class="form-control select2 @error('sub_kegiatan_id') is-invalid @enderror" required>
                        <option value="">Pilih Sub Kegiatan</option>
                    </select>
                    @error('sub_kegiatan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jenis Pengadaan <span class="text-danger">*</span></label>
                    <select name="jenis_pengadaan_id" class="form-control select2 @error('jenis_pengadaan_id') is-invalid @enderror" required>
                        <option value="">Pilih Jenis Pengadaan</option>
                        @foreach($jenisPengadaans as $jp)
                            <option value="{{ $jp->id }}" {{ (old('jenis_pengadaan_id', $paket->jenis_pengadaan_id) == $jp->id) ? 'selected' : '' }}>{{ $jp->nama }}</option>
                        @endforeach
                    </select>
                    @error('jenis_pengadaan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Metode Pengadaan <span class="text-danger">*</span></label>
                    <select name="metode_pengadaan_id" class="form-control select2 @error('metode_pengadaan_id') is-invalid @enderror" required>
                        <option value="">Pilih Metode Pengadaan</option>
                        @foreach($metodePengadaans as $mp)
                            <option value="{{ $mp->id }}" {{ (old('metode_pengadaan_id', $paket->metode_pengadaan_id) == $mp->id) ? 'selected' : '' }}>{{ $mp->nama }}</option>
                        @endforeach
                    </select>
                    @error('metode_pengadaan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori_id" class="form-control select2 @error('kategori_id') is-invalid @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ (old('kategori_id', $paket->kategori_id) == $kategori->id) ? 'selected' : '' }}>{{ $kategori->nama }}</option>
                        @endforeach
                    </select>
                    @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0"><i class="fas fa-calculator me-2 text-primary"></i>Anggaran</h5>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Pagu Anggaran <span class="text-danger">*</span></label>
                    <input type="text" name="pagu_anggaran" id="pagu_anggaran" class="form-control rupiah-input @error('pagu_anggaran') is-invalid @enderror" value="{{ old('pagu_anggaran', formatRupiah($paket->pagu_anggaran)) }}" required>
                    @error('pagu_anggaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">HPS</label>
                    <input type="text" name="hps" id="hps" class="form-control rupiah-input @error('hps') is-invalid @enderror" value="{{ old('hps', $paket->hps ? formatRupiah($paket->hps) : '') }}">
                    @error('hps')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Sumber Dana <span class="text-danger">*</span></label>
                    <select name="sumber_dana_id" class="form-control select2 @error('sumber_dana_id') is-invalid @enderror" required>
                        <option value="">Pilih Sumber Dana</option>
                        @foreach($sumberDanas as $sd)
                            <option value="{{ $sd->id }}" {{ (old('sumber_dana_id', $paket->sumber_dana_id) == $sd->id) ? 'selected' : '' }}>{{ $sd->nama }}</option>
                        @endforeach
                    </select>
                    @error('sumber_dana_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Satuan <span class="text-danger">*</span></label>
                    <select name="satuan_id" class="form-control select2 @error('satuan_id') is-invalid @enderror" required>
                        <option value="">Pilih Satuan</option>
                        @foreach($satuans as $satuan)
                            <option value="{{ $satuan->id }}" {{ (old('satuan_id', $paket->satuan_id) == $satuan->id) ? 'selected' : '' }}>{{ $satuan->nama }}</option>
                        @endforeach
                    </select>
                    @error('satuan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-3">
                <label class="form-label fw-semibold">Rincian Anggaran</label>
                <div class="table-responsive">
                    <table class="table table-bordered" id="anggaranTable">
                        <thead>
                            <tr>
                                <th style="width:30%">Nama Item</th>
                                <th style="width:15%">Volume</th>
                                <th style="width:15%">Satuan</th>
                                <th style="width:20%">Harga Satuan</th>
                                <th style="width:15%">Total</th>
                                <th style="width:5%"></th>
                            </tr>
                        </thead>
                        <tbody id="anggaranBody">
                            @forelse(old('anggaran_nama_item', $paket->paketAnggarans ?? []) as $index => $item)
                            <tr class="anggaran-row">
                                <td><input type="text" name="anggaran_nama_item[]" class="form-control form-control-sm" value="{{ is_array($item) ? $item['nama_item'] ?? '' : ($item->nama_item ?? '') }}"></td>
                                <td><input type="number" name="anggaran_volume[]" class="form-control form-control-sm volume" value="{{ is_array($item) ? $item['volume'] ?? '' : ($item->volume ?? '') }}" min="0" step="0.01"></td>
                                <td>
                                    <select name="anggaran_satuan_id[]" class="form-control form-control-sm">
                                        <option value="">Pilih</option>
                                        @foreach($satuans as $satuan)
                                            @php $selected = (is_array($item) ? ($item['satuan_id'] ?? '') : ($item->satuan_id ?? '')) == $satuan->id; @endphp
                                            <option value="{{ $satuan->id }}" {{ $selected ? 'selected' : '' }}>{{ $satuan->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name="anggaran_harga_satuan[]" class="form-control form-control-sm harga-satuan rupiah-input" value="{{ is_array($item) ? formatRupiah($item['harga_satuan'] ?? 0) : formatRupiah($item->harga_satuan ?? 0) }}"></td>
                                <td><input type="text" name="anggaran_total[]" class="form-control form-control-sm total-angg" value="{{ is_array($item) ? formatRupiah($item['total'] ?? 0) : formatRupiah($item->total ?? 0) }}" readonly></td>
                                <td><button type="button" class="btn btn-sm btn-danger btn-hapus-anggaran"><i class="fas fa-times"></i></button></td>
                            </tr>
                            @empty
                            <tr class="anggaran-row">
                                <td><input type="text" name="anggaran_nama_item[]" class="form-control form-control-sm" placeholder="Nama Item"></td>
                                <td><input type="number" name="anggaran_volume[]" class="form-control form-control-sm volume" placeholder="0" min="0" step="0.01"></td>
                                <td>
                                    <select name="anggaran_satuan_id[]" class="form-control form-control-sm">
                                        <option value="">Pilih</option>
                                        @foreach($satuans as $satuan)
                                            <option value="{{ $satuan->id }}">{{ $satuan->nama }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><input type="text" name="anggaran_harga_satuan[]" class="form-control form-control-sm harga-satuan rupiah-input" placeholder="0"></td>
                                <td><input type="text" name="anggaran_total[]" class="form-control form-control-sm total-angg" readonly></td>
                                <td><button type="button" class="btn btn-sm btn-danger btn-hapus-anggaran"><i class="fas fa-times"></i></button></td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="tambahAnggaran"><i class="fas fa-plus me-1"></i>Tambah Item</button>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Jadwal</h5>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-bordered" id="jadwalTable">
                    <thead>
                        <tr>
                            <th>Tahapan <span class="text-danger">*</span></th>
                            <th>Tanggal Mulai <span class="text-danger">*</span></th>
                            <th>Tanggal Selesai <span class="text-danger">*</span></th>
                            <th>Keterangan</th>
                            <th style="width:5%"></th>
                        </tr>
                    </thead>
                    <tbody id="jadwalBody">
                        @forelse(old('jadwal_tahapan', $paket->paketJadwals ?? []) as $index => $jadwal)
                        <tr class="jadwal-row">
                            <td>
                                <select name="jadwal_tahapan[]" class="form-control form-control-sm" required>
                                    <option value="">Pilih Tahapan</option>
                                    @foreach(['Perencanaan', 'Persiapan', 'Pemilihan', 'Pelaksanaan', 'Serah Terima'] as $tahap)
                                        @php $selected = (is_string($jadwal) ? $jadwal : (is_array($jadwal) ? ($jadwal['tahapan'] ?? '') : ($jadwal->tahapan ?? ''))) == $tahap; @endphp
                                        <option value="{{ $tahap }}" {{ $selected ? 'selected' : '' }}>{{ $tahap }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="text" name="jadwal_tanggal_mulai[]" class="form-control form-control-sm datepicker" value="{{ is_array($jadwal) ? formatTanggal($jadwal['tanggal_mulai'] ?? '', 'd-m-Y') : formatTanggal($jadwal->tanggal_mulai ?? '', 'd-m-Y') }}"></td>
                            <td><input type="text" name="jadwal_tanggal_selesai[]" class="form-control form-control-sm datepicker" value="{{ is_array($jadwal) ? formatTanggal($jadwal['tanggal_selesai'] ?? '', 'd-m-Y') : formatTanggal($jadwal->tanggal_selesai ?? '', 'd-m-Y') }}"></td>
                            <td><input type="text" name="jadwal_keterangan[]" class="form-control form-control-sm" value="{{ is_array($jadwal) ? ($jadwal['keterangan'] ?? '') : ($jadwal->keterangan ?? '') }}"></td>
                            <td><button type="button" class="btn btn-sm btn-danger btn-hapus-jadwal"><i class="fas fa-times"></i></button></td>
                        </tr>
                        @empty
                        <tr class="jadwal-row">
                            <td>
                                <select name="jadwal_tahapan[]" class="form-control form-control-sm" required>
                                    <option value="">Pilih Tahapan</option>
                                    <option value="Perencanaan">Perencanaan</option>
                                    <option value="Persiapan">Persiapan</option>
                                    <option value="Pemilihan">Pemilihan</option>
                                    <option value="Pelaksanaan">Pelaksanaan</option>
                                    <option value="Serah Terima">Serah Terima</option>
                                </select>
                            </td>
                            <td><input type="text" name="jadwal_tanggal_mulai[]" class="form-control form-control-sm datepicker" required></td>
                            <td><input type="text" name="jadwal_tanggal_selesai[]" class="form-control form-control-sm datepicker" required></td>
                            <td><input type="text" name="jadwal_keterangan[]" class="form-control form-control-sm"></td>
                            <td><button type="button" class="btn btn-sm btn-danger btn-hapus-jadwal"><i class="fas fa-times"></i></button></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="tambahJadwal"><i class="fas fa-plus me-1"></i>Tambah Baris</button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Lokasi</h5>
        </div>
        <div class="card-body px-4 pb-4">
            <div class="table-responsive">
                <table class="table table-bordered" id="lokasiTable">
                    <thead>
                        <tr>
                            <th>Provinsi <span class="text-danger">*</span></th>
                            <th>Kabupaten/Kota <span class="text-danger">*</span></th>
                            <th>Kecamatan</th>
                            <th>Kelurahan/Desa</th>
                            <th>Detail Alamat</th>
                            <th style="width:5%"></th>
                        </tr>
                    </thead>
                    <tbody id="lokasiBody">
                        @forelse(old('lokasi_provinsi', $paket->paketLokasis ?? []) as $index => $lokasi)
                        <tr class="lokasi-row">
                            <td><input type="text" name="lokasi_provinsi[]" class="form-control form-control-sm" value="{{ is_array($lokasi) ? ($lokasi['provinsi'] ?? '') : ($lokasi->provinsi ?? '') }}"></td>
                            <td><input type="text" name="lokasi_kabupaten_kota[]" class="form-control form-control-sm" value="{{ is_array($lokasi) ? ($lokasi['kabupaten_kota'] ?? '') : ($lokasi->kabupaten_kota ?? '') }}"></td>
                            <td><input type="text" name="lokasi_kecamatan[]" class="form-control form-control-sm" value="{{ is_array($lokasi) ? ($lokasi['kecamatan'] ?? '') : ($lokasi->kecamatan ?? '') }}"></td>
                            <td><input type="text" name="lokasi_kelurahan_desa[]" class="form-control form-control-sm" value="{{ is_array($lokasi) ? ($lokasi['kelurahan_desa'] ?? '') : ($lokasi->kelurahan_desa ?? '') }}"></td>
                            <td><input type="text" name="lokasi_detail_alamat[]" class="form-control form-control-sm" value="{{ is_array($lokasi) ? ($lokasi['detail_alamat'] ?? '') : ($lokasi->detail_alamat ?? '') }}"></td>
                            <td><button type="button" class="btn btn-sm btn-danger btn-hapus-lokasi"><i class="fas fa-times"></i></button></td>
                        </tr>
                        @empty
                        <tr class="lokasi-row">
                            <td><input type="text" name="lokasi_provinsi[]" class="form-control form-control-sm" required></td>
                            <td><input type="text" name="lokasi_kabupaten_kota[]" class="form-control form-control-sm" required></td>
                            <td><input type="text" name="lokasi_kecamatan[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="lokasi_kelurahan_desa[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="lokasi_detail_alamat[]" class="form-control form-control-sm"></td>
                            <td><button type="button" class="btn btn-sm btn-danger btn-hapus-lokasi"><i class="fas fa-times"></i></button></td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="tambahLokasi"><i class="fas fa-plus me-1"></i>Tambah Lokasi</button>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h5 class="fw-bold mb-0"><i class="fas fa-upload me-2 text-primary"></i>Upload Dokumen</h5>
        </div>
        <div class="card-body px-4 pb-4">
            @if($paket->dokumens->count() > 0)
            <div class="table-responsive mb-3">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Dokumen</th>
                            <th>Tipe</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paket->dokumens as $dokumen)
                        <tr>
                            <td>{{ $dokumen->nama_dokumen }}</td>
                            <td>{{ $dokumen->tipe_dokumen ?? '-' }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $dokumen->file_path) }}" class="btn btn-sm btn-primary" target="_blank"><i class="fas fa-download"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <div class="mb-3">
                <label class="form-label">Nama Dokumen</label>
                <input type="text" name="dokumen_nama" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Tipe Dokumen</label>
                <select name="dokumen_tipe" class="form-control">
                    <option value="">Pilih Tipe</option>
                    <option value="KAK">KAK</option>
                    <option value="RAB">RAB</option>
                    <option value="Spesifikasi Teknis">Spesifikasi Teknis</option>
                    <option value="Dokumen Pendukung">Dokumen Pendukung</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">File</label>
                <input type="file" name="dokumen_file" class="form-control">
            </div>
            <div class="form-check">
                <input type="checkbox" name="dokumen_is_public" class="form-check-input" id="dokumenIsPublic" value="1">
                <label class="form-check-label" for="dokumenIsPublic">Tampilkan di halaman publik</label>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-secondary btn-simpan-draft">
            <i class="fas fa-save me-1"></i>Simpan Draft
        </button>
        @if($paket->status === 'draft')
        <button type="button" class="btn btn-primary btn-ajukan">
            <i class="fas fa-paper-plane me-1"></i>Ajukan Verifikasi
        </button>
        @endif
        <a href="{{ route('operator.paket.show', $paket->id) }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({ theme: 'bootstrap-5', width: '100%' });

        $('.datepicker').flatpickr({ locale: 'id', dateFormat: 'd/m/Y' });

        function formatRupiahInput(angka) {
            var number = angka.replace(/[^\d]/g, '');
            if (number == '') return '';
            return number.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        $('.rupiah-input').on('input', function() {
            var val = $(this).val();
            var number = parseInt(val.replace(/[^\d]/g, '')) || 0;
            $(this).val(formatRupiahInput(val));
            if ($(this).hasClass('harga-satuan')) {
                $(this).closest('tr').find('.total-angg').val(formatRupiahInput((number * (parseFloat($(this).closest('tr').find('.volume').val()) || 0)).toString()));
            }
        });

        $('.volume').on('input', function() {
            var vol = parseFloat($(this).val()) || 0;
            var harga = parseInt($(this).closest('tr').find('.harga-satuan').val().replace(/[^\d]/g, '')) || 0;
            $(this).closest('tr').find('.total-angg').val(formatRupiahInput((vol * harga).toString()));
        });

        $('#tambahAnggaran').on('click', function() {
            var row = $('#anggaranBody .anggaran-row').first().clone();
            row.find('input').val('');
            row.find('select').val('');
            row.find('.total-angg').val('');
            $('#anggaranBody').append(row);
        });

        $('#anggaranBody').on('click', '.btn-hapus-anggaran', function() {
            if ($('#anggaranBody .anggaran-row').length > 1) {
                $(this).closest('tr').remove();
            }
        });

        $('#tambahJadwal').on('click', function() {
            var row = $('#jadwalBody .jadwal-row').first().clone();
            row.find('input').val('');
            row.find('select').val('');
            $('#jadwalBody').append(row);
            $('.datepicker').flatpickr({ locale: 'id', dateFormat: 'd/m/Y' });
        });

        $('#jadwalBody').on('click', '.btn-hapus-jadwal', function() {
            if ($('#jadwalBody .jadwal-row').length > 1) {
                $(this).closest('tr').remove();
            }
        });

        $('#tambahLokasi').on('click', function() {
            var row = $('#lokasiBody .lokasi-row').first().clone();
            row.find('input').val('');
            $('#lokasiBody').append(row);
        });

        $('#lokasiBody').on('click', '.btn-hapus-lokasi', function() {
            if ($('#lokasiBody .lokasi-row').length > 1) {
                $(this).closest('tr').remove();
            }
        });

        $('.btn-ajukan').on('click', function() {
            Swal.fire({
                title: 'Ajukan Verifikasi',
                text: 'Paket akan diajukan untuk diverifikasi. Apakah anda yakin?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                confirmButtonText: 'Ya, ajukan!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    $('#formAction').val('ajukan');
                    $('form').submit();
                }
            });
        });

        $('.btn-simpan-draft').on('click', function() {
            $('#formAction').val('draft');
        });

        $('#program_id').on('change', function() {
            var programId = $(this).val();
            $('#kegiatan_id').val('').trigger('change');
            $('#sub_kegiatan_id').val('').trigger('change');
            if (programId) {
                $.get('/api/program/' + programId + '/kegiatan', function(data) {
                    $('#kegiatan_id').empty().append('<option value="">Pilih Kegiatan</option>');
                    $.each(data, function(i, item) {
                        $('#kegiatan_id').append('<option value="' + item.id + '">' + item.kode + ' - ' + item.nama + '</option>');
                    });
                });
            }
        });

        $('#kegiatan_id').on('change', function() {
            var kegiatanId = $(this).val();
            $('#sub_kegiatan_id').val('').trigger('change');
            if (kegiatanId) {
                $.get('/api/kegiatan/' + kegiatanId + '/sub-kegiatan', function(data) {
                    $('#sub_kegiatan_id').empty().append('<option value="">Pilih Sub Kegiatan</option>');
                    $.each(data, function(i, item) {
                        $('#sub_kegiatan_id').append('<option value="' + item.id + '">' + item.kode + ' - ' + item.nama + '</option>');
                    });
                });
            }
        });

        var programId = '{{ old('program_id', $paket->program_id) }}';
        var kegiatanId = '{{ old('kegiatan_id', $paket->kegiatan_id) }}';
        var subKegiatanId = '{{ old('sub_kegiatan_id', $paket->sub_kegiatan_id) }}';

        if (programId) {
            $('#program_id').val(programId).trigger('change');
            if (kegiatanId) {
                setTimeout(function() {
                    $('#kegiatan_id').val(kegiatanId).trigger('change');
                    if (subKegiatanId) {
                        setTimeout(function() {
                            $('#sub_kegiatan_id').val(subKegiatanId);
                        }, 500);
                    }
                }, 500);
            }
        }
    });
</script>
@endpush
