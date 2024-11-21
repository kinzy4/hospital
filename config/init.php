<?php
// Contain all requires and includes
require_once("config.php");
spl_autoload_register('myAutoloader');
function myAutoloader($classname)
{


    require_once'../lib/'.$classname.'.php';

}

?>