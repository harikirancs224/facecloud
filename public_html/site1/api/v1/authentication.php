<?php 
$app->get('/session', function() { 
    $db = new DbHandler();
    $session = $db->getSession();
    $response["cip"] = $session['cip'];
    $response["uid"] = $session['uid'];
    $response["email"] = $session['email'];
    $response["name"] = $session['name'];
    echoResponse(200, $session);
});

$app->post('/login', function() use ($app) {
    require_once 'passwordHash.php';
    require_once 'mailer.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'password'),$r->customer);
    $response = array();
    $db = new DbHandler();
	
	$session = $db->getSession();
    
	
    $password = $r->customer->password;
    $email = $r->customer->email;
    $user = $db->getOneRecord("select uid,name,password,email,created from customers_auth where phone='$email' or email='$email'");
	
	$chars = "01234567890123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$c=substr(str_shuffle($chars),0,4);
	
	$to=$user['email'];
	$subject="Step2 Verification";
	$msg="Dear User, Your Verification Code is ".$c;
	$fromname="Facecloud Security";
	
    if ($user != NULL) {
        if(passwordHash::check_password($user['password'],$password)){
			
			try{
			send_mail($to,$subject,$msg,$fromname);
		} catch (Exception $e) {
			
		}
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';
        $response['name'] = $user['name'];
        $response['uid'] = $user['uid'];
        $response['cip'] = $c;
		
        $response['email'] = $user['email'];
        $response['createdAt'] = $user['created'];
        if (!isset($_SESSION)) {
            session_start();
        }
	
		$db->query("INSERT INTO `session_history`(`uid`, `sessionid`, `lasttime`,`extra`) VALUES ('".$user['uid']."','".$session['sid']."',now(),'".$_SERVER['REMOTE_ADDR']."')");
		  
        

		$_SESSION['cip'] = $c;
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['email'] = $email;
        $_SESSION['name'] = $user['name'];
        } else {
            $response['status'] = "error";
            $response['message'] = 'Login failed. Incorrect credentials';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});
$app->post('/step2', function() use ($app) {
    require_once 'passwordHash.php';
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('code'),$r->step);
    $response = array();
    $db = new DbHandler();
    $code = $r->step->code;
   
    $session = $db->getSession();
	$sc=$session['cip'];
    if ($code != NULL) {
        if($sc==$code){
        $response['status'] = "success";
        $response['message'] = 'Logged in successfully.';

        $_SESSION['step2'] = $code;
       
        } else {
            $response['status'] = "error";
            $response['message'] = 'Failed, Incorrect Verification Code';
        }
    }else {
            $response['status'] = "error";
            $response['message'] = 'No such user is registered';
        }
    echoResponse(200, $response);
});
$app->post('/signUp', function() use ($app) {
    $response = array();
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('email', 'name', 'password'),$r->customer);
    require_once 'passwordHash.php';
    $db = new DbHandler();
    $phone = $r->customer->phone;
    $name = $r->customer->name;
    $email = $r->customer->email;
    $address = $r->customer->address;
    $password = $r->customer->password;
    $isUserExists = $db->getOneRecord("select 1 from customers_auth where phone='$phone' or email='$email'");
    if(!$isUserExists){
        $r->customer->password = passwordHash::hash($password);
        $tabble_name = "customers_auth";
        $column_names = array('phone', 'name', 'email', 'password', 'city', 'address');
        $result = $db->insertIntoTable($r->customer, $column_names, $tabble_name);
        if ($result != NULL) {
            $response["status"] = "success";
            $response["message"] = "User account created successfully";
            $response["uid"] = $result;
			
			if(!file_exists(STORAGE_DIR.'/'.$result))
				mkdir(STORAGE_DIR.'/'.$result);
			
            if (!isset($_SESSION)) {
                session_start();
            }
            $_SESSION['uid'] = $response["uid"];
			$_SESSION['step2'] = "crosed";
            $_SESSION['phone'] = $phone;
            $_SESSION['name'] = $name;
            $_SESSION['email'] = $email;
            echoResponse(200, $response);
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to create customer. Please try again";
            echoResponse(201, $response);
        }            
    }else{
        $response["status"] = "error";
        $response["message"] = "An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
});

$app->get('/myprofile', function() use ($app) {
    $response = array();
	
	$db = new DbHandler();
    $session = $db->getSession();
   // echoResponse(200, $session);
	
    $myself = $db->getOneRecord("select * from customers_auth where uid='".$session['uid']."'");
    if(!empty($myself)){
            $response["status"] = "success";
            $response["message"] = "User Data";
            $response["uid"] = $myself["uid"];
            $response["profile"] = $myself;
            echoResponse(200, $response);        
    }else{
        $response["status"] = "error";
        $response["message"] = "select * from customers_auth where uid='".$session['uid']."'"."An user with the provided phone or email exists!";
        echoResponse(201, $response);
    }
});

$app->post('/signUpFace', function() use ($app) {
    $response = array();
	$tabble_name = "customers_auth";
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('uid', 'face'),$r->customer);
    $db = new DbHandler();
    $uid = $r->customer->uid;
    $face = $r->customer->face;
   
    try{
		$result = $db->query("update ". $tabble_name." set face='".$face."' where uid='".$uid."'");
		$response["status"] = "success";
		$response["message"] = "User account created successfully";
		$response["uid"] = $uid;
	 
		 
		echoResponse(200, $response);
                   
    } catch (Exception $e) {
        $response["status"] = "error";
        $response["message"] = $e;
        echoResponse(201, $response);
    }
});

$app->get('/logout', function() {
    $db = new DbHandler();
    $session = $db->destroySession();
    $response["status"] = "info";
    $response["message"] = "Logged out successfully";
    echoResponse(200, $response);
});


$app->get('/directorylisting', function() {
    $db = new DbHandler();
	$sess=$db->getSession();
	$author=$sess['uid'];

	$listener=array("s");
	$av=dirToArray(STORAGE_DIR.'/'.$author);
	$response["status"] = "success";
	$response["message"] = "Folders fetched successfully";
	$response["list"] = $av;
    echoResponse(200, $response);
});

function dirToArray($dir,$pnonde=null) {
	$db = new DbHandler();
    $contents = array();
    foreach (scandir($dir) as $node) {
        if ($node == '.' || $node == '..') continue;
        if (is_dir($dir . '/' . $node)) {
			//$pnonde.="/".$node;
			//$link=$db->ebase($pnonde.'/'.$node);
			$link=$pnonde.'/'.$node;
            $contents[$node] = array("type"=>"folder","folder"=>$node,"sublist"=>dirToArray($dir . '/' . $node,$pnonde.'/'.$node),"date"=>date("Y-m-d"),"link"=>$link,"selected"=>false);
            //$contents[$node] = dirToArray($dir . '/' . $node);
        } else {
            //$contents[] = $node;
			$status="active";$lnode=$node;$anode=$node;
			if(in_array(substr($node,0,2),array("AC","PE","RE","SU"))){
				
				$n=explode('`',$node);//0 >status, 1>uinqcode, 2>filename, 3>filetype
				$node=$n[2].'.'.$n[3];$status=$n[0];$lnode=$n[1];
				if($status=="PE") $status='pending';
			}
			$link=$pnonde.'/'.$anode;
			$dlink=$db->ebase($pnonde.'/'.$anode);
            $contents[$node] = array("type"=>"file","typemode"=>"-text","size"=>"20 kb","folder"=>$node,"date"=>date("Y-m-d"),"link"=>$link,"selected"=>false,"status"=>$status,"realname"=>$anode,"download"=>$dlink);
        }
    }
	$pnonde="";
    return $contents;
}



/*  ================ Files =========== */
$app->get('/files', function() {
    $response = array();
	
    //$r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('login', 'name', 'password'),$r->customer);
    $db = new DbHandler();
	$parent = "1";//$r->customer->parent;
	$sess=$db->getSession();
	$author=$sess['uid'];
	
	
    $fileslist = $db->get_results("select * from posts where `parent`='".$parent."' and post_type='folder' and post_author='".$author."'");
	
   if ($fileslist != NULL) {
		$response["status"] = "success";
		$response["message"] = "Folders fetched successfully";
		$response["data"] = $fileslist;
		
	
		echoResponse(200, $response);
	} else {
		$response["status"] = "error";
		$response["message"] = "Folders not found".$author;
		echoResponse(201, $response);
	}            
   
});

$app->post('/foldersign', function() use ($app) {
    $response = array();
	$tabble_name = "customers_auth";
    $r = json_decode($app->request->getBody());
    verifyRequiredParams(array('foldername'),$r->folder);
    $db = new DbHandler();
	$sess=$db->getSession();
	$author=$sess['uid'];
	
    $parent = $r->folder->parent;
    $foldername = $r->folder->foldername;
   
    try{
		if(!file_exists(STORAGE_DIR.'/'.$author.$parent.'/'.$foldername)){
			mkdir(STORAGE_DIR.'/'.$author.$parent.'/'.$foldername);
			
			$response["status"] = "success";
			$response["message"] = "Folder created successfully";
			
			echoResponse(200, $response);
		}else{
			 $response["status"] = "error";
			$response["message"] = "Folder already existed";
			echoResponse(201, $response);
		}        
    } catch (Exception $e) {
        $response["status"] = "error";
        $response["message"] = $e;
        echoResponse(201, $response);
    }
});

$app->post('/deletesign', function() use ($app) {
    $response = array();
	$tabble_name = "customers_auth";
    $r = json_decode($app->request->getBody());
    //verifyRequiredParams(array('list'),$r->list);
    $db = new DbHandler();
	$sess=$db->getSession();
	$author=$sess['uid'];
	
	function recurseRmdir($dir) {
	  $files = array_diff(scandir($dir), array('.','..'));
	  foreach ($files as $file) {
		(is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
	  }
	  return rmdir($dir);
	}

	
    try{
		$a=0;$b=0;
		foreach($r->list as $val){
			$fg=STORAGE_DIR.'/'.$author.$parent.$val;
			if(file_exists($fg)){
				if (is_dir($fg)) {
					recurseRmdir($fg);
					//rmdir($fg);
				}else{
					$l=explode('/',$fg);
					$nm=$l[count($l)-1];
					$d=explode('`',$nm);
					$ids=$d[1];
					
					$db->query("delete from `posts` where `special_id`='".$ids."'");
					unlink($fg);
				}
				
				
				$a++;
			}else{
				//$h.=$fg.'-----Not exists ----';
			}
			$b++;
		}
		$response["status"] = "success";
		$response["message"] = $a."/".$b." Deleted successfully";
		echoResponse(200, $response);
		/* if(file_exists(STORAGE_DIR.'/'.$author.$parent.'/'.$foldername)){
			//mkdir(STORAGE_DIR.'/'.$author.$parent.'/'.$foldername);
			
			$response["status"] = "success";
			$response["message"] = "Folder created successfully";
			
			echoResponse(200, $response);
		}else{
			 $response["status"] = "error";
			$response["message"] = "Folder already existed";
			echoResponse(201, $response);
		}    */     
    } catch (Exception $e) {
        $response["status"] = "error";
        $response["message"] = $e;
        echoResponse(201, $response);
    }
});




/* File Quee with Encryption  */
$app->post('/filequee', function() use ($app) {
	$db = new DbHandler();
	$sess=$db->getSession();
	$author=$sess['uid'];
	$ep="Fail|File not allowed";
	try{
		if($_FILES['file']['size']>0)
		{
			$fileName = $_FILES['file']['name'];
			$tmpName  = $_FILES['file']['tmp_name'];
			$fileSize = $_FILES['file']['size'];
			$fileType = $_FILES['file']['type'];
			//$fileType=(get_magic_quotes_gpc()==0 ? mysql_real_escape_string(			$_FILES['file']['type']) : mysql_real_escape_string(stripslashes ($_FILES['file'])));
			
			$chars = "01234567890123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$c=substr(str_shuffle($chars),0,6);
			$d=substr(str_shuffle($chars),0,6);
			$f=explode('.',$fileName);
			$dei=$c.date("Ymdhis").$d;
			$exte=$f[count($f)-1];
			$dm='PE`'.$dei.'`'.$f[0].'`'.$exte.'`';
			$savedfile=STORAGE_DIR.'/'.$author.$_POST['under'].'/'.$dm;
			
			if(in_array($exte,array("pdf"))){				
				//$savedfile=STORAGE_DIR.'/'.$author.$_POST['under'].'/'.$fileName.'1';
				if(move_uploaded_file($tmpName,$savedfile )){
					$db->query("INSERT INTO `posts`(`post_author`, `post_title`, `post_content`, `post_expert`, `post_type`, `post_date`, `parent`, `post_under`, `post_status`,`special_id`) VALUES ('".$author."','".$f[0]."','".$savedfile."','".$dm."','folder',now(),'".$author."','smb','pending','".$dei."');");
					
				}
				$ep="success|Folder created successfully";
			}else{
				$ep="Fail|File not allowed";
			}
			/* $crypt = new Cryptography();
    
			$crypt->Encrypt($savedfile ,$savedfile ); */
			//$crypt->Decrypt($current_path."\\encryption\\test.docx",$current_path."\\decryption\\test.docx");
			
		}
		/* if(!file_exists(STORAGE_DIR.'/'.$author.$parent.'/'.$foldername)){
			mkdir(STORAGE_DIR.'/'.$author.$parent.'/'.$foldername); */

		//$ep="success|Folder created successfully";
		/*  $response = array();
		$tabble_name = "customers_auth";
		$response["status"] = "success";
		$response["message"] = "Folder created successfully ";  */
		echoResponse(200, $ep);
		//echoResponse(200, $response);
		
    } catch (Exception $e) {
		$ep="error|".$e;
        /* $response["status"] = "error";
        $response["message"] = $e; */
        //echoResponse(201, $response);
        echoResponse(201, $ep);
    }
});