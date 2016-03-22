<?php
$app->get('/Auth', function() use ($app) {
	
	$db = new DbHandler();
	$sess=$db->getSession();
	$author=$sess['uid'];
	function dbase($v){
		return base64_decode($v); 
	}
	/* $crypt = new Cryptography(); */
	
	//$savedfile=STORAGE_DIR.'/'.$author.$_POST['under'].'/'.$fileName;
	
	$response = array();
	$tabble_name = "customers_auth";
    //$r = json_decode($app->request->getBody());
	//verifyRequiredParams(array('path'),$r->downloader);
	
	//$filepath=$r->downloader->path;
	if(isset($_GET["qid"])){
		$filepath=dbase($_GET["qid"]);
	}else{
		$filepath=$db->dbase($_GET["q"]);
	}
	//$file=$r->folder->file;
	$s=explode("/",$filepath);
	$fnm=$s[count($s)-1];
	
	$hips=explode("`",$fnm);
    try{
		$filename=$hips[2].'.'.$hips[3];
		$download_file=STORAGE_DIR.'/'.$author.$filepath;
		if(isset($_GET["qid"])){
			$download_file=dbase($_GET["qid"]);
		}
		//if(file_exists(STORAGE_DIR.'/'.$author.$filepath)){
		if(file_exists($download_file)){
			//mkdir(STORAGE_DIR.'/'.$author.$filepath);
		$extension = $hips[3]; 
		
		// For Gecko browsers
		header('Content-Transfer-Encoding: binary');  
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($download_file)) . ' GMT'); 
		// Supports for download resume
		header('Accept-Ranges: bytes');  
		// Calculate File size
		header('Content-Length: ' . filesize($download_file));  
		header('Content-Encoding: none');
		// Change the mime type if the file is not PDF
		header('Content-Type: application/'.$extension);  
		// Make the browser display the Save As dialog
		header('Content-Disposition: attachment; filename=' . $filename);  
		readfile($download_file); 
	
		exit;
	  
			/* $decrypted_string = decrypt_mp3($contents);
			header('Content-length: ' . strlen($decrypted_string));
			echo $decrypted_string;

			$response["status"] = "success";
			$response["message"] = "File Downloaded successfully";
			
			echoResponse(200, $response); */
		}else{
			 $response["status"] = "error";
			$response["message"] = "File Does not exists @ ".$download_file;
			echoResponse(201, $response);
		}        
    } catch (Exception $e) {
        $response["status"] = "error";
        $response["message"] = $e;
        echoResponse(201, $response);
    }
});