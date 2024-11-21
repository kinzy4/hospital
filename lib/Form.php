<?php
class Form{
    private $db;
   private string $patientname;
private string $clinic;
private $time;
private $date;
private  $symptoms=[];
public function __construct($date = null, $time = null) {
     
        $this->db=new Database();
     
    if ($date instanceof DateTime) {
        $this->date = $date;
    } else {
        $this->date = new DateTime($date);
    }
    

    if ($time instanceof DateTime) {
        $this->time = $time;
    } else {
        $this->time = new DateTime($time);
    }
}


public function getDate(): DateTime {
    return $this->date;
}


public function setDate(DateTime $date): void {
    $this->date = $date;
}


public function getTime(): DateTime {
    return $this->time;
}


public function setTime(DateTime $time): void {
    $this->time = $time;
} 

function setclinicname(string $name){
    $this->clinic=$name;
}
function getclinicname(){
    return $this->clinic;
}

function setpatientname(string $patientname){
    $this->patientname=$patientname;
}
function getpatientname(){
    return $this->patientname;
}
public function setsymptoms(array $symptoms): void {
    $this-> symptoms = $symptoms;
}
public function getsymptomps(): array {
    return $this->symptoms;
}

}




?>