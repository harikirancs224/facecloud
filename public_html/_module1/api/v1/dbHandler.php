<?php
class DbHandler {

    private $conn;

    function __construct() {
        require_once 'dbConnect.php';
        // opening db connection
        $db = new dbConnect();
        $this->conn = $db->connect();
    }
	
	public function ebase($v){
		return base64_encode($v);
	}
	public function dbase($v){
		return base64_decode($v); 
	}

    /**
     * Fetching single record
     */
    public function getOneRecord($query) {
        $r = $this->conn->query($query.' LIMIT 1') or die($this->conn->error.__LINE__);
        return $result = $r->fetch_assoc();    
    }
	
	public function get_results($query) {
		$new_array = array();
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);
		//$m=$r->fetch_all();
	
		// Loop
		while($user = $r->fetch_object()) {
			$new_array[]=$user;
		}
        return $result = $new_array;    
    }
	
	public function query($query) {
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);
        return $r;    
    }
    /**
     * Creating new record
     */
    public function insertIntoTable($obj, $column_names, $table_name) {
        
        $c = (array) $obj;
        $keys = array_keys($c);
        $columns = '';
        $values = '';
        foreach($column_names as $desired_key){ // Check the obj received. If blank insert blank into the array.
           if(!in_array($desired_key, $keys)) {
                $$desired_key = '';
            }else{
                $$desired_key = $c[$desired_key];
            }
            $columns = $columns.$desired_key.',';
            $values = $values."'".$$desired_key."',";
        }
        $query = "INSERT INTO ".$table_name."(".trim($columns,',').") VALUES(".trim($values,',').")";
        $r = $this->conn->query($query) or die($this->conn->error.__LINE__);

        if ($r) {
            $new_row_id = $this->conn->insert_id;
            return $new_row_id;
            } else {
            return NULL;
        }
    }
public function getSession(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $sess = array();
    if(isset($_SESSION['uid'])) 
    {
        $sess["step2"] = $_SESSION['step2']; 
        $sess["cip"] = $_SESSION['cip'];         $sess["uid"] = $_SESSION['uid']; 
        $sess["name"] = $_SESSION['name'];
        $sess["email"] = $_SESSION['email'];
    }
    else
    {
        $sess["step2"] = '';
        $sess["cip"] = '';
        $sess["name"] = 'Guest';
        $sess["email"] = '';
    }
    return $sess;
}
public function destroySession(){
    if (!isset($_SESSION)) {
    session_start();
    }
    if(isSet($_SESSION['uid']))
    {
        unset($_SESSION['step2']);
        unset($_SESSION['cip']);        unset($_SESSION['uid']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        $info='info';
        if(isSet($_COOKIE[$info]))
        {
            setcookie ($info, '', time() - $cookie_time);
        }
        $msg="Logged Out Successfully...";
    }
    else
    {
        $msg = "Not logged in...";
    }
    return $msg;
}
 
}

?>
