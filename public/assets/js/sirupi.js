/**
 * SIRUPI - Custom JavaScript
 */

// --- Helper Functions ---

function formatRupiah(angka) {
    if (!angka || isNaN(angka)) return 'Rp 0';
    return 'Rp ' + Math.round(angka).toLocaleString('id-ID');
}

function showLoading(text) {
    text = text || 'Memproses...';
    let overlay = document.getElementById('loadingOverlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'loadingOverlay';
        overlay.className = 'loading-overlay';
        overlay.innerHTML = '<div class="loading-spinner"></div><div class="loading-text" id="loadingText"></div>';
        document.body.appendChild(overlay);
    }
    document.getElementById('loadingText').textContent = text;
    overlay.classList.add('active');
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) overlay.classList.remove('active');
}

function showToast(icon, title, message) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: icon || 'success',
            title: title || 'Berhasil',
            text: message || '',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
        });
    }
}

function showSuccessToast(message) {
    showToast('success', 'Berhasil', message);
}

function showErrorToast(message) {
    showToast('error', 'Gagal', message);
}

function showWarningToast(message) {
    showToast('warning', 'Perhatian', message);
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    
    // --- Sidebar Toggle ---
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const wrapper = document.getElementById('wrapper');

    if (sidebarToggle && sidebar && wrapper) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            wrapper.classList.toggle('sidebar-collapsed');
            localStorage.setItem('sidebarCollapsed', sidebar.classList.contains('collapsed'));
        });

        if (localStorage.getItem('sidebarCollapsed') === 'true') {
            sidebar.classList.add('collapsed');
            wrapper.classList.add('sidebar-collapsed');
        }
    }
    
    // --- Auto-hide Flash Messages ---
    document.querySelectorAll('.alert-dismissible').forEach(function(msg) {
        setTimeout(function() {
            msg.style.transition = 'opacity 0.5s';
            msg.style.opacity = '0';
            setTimeout(function() { msg.remove(); }, 500);
        }, 5000);
    });
    
    // --- Confirm Delete with SweetAlert2 ---
    document.querySelectorAll('.btn-delete-confirm').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const name = this.dataset.name || 'item ini';
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus ' + name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e02424',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed && form) form.submit();
            });
        });
    });
    
    // --- Confirm Submit with SweetAlert2 ---
    document.querySelectorAll('.btn-submit-confirm').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            const text = this.dataset.text || 'Apakah Anda yakin?';
            Swal.fire({
                title: 'Konfirmasi',
                text: text,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1a56db',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Lanjutkan!',
                cancelButtonText: 'Batal'
            }).then(function(result) {
                if (result.isConfirmed && form) form.submit();
            });
        });
    });

    // --- data-confirm links ---
    document.querySelectorAll('[data-confirm]').forEach(function(el) {
        el.addEventListener('click', function(e) {
            if (this.tagName === 'A' || this.dataset.href) {
                e.preventDefault();
                const message = this.dataset.confirm || 'Apakah anda yakin?';
                const href = this.getAttribute('href') || this.dataset.href;
                Swal.fire({
                    title: 'Konfirmasi',
                    text: message,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Ya, lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then(function(result) {
                    if (result.isConfirmed && href) window.location.href = href;
                });
            }
        });
    });
    
    // --- Select2 Initialization ---
    if (typeof jQuery !== 'undefined' && jQuery.fn.select2) {
        jQuery('.select2').each(function() {
            if (!jQuery(this).data('select2')) {
                jQuery(this).select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    placeholder: jQuery(this).data('placeholder') || 'Pilih...',
                    allowClear: true,
                    language: {
                        noResults: function() { return 'Tidak ada hasil ditemukan'; },
                        searching: function() { return 'Mencari...'; }
                    }
                });
            }
        });
    }
    
    // --- Flatpickr Initialization ---
    if (typeof flatpickr !== 'undefined') {
        flatpickr('.datepicker', {
            locale: 'id',
            dateFormat: 'd/m/Y',
            altFormat: 'd/m/Y',
            altInput: true
        });
    }
    
    // --- Dynamic Select Cascading (Program -> Kegiatan -> SubKegiatan) ---
    const programSelect = document.getElementById('program_id');
    const kegiatanSelect = document.getElementById('kegiatan_id');
    const subKegiatanSelect = document.getElementById('sub_kegiatan_id');
    
    if (programSelect && kegiatanSelect) {
        programSelect.addEventListener('change', function() {
            const programId = this.value;
            kegiatanSelect.innerHTML = '<option value="">Pilih Kegiatan</option>';
            if (subKegiatanSelect) {
                subKegiatanSelect.innerHTML = '<option value="">Pilih Sub Kegiatan</option>';
            }
            if (programId) {
                fetch('/api/kegiatan/' + programId)
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        data.forEach(function(item) {
                            var opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.kode + ' - ' + item.nama;
                            kegiatanSelect.appendChild(opt);
                        });
                    });
            }
        });
    }
    
    if (kegiatanSelect && subKegiatanSelect) {
        kegiatanSelect.addEventListener('change', function() {
            const kegiatanId = this.value;
            subKegiatanSelect.innerHTML = '<option value="">Pilih Sub Kegiatan</option>';
            if (kegiatanId) {
                fetch('/api/sub-kegiatan/' + kegiatanId)
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        data.forEach(function(item) {
                            var opt = document.createElement('option');
                            opt.value = item.id;
                            opt.textContent = item.kode + ' - ' + item.nama;
                            subKegiatanSelect.appendChild(opt);
                        });
                    });
            }
        });
    }
    
    // --- Auto-calculate pagu berdasarkan item anggaran ---
    const anggaranTable = document.getElementById('anggaran-table');
    if (anggaranTable) {
        anggaranTable.addEventListener('input', function(e) {
            if (e.target.classList.contains('hitung-total')) {
                const row = e.target.closest('tr');
                const volume = parseFloat(row.querySelector('.volume').value) || 0;
                const harga = parseFloat(row.querySelector('.harga-satuan').value) || 0;
                const totalField = row.querySelector('.total');
                const total = volume * harga;
                totalField.value = total;
                
                let grandTotal = 0;
                anggaranTable.querySelectorAll('.total').forEach(function(tf) {
                    grandTotal += parseFloat(tf.value) || 0;
                });
                const paguField = document.getElementById('pagu_anggaran');
                if (paguField) paguField.value = grandTotal;
            }
        });
    }
    
});
