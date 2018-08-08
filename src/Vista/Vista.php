<?php
namespace App\Vista;

class Vista
{

	
 /*
	Ej. Estructura de vars	
	[
		'options'	=> ['clean' => true/false ],
		'name_tag'  => 'value',....,

		'name_tag_n'=> 'value_n',
		'name_block'=>[
					   ['name_tag'=>'value'],....,
					   ['name_tag_n'=>'value_n']
					  ]
	];
*/
	protected $html;		
	protected $replace;
	protected $vars;
	protected $clean;
	

	public function __construct($base_path,$vars ='')
	{
	  ob_start();
		require $base_path;
		$this->html = ob_get_clean();
	    $this->vars = $vars;
			//$this->vars['ERROR'] = $this->format_error($this->vars['ERROR']); 
	    if(is_array($vars))
	    { 
	    	$this->clean = (isset($vars['OPTIONS']['CLEAN'])) ? $vars['OPTIONS']['CLEAN'] : true;
	    	if(isset($this->vars['COMPONENTS']))
	    	{
	    		$this->replace_component($this->vars['COMPONENTS']);
	    		unset($this->vars['COMPONENTS']);
	    	}

		    foreach ($this->vars as $tag => $value)
		    {
		    	$tag = strtoupper($tag);
		    	if(is_array($value))
		    	{
		    		$this->serialize_sub_block($tag,$value,$this->html);
		    	}
		    	else
		    	{
		    		$this->set_tag($tag,$value);
		    	}	
		    }
		    $this->render();
		}
	}


	public function set_tag($tag,$value)
	{
		$this->replace['tags'][] = '{{{'.strtoupper($tag).'}}}';
		$this->replace['values'][] = $value;
	}


	protected function render()
	{
		$this->html = str_replace($this->replace['tags'], $this->replace['values'], $this->html);
		if($this->clean)
		{
			$this->html = preg_replace('/\{\{\{[A-Z_]*\}\}\}/', '', $this->html);
			preg_match_all( '/<!--[A-Z_]*-->/', $this->html,$tags);
			foreach ($tags[0] as $tag) {
				$tag = str_replace(['<','>','-','!'], '', $tag);
				$this->html = preg_replace('/<!--'.$tag.'-->[\w\W]*<!--\/'.$tag.'-->/','', $this->html);
			}

		}
	}


	protected function is_block($tag,$block)
	{
		$tag = strtoupper($tag);
		$rta = false;
		return preg_match('/<!--'.$tag.'-->/',$block);
	}


	protected function serialize_sub_block($tag, $rows, &$block)
	{
		$tag = strtoupper($tag);
		if($this->is_block($tag, $block))
		{
			if(preg_match('/<!--'.$tag.'-->[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ<>\s\/\"\'=\-_\{\}\|\*\#\!\[\]\.:;\+]*<!--\/'.$tag.'-->/',$block,$arr))
			{  
				$block = preg_replace('/<!--'.$tag.'-->[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ<>\s\/\"\'=\-_\{\}\|\*\#\!\[\]\.:;\+]*<!--\/'.$tag.'-->/','{{{SERIALICE_'.$tag.'}}}', $block);				
				$sub_block = preg_replace(['/<!--'.$tag.'-->/','/<!--\/'.$tag.'-->/'],'',$arr[0]);
				$code = '';
				foreach ($rows as $row)
				{
					$aux = $sub_block;

			    	foreach ($row as $ss_tag => $value)
			    	{
						if(is_array($value))
						{
							$this->serialize_sub_block($ss_tag, $value, $aux);
						}
						else
						{
			  				$aux = preg_replace('/\{\{\{'.$ss_tag.'\}\}\}/', $value, $aux);						
						}
					}
					$code .= $aux;	
				}
					
				$block = preg_replace('/\{\{\{SERIALICE_'.$tag.'\}\}\}/', $code,$block);
			}		
		}
		else
		{
		  foreach ($rows as $sub_tag => $value)
		  {
		  	 $sub_tag = strtoupper($sub_tag);
		  	 if (is_array($value))
		  	 {
				$this->serialize_sub_block($sub_tag, $value, $block);	  	 	
		  	 }else
		  	 {
		  		$block = preg_replace('/\{\{\{'.$tag.'\}\}\}/', $value, $block); 	
		  	 }
		  }	
		}	
	}


	protected function replace_component($rows) {
		foreach ($rows as $tag => $value) {
			$tag = strtoupper($tag);
			$this->html = preg_replace('/\{\{\{'.$tag.'\}\}\}/',$value,$this->html);
		}
	}
	
	public static function msj_error($msj,&$vars=false) {   
		$html = VISTA::format_msj('error',$msj);
		if (!is_array($vars)) {
			$_SESSION['msj'] = $html;
		}else{
			$vars['ERROR'] = $html;
		}
	}
	
	public static function msj_aviso($msj,&$vars=false) {
		$html = VISTA::format_msj('aviso',$msj);
		if (!is_array($vars)) {
			$_SESSION['msj'] = $html;
		}else{
			$vars['ERROR'] = $html;
		}
	}
	
	protected static function format_msj($tipo,$msj) {
		$html = $msj;
		if ($msj) {	 
			if (is_array($msj) || !(preg_match('/<div class/', $msj))) {
				$string = '';
				$html = '';
				if (is_array($msj)) {
					$string  = '<div>
								<strong> Aviso: </strong><br>
								<ul>';
								foreach ($msj as $error) {
									$string .= '<li>'.$error.'</li>';
								}
					$string  .=		'</ul>
							</div>';
				}
				else {
					$string = strval($msj);
				}
				$html = file_get_contents(VISTAS_PATH.'widgets/'.$tipo.'.php');
				$html = str_replace('{{{MSJ}}}', $string, $html);
			}
		}
		return $html;
	}
	
	public static function load_object($objeto, &$vars) {

		if (is_object($objeto)) {
			$objeto = ((array)$objeto);
		}
		
		if(is_array($objeto)) {		
			foreach ($objeto as $campo => $valor) {
				$vars[strtoupper($campo)] = $valor;
			}
		}
	}
	
	public static function select_format($content,$selected = '') {
		foreach ($content as $key => $value){      
			$marca = ($selected == $key) ? 'selected' : '';
			$comb[] = ['TEXT' => $value, 'VALUE' => $key,'SELECTED' =>$marca];
		}
		return $comb;			
	}

	public function show()
	{
		return $this->html;
		exit;
	}
}  