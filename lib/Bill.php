<?php
class Bill{
    private $db;
private int $price;
private string $clinicname;
private string $patientname;
public function __construct(){
    $this->db=new Database();
 }
function setprice(int $price){
    $this->price=$price;
}
function getprice(){
   return $this->price;
}
function setclinicname(string $clinicname){
    $this->clinicname=$clinicname;
}
function getclinicname(){
    return $this->clinicname;
}
function setpatientname(string $patientname){
    $this->patientname=$patientname;
}
function getpatientname(){
    return $this->patientname;
}
}





?>