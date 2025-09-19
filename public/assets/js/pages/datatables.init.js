$(document).ready(function () {
    // DataTable simples
    $("#datatable").DataTable();

    // DataTable com botões
    var table = $("#datatable-buttons").DataTable({
        lengthChange: false,
        buttons: ["copy", "excel", "pdf", "colvis"]
    });

    // Colocar os botões na toolbar
    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

    // Estilo para o seletor de quantidade
    $(".dataTables_length select").addClass("form-select form-select-sm");
});
