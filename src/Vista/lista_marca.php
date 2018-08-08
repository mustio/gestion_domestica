<?php
	namespace App\Vista;
	require 'base.php';

	$vars['CSS_FILES'][]	= ['CSS_FILE' => '/cdn/datatables/1.10.12/datatables.min.css'];
	$vars['JS_FILES'][]		= ['JS_FILE' => "/cdn/datatables/1.10.12/datatables.min.js"];	
	$vars['JS_FILES'][]		= ['JS_FILE' => "/cdn/datatables/defaults.js"];
	$vars['JS_FOOTER'][]['JS_SCRIPT'] = HTTP_PATH.'/js/lista.js';
	$vars['JS_FOOTER'][]['JS_SCRIPT'] = HTTP_PATH.'/js/table.js';
	$vars['CSS_FILES'][]	= ['CSS_FILE' =>  HTTP_PATH.'/css/style.css'];	
	$vars['COMPONENTS']['CONTENT'] = (new Vista(VISTAS_PATH.'template/tabla.html',['OPTIONS'=>['CLEAN'=>false]]))->show();


	$vars['SUBTITULO'] = 'Listado de Marcas';
	$vars['TITLE']			= 'Sistema Rossy';
	$vars['TITULO']			= 'Sistema Rossy';
	$vars['BOTONERA'][] = ['HTTP'=> HTTP_PATH.'/index.php','ACCION' => 'alta','CONTROL' => 'marca']; 
	$vars['TITULOS'] = [
						['TITULO'=>'nombre'],
						['TITULO'=>'Foto'],
						['TITULO'=>'Acción']
					];
		foreach ($data as $value) {
			$vars['ROW'][] = ['COL' => [
				['CONT'=>$value['nombre']],
				['CONT'=>'<img src="'.HTTP_PATH.'/fotos/marcas/'.$value["foto"].'" width="100" alt="" />'],
				['CONT' => '<span class="acciones">
				<a href="'.HTTP_PATH.'/index.php/marca/modificar/'.$value['id'].'" data-toggle="tooltip" data-placement="top" data-id="'.$value['id'].'" title="Ver/Modificar" class="dis" data-toggle="modal"><i class="fa fa-eye"></i><i class="fa fa-pencil"></i></a>
				<a href="'.HTTP_PATH.'/index.php/marca/baja/'.$value['id'].'" data-toggle="tooltip" data-placement="top" title="Eliminar" target="_self"><i class="fa fa-trash"></i></a>
				</span>']
			]
		];
	}


	$html = (new Vista(VISTAS_PATH.'template/base.html',$vars))->show();

	return $html;
?>