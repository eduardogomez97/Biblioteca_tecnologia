import './styles/app.scss';
import 'datatables.net';
import 'datatables.net-bs4';


$('#bibliotecas').dataTable( {
    "language": {
        "url": "https://cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
    },
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
} );


   