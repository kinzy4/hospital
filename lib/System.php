<?php
 
class System {
private $report;
private $bill;
private $db;
private string $remainder;
public function __construct(){
    $this->db=new Database();
 }
 function generatereport(string $clinicname,int $no,int $tprofit){
  $this->db->query("INSERT INTO report (clinicname,nopatients,totalprofit	) VALUES(:clinicname,:no,:tprofit)");
  $this->db->bind(":clinicname",$clinicname);
  $this->db->bind(":no",$no);
  $this->db->bind(":tprofit",$tprofit);

  $this->db->execute();
} 
function sendbills($clinicname, $patientname) {
  $this->db->query("INSERT INTO bill (clinicname, patientname, price, pa_id, c_id)
                   VALUES (:clinicname, :patientname, 
                           (SELECT price FROM clinic WHERE name = :clinicname), 
                           (SELECT pa_id FROM patient WHERE username = :patientname),
                           (SELECT c_id FROM clinic WHERE name = :clinicname))");
  
  $this->db->bind(':clinicname', $clinicname);
  $this->db->bind(':patientname', $patientname);
  
  $this->db->execute();
}

function sendremainders(){}
}








?>