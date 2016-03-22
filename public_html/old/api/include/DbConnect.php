<?php
class sdb 
{ 
	function __construct() {
        $connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('Oops connection error -> ' . mysql_error());
        mysql_select_db(DB_DATABASE, $connection) or die('Database error -> ' . mysql_error());
    }
	function get_results($query)
	{
		$result = mysql_query($query);
		$last_result=array();$num_rows=0;
		
		while ( $row = @mysql_fetch_object( $result ) ) {
			$last_result[$num_rows] = $row;
			$num_rows++;
		}
		return $last_result;
	}
	function query($query)
	{
		return $result = mysql_query($query);
	}
} 