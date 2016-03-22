<?php
//echo $_GET["path"];
//echo ebase("download.jpg");
ini_set('display_errors', 'On');
showImage(dbase($_GET["path"]));
function showImage($name){
	 $types = array('gif'=> 'image/gif','png'=> 'image/png','jpeg'=> 'image/jpeg','jpg'=> 'image/jpeg');
	 $root_path  = __dir__; //use your framework to get this properly ..
	 $root_path.='/';
	 foreach($types as $type=>$meta){
		 
		 if(file_exists($root_path .$name  .'.'. $type)){
			header('Content-type: ' . $meta);
			readfile($root_path .$name .'.'. $type);
			return '';
				
		 }
	 }
}
function ebase($v){
	return base64_encode($v);
}
function dbase($v){
	return base64_decode($v); 
}