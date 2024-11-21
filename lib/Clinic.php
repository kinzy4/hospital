<?php

class Clinic{
    private $db;
private string $name;
private  $appointments=[];
private  $doctors=[];
public function __construct() {
     
        $this->db=new Database();
     
    $this->doctors= [];
    $this->appointments= [];
}
function setname(string $name){
    $this->name=$name;
}
function getname(){
   return  $this->name;
}
function setdoctors($doctor){
    $this->doctors[]=$doctor;
}
function getdoctor(){
   return  $this->doctors;
}
function setappointments($appointments){
    $this->appointments[]=$appointments;
}
function getappointments(){
   return  $this->appointments;
}
}










?>