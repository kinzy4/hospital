<?php 
class Doctor extends Person{
private $db;
private int $salary;
private string $department;
public function __construct(){
    $this->db=new Database();
 }
function setsalary(int $salary){
    $this->salary=$salary;
}
function getsalary(){
    return $this->salary;
}
function setdepartment(string $dept){
    $this->department=$dept;
}
function getdepartment(){
    return $this->department;
}

}



?>