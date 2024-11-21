<?php
class Patient extends User{ 
private $medicalhistory=[];
private Visit $lastvisit;
private Bill $bills;
private Question $question;
private string $email;
 
public function __construct() {
    $this->db=new Database();
  
    $this->bills = new Bill();
 
    $this->lastvisit = new Visit();
}
function setlastvisit($visit){
    $this->lastvisit=$visit;
}
function getlastvisit(){
    return $this->lastvisit;
}   
function setbill($bill){
    $this->bills=$bill;
}
function getbill(){
    return $this->bills;
}   
 
function setemail($email){
    $this->email=$email;
}
function getemail(){
    return $this->email;
} 
 
function bookappointment(string $name,string $clinicname,$time,$date){
    $this->db->query("SELECT time,date FROM appointment");
    $results=$this->db->resultset();
    if(!(empty($results)))
    {  foreach($results as $result){

       if(($result['time']==$time)&&($result['date']==$date)){
     
        $this->db->query("DELETE FROM appointment WHERE time=:time and date=:date");
        $this->db->bind("time",$time);
        $this->db->bind("date",$date);
          $this->db->execute();

//echo"appointment booked succefully";

$this->db->query("SELECT * FROM clinic ");
    $rts=$this->db->resultset();
    if(!(empty($rts)))
    {  foreach($rts as $result){
       if($result['name']==$clinicname){
        $totalprofit=$result['price'];
        $system=new system();
        $system->generatereport($clinicname,1,$totalprofit);
       $system->sendbillS($clinicname,$name);
       }
     }
    }
    $staff=new staff();
    $staff-> sendconfirm($name);
    return;
}


// $system->generatereport($clinicname,1,$totalprofit);
        
       }
    }

        
    $staff=new staff();
    $staff->send_apology_email($name);}
function askquestion($question,$name){// ask question
    $this->db->query("INSERT INTO question (question ,pa_id)
    VALUES (:question,(SELECT pa_id FROM patient WHERE username = :name ))");
    $this->db->bind(":question",$question);
    $this->db->bind(":name",$name);
    $this->db->execute();
    header("Location:../medi-master/patienthomepage.html");
}
function register(string $username, string $password, string $address, string $gender, int $age, string $name, $phoneno) {
       
    $this->db->query("SELECT username,password FROM patient");
    $results=$this->db->resultset();
    if(!empty($results))
    {  foreach($results as $result){
       if(($result['username']==$username)&&($result['password']==$password)){
        header("Location:../medi-master/loginpatiant.html");
        return;
       }
     }
    }
    
    
    $this->db->query("INSERT INTO patient (username, password, gender, age, address, phoneno, name) 
    VALUES (:username, :password, :gender, :age, :address, :phoneno, :name)");
    $this->db->bind(':username', $username);
    $this->db->bind(':password', $password);
    $this->db->bind(':gender', $gender);
    $this->db->bind(':age', $age);
    $this->db->bind(':address', $address);
    $this->db->bind(':phoneno', $phoneno);
    $this->db->bind(':name', $name);
   
    $this->db->execute();
    header("Location:../medi-master/patienthomepage.html");
 

}

function writefeedback(string $content){}
function showbill($patientname){
    $this->db->query("SELECT * FROM bill WHERE bill.pa_id=(SELECT pa_id FROM patient WHERE username='$patientname')");
    $results=$this->db->resultset();
  if(!empty($results)){return $results;}
     
     
    } 

    function addvisit(string $visitname,string $doctorname,int $price,string $username){
        try {
        $this->db->query("SELECT pa_id FROM patient where username = :username");
        $this->db->bind(':username',$username);
        $this->db->execute();
        $row=$this->db->single();
        if ($row) {
        $pa_id=$row['pa_id'];
        $this->db->query("INSERT INTO visit (visitname,doctorname,price,pa_id)
        VALUES (:visitname,:doctorname,:price,:pa_id)");
        $this->db->bind(':visitname', $visitname);
        $this->db->bind(':doctorname', $doctorname);
        $this->db->bind(':price', $price);
        $this->db->bind(':pa_id', $pa_id);
        $this->db->execute();
        header("Location:../medi-master/patienthomepage.html");
    } else {
        echo "Error: Patient ID not found for the provided username.";
    }
    } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    }
    
    }
    function seeposts() {
        $this->db->query("SELECT * FROM post");
        $results = $this->db->resultset();
        if ($results !== null) { // Check if $results is not null
            echo '<div style="font-family: Arial, sans-serif;">';
            foreach ($results as $result) {
                echo '<p style="background-color: #f2f2f2; padding: 10px; border-radius: 5px;">';
                echo $result['p_id'] . ' : ' . $result['title'] . ' : ' . $result['content'] . "<br>";
              
                echo '</p>';
            }
            echo '</div>';
        } else {
            echo "No posts found.";
        }}
    
function updateprofile(string $oldusername,$newusername,string $password,string $address){
    $this->db->query("SELECT username FROM patient");
    $results=$this->db->resultset();
    if(!empty($results))
    {  foreach($results as $result){
       if($result['username']==$oldusername){
    $this->db->query("UPDATE patient SET username = :username, password = :password,address = :address WHERE username=:oldusername");
    $this->db->bind(':oldusername', $oldusername);
    $this->db->bind(':username', $newusername);
    $this->db->bind(':password', $password);
    $this->db->bind(':address', $address);
   
    $this->db->execute();
    header("Location:../medi-master/patienthomepage.html");
        return;
       }}

}
echo"Wrong userrname";
}
function searchposts(string $title){
    $this->db->query("SELECT * FROM post where title = :title");
    $this->db->bind(':title',$title);
    $this->db->execute();
    $results = $this->db->resultset();
   if (!empty($results)) {
    foreach ($results as $post) {
        echo "Post ID: " . $post['p_id'] . ", Title: " . $post['title'] . ", Content: " . $post['content'] . "<br>";
        echo $post['image_data']."<br>";
    }
} else {
    echo "No posts found with the specified title.";
}
    return $results;
}

function showpastvisits(string $username){
    $this->db->query("SELECT pa_id FROM patient where username = :username");
    $this->db->bind(':username',$username);
    $this->db->execute();
    $row=$this->db->single();
    $pa_id=$row['pa_id'];
    $this->db->query("SELECT * FROM visit where pa_id = :pa_id");
    $this->db->bind(':pa_id',$pa_id);
    $this->db->execute();
    $results = $this->db->resultset();
 if(empty($results)){

        echo "No visits found for this patient.";
    }
        return $results;
    }
function checknotifications(){}

}

function writefeedback(string $name, string $content) {
    $this->db->query("INSERT INTO feedback (content, pa_id) VALUES (:feedback, (SELECT pa_id FROM patient WHERE username = :name))");
    $this->db->bind(":name", $name);
    $this->db->bind(":feedback", $content);
    $this->db->execute();
    header("Location:../medi-master/patienthomepage.html");
}

?>