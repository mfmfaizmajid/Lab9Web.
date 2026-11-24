// Konfirmasi penghapusan data
document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('.form-delete');
    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data pengguna ini?')) {
                e.preventDefault();
            }
        });
    });
});
