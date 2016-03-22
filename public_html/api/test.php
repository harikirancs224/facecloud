<?php 
define( 'ABSPATH', dirname(__FILE__) . '/' );
define( 'STORAGE_DIR', ABSPATH . 'storage' );

$author="192";
//$listener=array("s");
//$av=listFolderFiles(STORAGE_DIR.'/'.$author,"",array());
//print_r($listener);
	//exit();
download(STORAGE_DIR.'/'.$author.'/test.docx');
function download($filename){
  if(!empty($filename)){
    // Specify file path.
    $path = ''; // '/uplods/'
    $download_file =  $path.$filename;
    // Check file is exists on given path.
    if(file_exists($download_file))
    {
      // Getting file extension.
      $extension = explode('.',$filename);
      $extension = $extension[count($extension)-1]; 
      // For Gecko browsers
      header('Content-Transfer-Encoding: binary');  
      header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($path)) . ' GMT');
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
    }
    else
    {
      echo 'File does not exists on given path';
    }
 
 }
}

function listFolderFiles12($dir,$root="",$listener,$level=0,$router=array())
{
	echo '<ol>';
	//echo $level;
	$actual_level=$level;$ip=0;
	$spinfo=new DirectoryIterator($dir);
	foreach ($spinfo as $fileInfo) {
		if (!$fileInfo->isDot()) {
			echo '<li>' . $fileInfo->getFilename();
			$d=$fileInfo->getFilename();
			
			if(empty($root)){
				$router=array();
				$listener[$d]=array("folder"=>$d.$level,"date"=>date("Y-m-d"),"link"=>"/".$d);
			}
			else{
				$listener=root_filter($listener,$router,$d,$level);
			}	/*$listener[$root]["sublist"][]=array("folder"=>$d.$level,"date"=>date("Y-m-d"),"link"=>$listener[$root]["link"].'/'.$d); */
			
			if ($fileInfo->isDir()) {
				$actual_level+=1;$router[]=$d;
				$listener=listFolderFiles($fileInfo->getPathname(),$d,$listener,$actual_level,$router);
				//array_pop($router);
			}else{
				
			}
			echo '</li>';
		}
		
		$actual_level=0;
	}
	//echo '</ol>';
	return $listener;
}
function listFolderFiles($dir,$root="")
{
	GLOBAL $listener;
	echo '<ol>';
	foreach (new DirectoryIterator($dir) as $fileInfo) {
		if (!$fileInfo->isDot()) {
			if(empty($root)){
				$router=array();
				//$listener[]=$d;
			}else{
				//$listener=root_filter($listener,$router,$d,$level);
			}
			echo '<li>' . $fileInfo->getFilename();
			
			$d=$fileInfo->getFilename();
			
			
			if ($fileInfo->isDir()) {
				
				$listener[$fileInfo->getFilename()]=array();
				listFolderFiles($fileInfo->getPathname(),$fileInfo->getFilename());
			}
			echo '</li>';
		}
	}
	echo '</ol>';
	
}
function root_filter($listener,$router,$d,$level){
	
	$original=$listener;$i=0;
	$link=$s='$listener';
	$items=$router;//explode(",",substr($router,0,-1));
	$sq="";
	foreach($items as $item){
		$s.='["'.$item.'"]["sublist"]';
		if((count($items))==$i)
			$sq='["'.$item.'"]["sublist"]';
		
		if($i==count($item)){
			//$listener[$item]["sublist"][]=array("folder"=>$d,"date"=>date("Y-m-d"),"link"=>$listener[$item]["link"].'/'.$d);
		}else{
			//$listener=$listener[$item]["sublist"];
			
		}
		$i++;
	}
	$link.=$sq;
	$s.='[]';
	$sb=substr($link,0,-11);
	
	try{
		//if(count($items)>=2){ echo $sb; echo '______________________________________';}
		echo $s.'<br/>';
		//eval($s.'=array("folder"=>$d.$level,"date"=>date("Y-m-d"),"link"=>'.$sb.'["link"]."/".$d);');
	}catch(Exception $sc){
		//echo $sb.'sssssssss;------';
	}
	
	return $listener;
}

function dirToArray($dir) {
    $contents = array();
    foreach (scandir($dir) as $node) {
        if ($node == '.' || $node == '..') continue;
        if (is_dir($dir . '/' . $node)) {
            $contents[$node] = array("data"=>dirToArray($dir . '/' . $node),"date"=>date("Y-m-d"));
            //$contents[$node] = dirToArray($dir . '/' . $node);
        } else {
            $contents[] = $node;
        }
    }
    return $contents;
}

/* $r = dirToArray(STORAGE_DIR.'/'.$author);
print_r($r); */