<?php

abstract class User  extends Person{
    protected $db;
private string $username;
private string $password;
private string $role;
 public function __construct(){
    $this->db=new Database();
 }
function setusername(string $username){
    $this->username=$username;
}
function getusername(){

    return $this->username;
}

function setpassword(string $password){
    $this->password=$password;
}
function getpassword(){

    return $this->password;
}
function login(string $username,string $password,string $role){
    
    $this->db->query("SELECT username,password FROM {$role}");
    $results=$this->db->resultset();
    if(!empty($results))
    {  foreach($results as $result){
       if(($result['username']==$username)&&($result['password']==$password)){
        header("Location: ../medi-master/{$role}homepage.html");
        return;
       }
     }
    }echo"again";
}
function logout(){}



}







?>