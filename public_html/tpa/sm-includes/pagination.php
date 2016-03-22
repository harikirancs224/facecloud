<?php
class _paginat
{
    public function __construct(array $arguments = array()) {
        if (!empty($arguments)) {
            foreach ($arguments as $property => $argument) {
                $this->{$property} = $argument;
            }
        }
    }

    public function __call($method, $arguments) {
        $arguments = array_merge(array("stdObject" => $this), $arguments); // Note: method argument 0 will always referred to the main class ($this).
        if (isset($this->{$method}) && is_callable($this->{$method})) {
            return call_user_func_array($this->{$method}, $arguments);
        } else {
            throw new Exception("Fatal error: Call to undefined method stdObject::{$method}()");
        }
    }
}
function pagination($qu,$i)
{
$sql=$qu;

	//if(isset($_GET['ajax'])){ $_GET['ajax']="cntnue";echo "sddddddddddddddddddddddddddddddddd";}
//$i=10;
//echo $qu;
	if(isset($_GET['pid']))
	{
		$pid=$_GET['pid'];
	}
	else
	{
		$pid=0;
	}
	
	
	if(isset($_SESSION['displayf']))
	{
		$i=$_SESSION['displayf'];
	}
	
	
	
	$q_str="";$pcount=1;$pg="";

	if(isset($_SERVER['QUERY_STRING']))
	{
		$qr= explode("&", $_SERVER['QUERY_STRING']);
		foreach($qr as $key => $val) 
		{
			
			if(in_array(substr($val, 0, 3),array("pid","aja")))
			{
			
			}
			else
			{
				
				$q_str.=$val."&";
			}
	            // echo $val;
	        }
		//$q_str=$_SERVER['QUERY_STRING']."&";
	}
	else
	{
		$q_str="";
	}
	
	$pid=0;
	if(isset($_GET['pid']))									
	{
		$pid=$_GET['pid'];
	}
	else
	{
		$pid=0;
	}
	
	
	//$qu= "select u.* from users u, departments c where u.cat_id = c.dept_id";	
	$re=mysql_query($qu) or die (mysql_error());
	$num=mysql_num_rows($re);
	//$i=5;
	$totalpages=1;
	if($num>=$i)
	{
			$j=$num%$i;
			$a= $num/$i;
		if($j>0)
		{
	$pieces = explode(".", $a);
			$pages=$pieces[0]+1;
		}
		else
		{
			$pages=$a;
		}
		$pcount=0;
		
		if($pid>=($pages-1))
		{
			$next=$pid;$en=" disabled";
		}
		else
		{
			$next=$pid+1;$en="";
		}
		
		if($pid<=0)
		{
			$prev=$pid;$ep="";
		}
		else
		{
			$prev=$pid-1;$ep="";
		}
		$first=0;$ef="";
	
	
	if($pid<=0)
		$ef="disabled";
	if($prev>=$pid)
		$ep="disabled";
			
	$pg='<ul><li class="prev '.$ef.'"><a href="?'.$q_str.'pid='.$first.'">&lt;&lt;</a></li><li class="prev '.$ep.'"><a href="?'.$q_str.'pid='.$prev.'">&lt;</a></li>';
	
	$totalpages=number_format($pages, 0, '.', '');
	
	$min=$pid-5;
	$nhalf=$min+10;
		if($min<0)
		{
			$nhalf-=$min;
			$min=0;
		}
		if($nhalf>$totalpages)
		{
			$min=$totalpages-10;
			$nhalf=$totalpages;
			
		}
		if($min<0)
		{
			$min=0;
		}
		
		
		for($q=$min;$q<$nhalf;$q++)
		{
			if($nhalf<=$totalpages)
			{
				$m=$q+1;
				
				if($pid==$q)
					$pg.='<li><a class="active" href="?'.$q_str.'pid='.$q.'">'.$m.'</a></li>';
				else
					$pg.='<li><a href="?'.$q_str.'pid='.$q.'">'.$m.'</a></li>';
				$pcount++;
			}
		}
		
		$last=$totalpages-1;$el="";
		if(($pid+1)>=$totalpages)
			$el="disabled";
		if($next>=$totalpages)
			$en="disabled";
		$pg.='<li class="next '.$en.'"><a href="?'.$q_str.'pid='.$next.'">&gt;</a></li><li class="next '.$el.'"><a href="?'.$q_str.'pid='.$last.'">&gt;&gt;</a></li></ul>';
	}
	
	
	$limit=$pid*$i;
	
	$j=($i*$pid)+1;
	$c=$pid+1;
	$pquery="Page ".$c." of ".$totalpages." entries.";
	$pagd=array(
	'pagination'=>$pg,
	'limit'=>$limit,
	'display'=>$i,
	'sno'=>$j,
	'pagequery'=>$pquery,
	'sql'=>$sql." limit ".$limit.",".$i
	);
return $pagd;

}
?>