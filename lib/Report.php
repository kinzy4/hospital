<?php
class Report{
private string $clinicname;
private int $no_patients;
private int $totalprofit;
private $db;
public function __construct(){
    $this->db=new Database();
 }
function setno_patient(int $num){
 $this->no_patient=$num;

}
function getno_patient(){
 return $this->no_patient;

}
function setclinicname(string $name){
    $this->clinicname=$name;
}
function getclinicname(){
    return $this->clinicname;
}
function settotalprofit(int $num){
    $this->totalprofit=$num;
}
function gettotalprofit(){
    return$this->totalprofit;
}
}



?>