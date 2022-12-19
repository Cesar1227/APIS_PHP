<?php

$objControl = new Controlador();

if(!empty($_POST)){
	if(isset($_POST["keyWord"]) && isset($_POST["category"])){
		$objControl->actualizarImgs($objControl->peticion($_POST["keyWord"],$_POST["category"]));
	}
}

class Controlador{

	const URL= 'https://pixabay.com/api/';
	const LANG='es';
	const PER_PAGE=30;
	private $lang = self::LANG;
	private $url_i=self::URL;
	public $lastResponse;

	function __construct()
	{
		
	}

	function peticion($keyWord,$category){
		if($category==""){
			$param=["key"=> '13119377-fc7e10c6305a7de49da6ecb25',"lang" => $this->lang, "per_page" => self::PER_PAGE ,"q"=>$keyWord];
		}else{
			$param=["key"=> '13119377-fc7e10c6305a7de49da6ecb25',"lang" => $this->lang , "per_page" => self::PER_PAGE, "q"=>$keyWord,"category" => $category];
		}

		$query = http_build_query($param);
		$request = "{$this->url_i}?{$query}";

		$curl = curl_init();

		curl_setopt_array($curl, array(CURLOPT_URL => $request, CURLOPT_RETURNTRANSFER => 1));

		$response = curl_exec($curl);

		$res = json_decode($response);
		return $res;	
	}


	function actualizarImgs($res){
		$cadena="";
		foreach ($res->hits as $key => $value) { 
			$cadena=$cadena.'<img src='.$value->previewURL.' id="imgs_result" class="img-thumbnail img-resp-api" alt='.'"'.$value->tags.'"'.' pos='.$key.' views='.$value->views.' likes='.$value->likes.' onClick="preview(this)" >';
		}
		echo $cadena;
	}

}
?>



  
