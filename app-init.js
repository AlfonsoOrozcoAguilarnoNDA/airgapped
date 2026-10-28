// app-init.js — inicialización global. Se carga al final por footvendor().
// Como la CSP bloquea scripts inline, cualquier init va en archivos .js externos.

$(function () {
    // Cualquier <table class="datatable"> se convierte en DataTable en español.
    $('table.datatable').each(function () {
        $(this).DataTable({
            language: { url: '/assets/vendor/datatables/i18n/es.json' },
            pageLength: 25,
            responsive: $.fn.dataTable.Responsive ? true : false
        });
    });

    // Tooltips (solo con texto plano; no pasar HTML de usuario)
    $('[data-toggle="tooltip"]').tooltip();
});
