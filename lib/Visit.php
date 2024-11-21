<?php
class Visit{
    private string $clinicname;
    private int $price;
    private string $doctorname;
    private $db;
    public function __construct(){
        $this->db=new Database();
     }
    function setprice(int $num){
        $this->price=$num;
       
       }
       function getprice(){
        return $this->price;
       
       }
       function setclinicname(string $name){
           $this->clinicname=$name;
       }
       function getclinicname(){
           return $this->clinicname;
       }
       function setdoctorname(string $name){
           $this->doctorname=$name;
       }
       function getdoctorname(){
           return $this->doctorname;
       }

}




?>