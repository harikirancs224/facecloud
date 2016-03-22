<?php
$lg=get_login();
//alert();


$html=new _html;
$slug=new _slug;

if(isset($_GET['alert']))	alert($_GET['alert']);
if(isset($_GET['logout']))	get_logout();


	
	
	/*=====================Paginat starts */
$paginat=new _paginat();
$func = "setAge";

$paginat->getInfo = function($paginat) { // $stdObject referred to this object (stdObject).
    echo $stdObject->name . " " . $stdObject->surname . " have " . $stdObject->age . " yrs old. And live in " . $stdObject->adresse.'<br/>';
};

$paginat->setinfo = function($paginat,$wr,$val) { // $stdObject referred to this object (stdObject).
   $paginat->$wr=$val;
};

$func = "setAge";
$paginat->{$func} = function($stdObject, $age) { // $age is the first parameter passed when calling this method.
    $stdObject->age = $age;
};

$paginat->setAge(24); // Parameter value 24 is passing to the $age argument in method 'setAge()'.

// Create dynamic method. Here i'm generating getter and setter dynimically
// Beware: Method name are case sensitive.
foreach ($paginat as $func_name => $value) {
    if (!$value instanceOf Closure) {

        $paginat->{"set" . ucfirst($func_name)} = function($stdObject, $value) use ($func_name) {  // Note: you can also use keyword 'use' to bind parent variables.
            $stdObject->{$func_name} = $value;
        };

        $paginat->{"get" . ucfirst($func_name)} = function($stdObject) use ($func_name) {  // Note: you can also use keyword 'use' to bind parent variables.
            return $stdObject->{$func_name};
        };

    }
}

/*=====================Paginat close */



