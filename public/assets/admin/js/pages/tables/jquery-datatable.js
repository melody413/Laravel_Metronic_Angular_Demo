$(function () {
    $('.js-basic-example').DataTable({
        responsive: true
    });

    //DataTable Ajax
    var columns = [];
    var dataTableAjaxUrl = $('.dataTableAjax').attr('data-url');
    $('.dataTableAjax thead th').each(function(e,v){
        columnOpt = {
            name: $(this).attr('name') ,
            orderable: $(this).attr('orderable') == true,
        };
        columns.push(columnOpt);
    });

    var dataTableSearching =  $('.dataTableAjax').attr('searching') == "true";
    console.log('-->',dataTableSearching);

    $('.dataTableAjax').dataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "ajax": dataTableAjaxUrl,
        "columns": columns,
        "order": [[0, 'desc']],
        "searching": dataTableSearching
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
});