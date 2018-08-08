$(document).ready(function(){
  $('#tabla').DataTable( {
    "order": [[ 2, "asc" ]],
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excel',
        text: 'Exportar a Excel',
        exportOptions: {
          modifier: {
            page: 'current'
          }
        },
        exportOptions: {
          columns: [ 1,2,3,7,9,10 ]
        }
      }

    ],

    columnDefs: [
      {targets:[0,8,14], orderable: false  },
      { type: 'date-euro', targets: 10  },
      {
        "targets": 10,
        "visible": false,
        "searchable": false
      },

    ],
    "scrollX":"1000px",
    "scrollCollapse": true,
    "pageLength": 20,
    initComplete: function () {
      this.api().columns(8).every( function () {
        var column = this;
        var select = $('<select style="width:100px;"><option disabled selected value="" style="color: #999;opacity:1;">Marcas</option></select>')
        .appendTo( $(column.header()).empty() )
        .on( 'change', function () {
          var val = $.fn.dataTable.util.escapeRegex(
            $(this).val()
          );

          column
          .search( val ? '^'+val+'$' : '', true, false )
          .draw();
        } );

        column.data().unique().sort().each( function ( d, j ) {
          select.append( '<option value="'+d+'">'+d+'</option>' )
        } );
      } );
    }
  });
});
