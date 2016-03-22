<?php
	$tarray=array("thirdparty_page"=>"Third Party");
	add_admin('thirdparty', 'thirdparty','admin', 'Thirdparty Control', 'cloud' , array(),"fa-th",'');
	
	function thirdparty()
	{
		global $smdb;
		
		$args = func_get_args();
		$tarraya=$args[0][0]["sub"];
		
		include('list.php');
		
		foreach($tarraya as $key=>$value)
		{
			if(isset($_GET[$key]))
			{
				define("PLUGKEY",$key);
				if(file_exists(SM_PLUGIN_DIR.'/'.$_GET[$key].'.php'))
					include(SM_PLUGIN_DIR.'/'.$key.'.php');
				else
					include($key.'.php');
			}
		}
	}

  