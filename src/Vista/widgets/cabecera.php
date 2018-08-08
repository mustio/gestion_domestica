<?php
$links = [

    HTTP_PATH.'/gasto/lista'=>'Listado',
    HTTP_PATH.'/gasto/alta'=>'Alta',
];

$config = FMT\Configuracion::instancia();
$conf['links'] = $links;
$conf['activo'] = HTTP_PATH.'/index.php';

$cabecera = FMT\VistasGenericas::cabecera($conf);
echo $cabecera;
