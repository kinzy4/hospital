<?php
 
class Admin extends User{
    public function __construct() {
        $this->db=new Database();
    }
private $staffaddedname=[];
 
function addstaff($ausername,$username,$password, $salary, $address, $gender, $age,$name,$phoneno){
    $this->db->query("SELECT username,password FROM staff");
    $results=$this->db->resultset();
    if(!empty($results))
    {  foreach($results as $result){
       if(($result['username']==$username)&&($result['password']==$password)){
        echo"already added";
        header("Location:../medi-master/addstaff.php");
        return;
       }
     }
    }
    
    $this->db->query("INSERT INTO staff(username,password,gender,name,address,phoneno,age,salary)
VALUES(:username,:password,:gender,:name,:address,:phoneno,:age,:salary)");

$this->db->bind(":username", $username);
$this->db->bind(":password", $password);
$this->db->bind(":salary", $salary);
$this->db->bind(":address", $address);
$this->db->bind(":gender", $gender);
$this->db->bind(":age", $age);
$this->db->bind(":name", $name);
$this->db->bind(":phoneno", $phoneno);
$this->db->execute();
$this->db->query("INSERT INTO staff_admin(staff_name, a_id)
SELECT :username, a_id FROM admin WHERE username = :ausername");
$this->db->bind(":username", $username);
$this->db->bind(":ausername", $ausername);
$this->db->execute();

header("Location:../medi-master/adminhomepage.html");

}
public function liststaff () {
    $this->db->query("SELECT s_id , name FROM staff");
    $results = $this->db->resultset();
    if ($results) {
        echo '<div style="font-family: Arial, sans-serif;">';
        foreach ($results as $result) {
            echo '<p style="background-color: #f2f2f2; padding: 10px; border-radius: 5px;">';
            echo 'STAFF ID : ' . $result['s_id'] . ' --> STAFF NAME : ' . $result['name'];
            echo '</p>';
        }
        echo '</div>';
    } else {
        echo '<p style="background-color: #f2f2f2; padding: 10px; border-radius: 5px;">';
        echo "NONE";
        echo '</p>';
    }
}
public function getStringArray(): array {
    return $this->staffaddedname;
}
}

?>