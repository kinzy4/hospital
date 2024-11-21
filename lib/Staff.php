<?php
class Staff extends User{
 
private int $salary;
private Question $question;
public function __construct() {
  
        $this->db=new Database();
    
 
}
 
function setsalary($salary){// ask question
    $this->salary=$salary;
}
function getsalary(){
    return $this->salary;
}
function answerquestion($question_id, $answer, $name) {
    $this->db->query("SELECT q_id FROM question WHERE q_id = :question_id");
    $this->db->bind(":question_id", $question_id);
    $result = $this->db->single();
    if (!$result) {
        echo "Question with ID $question_id not found";
    }
    else {
    $this->db->query("UPDATE question SET answer = :answer, s_id = (SELECT s_id FROM staff WHERE username = :name) WHERE q_id = :question_id");
    $this->db->bind(":answer", $answer);
    $this->db->bind(":name", $name);
    $this->db->bind(":question_id", $question_id);
    $this->db->execute();
    header('Location:../medi-master/staffhomepage.html');
    }
}

function addclinic($name,$price){
    $this->db->query("SELECT name FROM clinic");
    $results = $this->db->resultset();
    foreach ($results as $result) {
        if ($result['name'] == $name) {
            echo "already added";
            return;
        }
    }
    $this->db->query("INSERT INTO clinic (name,price)
    VALUES (:name,:price)");
    $this->db->bind(":name",$name); 
    $this->db->bind(":price",$price); 
    $this->db->execute();
    header('Location:../medi-master/staffhomepage.html');
} 
function adddoctor($username, $password, $address, $salary, $age, $phoneno, $clinicname) {
    $this->db->query("SELECT username, password FROM doctor");
    $results = $this->db->resultset();
    foreach ($results as $result) {
        if (($result['username'] == $username) && ($result['password'] == $password)) {
            echo "already added";
            return;
        }
    }

    $this->db->query("INSERT INTO doctor (username, password, salary, age, address, phoneno, c_id) 
    VALUES (:username, :password, :salary, :age, :address, :phoneno, (SELECT c_id FROM clinic WHERE name=:clinicname))");
    $this->db->bind(':username', $username);
    $this->db->bind(':clinicname', $clinicname); // Binding clinicname
    $this->db->bind(':password', $password);
    $this->db->bind(':salary', $salary);
    $this->db->bind(':age', $age);
    $this->db->bind(':address', $address);
    $this->db->bind(':phoneno', $phoneno);

    $this->db->execute();
    header('Location:../medi-master/staffhomepage.html');
}

 
function listpatients(){
    $this->db->query("SELECT * FROM patient");
    $results=$this->db->resultset();
    
    foreach($results as $result){
   
        echo "Patient ID: " . $result['pa_id'] . "<br>";
        echo "Username: " . $result['username'] . "<br>";
        echo "age: " . $result['age'] . "<br>";
        echo "address: " . $result['address'] . "<br>";
        echo "<br>";
    }
    }

function addappointment($time,$date){
    $this->db->query("SELECT time ,date FROM appointment");
    $results = $this->db->resultset();
    foreach ($results as $result) {
        if ($result['time'] == $time && $result['date']==$date) {
            echo "already added";
            return;
        }
    }
    $this->db->query("INSERT INTO appointment (time,date)
    VALUES (:time,:date)");
    $this->db->bind(":time",$time);
    $this->db->bind(":date",$date);
    $this->db->execute();
    header("Location:../medi-master/staffhomepage.html");
}
function appointment_to_clinic($name, $time, $date) {
    $this->db->query("SELECT time, date FROM appointment WHERE time = :time AND date = :date");
    $this->db->bind(':time', $time);
    $this->db->bind(':date', $date);
    $result = $this->db->single();

    if (!empty($result)) {
        $this->db->query("INSERT INTO clinic_appointment(c_id, ap_id) SELECT clinic.c_id, appointment.ap_id FROM clinic, appointment WHERE clinic.name = :name AND appointment.time = :time AND appointment.date = :date");
        $this->db->bind(':time', $time);
        $this->db->bind(':date', $date);
        $this->db->bind(':name', $name);
        $this->db->execute();
        header("Location: ../medi-master/staffhomepage.html");
        return;
    } else {
        echo "Appointment not found";
    }
}


function updateappointment($oldtime, $olddate, $newtime) {
    $this->db->query("SELECT time, date FROM appointment WHERE time = :oldtime AND date = :olddate");
    $this->db->bind(':oldtime', $oldtime);
    $this->db->bind(':olddate', $olddate);
    $result = $this->db->single();

    if (!empty($result)) {
    
        $this->db->query("UPDATE appointment SET time = :newtime WHERE time = :oldtime AND date = :olddate");
        $this->db->bind(':newtime', $newtime);
        $this->db->bind(':oldtime', $oldtime);
        $this->db->bind(':olddate', $olddate);
        $this->db->execute();
        header("Location:../medi-master/staffhomepage.html");
        return;
    } else {
        echo "This appointment couldn't be found";
    }
}

function cancelappointment($time,$date){
    $this->db->query("SELECT time ,date FROM appointment");
    $results = $this->db->resultset();
    foreach ($results as $result) {
        if ($result['time'] == $time && $result['date']==$date) {
            $this->db->query("DELETE FROM appointment WHERE time=:time AND date=:date");
            $this->db->bind(':time', $time);
            $this->db->bind(':date', $date);
            $this->db->execute();
            header("Location:../medi-master/staffhomepage.html");

            return;
        }
    }
   
}

function addpost($title, $content, $username) {
    $this->db->query("SELECT s_id FROM staff WHERE username = :username");
    $this->db->bind(':username', $username);
    $this->db->execute();
    $row = $this->db->single();
    if ($row) {
        $s_id = $row['s_id'];
        $this->db->query("INSERT INTO post (title, content, s_id) VALUES (:title, :content, :s_id)");
        $this->db->bind(':title', $title);
        $this->db->bind(':content', $content);
        $this->db->bind(':s_id', $s_id);
        $this->db->execute();
        header("Location: ../medi-master/staffhomepage.html");
    } else {
        echo "Error: Staff ID not found for the provided username.";
    }
}
function updatepost($title,$content,$p_id){
    try {
            $this->db->query("UPDATE post SET title = :title, content = :content WHERE p_id = :p_id");
            $this->db->bind(':title', $title);
            $this->db->bind(':content', $content);
    
            
            $this->db->bind(':p_id', $p_id);
           
            $this->db->execute();
             header("Location: ../medi-master/staffhomepage.html");
        }
    catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
function cancelpost($p_id){
    try {
        $this->db->query("DELETE FROM post WHERE p_id = :p_id");
        $this->db->bind(':p_id', $p_id);
        header("Location: ../medi-master/staffhomepage.html");
        $this->db->execute();
    }
 catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
}
function addddoctor(string $depart,int $salary,string $adress,string $gender,int $age,string $name,string $phoneno){}

function checkpendingform(){
    $this->db->query("SELECT * FROM FORM WHERE type = 0 ");
    $results = $this->db->resultset();
    if ($results) {
        echo '<div style="font-family: Arial, sans-serif;">';
        foreach ($results as $result) {
            echo '<p style="background-color: #f2f2f2; padding: 10px; border-radius: 5px;">';
            echo 'NAME : ' . $result['patientname'] . ' --> CLINIC NAME : ' . $result['clinicname']. ' IN ' . $result['datee'] .' AT' . $result['timee'];
            echo '</p>';
        }
        echo '</div>';
    } else {
        echo '<p style="background-color: #f2f2f2; padding: 10px; border-radius: 5px;">';
        echo "There is No pending forms.";
        echo '</p>';
    }    
}
function checkfeedback() {
    $this->db->query("SELECT content , pa_id FROM feedback");
    $results = $this->db->resultset();
    if ($results) {
        foreach ($results as $result) {
            echo '<div class="feedback-item">';
            echo 'PATIENT_ID ' . $result['pa_id'] . ' : ' . $result['content'];
           echo '</div>';
        }
    } else {
echo '<div class="feedback-item">';
        echo "No feedback found.";
echo '</div>';
}
}
function sendconfirm($patientname){
    $content="Success";
    $this->db->query("INSERT INTO notifications (confirm,pa_id)
                    VALUES (:content,(SELECT pa_id FROM patient WHERE username=:name))");
        $this->db->bind(':name', $patientname);                
    $this->db->bind(':content', $content);
    $this->db->execute();
}
function send_apology_email($patientname){
    $content="sorry we can't help you try to book another Appointment";
    $this->db->query("INSERT INTO notifications (apology,pa_id)
                    VALUES (:content,(SELECT pa_id FROM patient WHERE username=:name))");
        $this->db->bind(':name', $patientname);                
    $this->db->bind(':content', $content);
    $this->db->execute();
 }
 function sendconfirmemail($patientname){
    $content="Appointment booked successfully";
    $this->db->query("INSERT INTO notifications (confirm,pa_id)
                    VALUES (:content,(SELECT pa_id FROM patient WHERE username=:name))");
        $this->db->bind(':name', $patientname);                
    $this->db->bind(':content', $content);
    $this->db->execute();
}
function showreport(){
    
    $this->db->query("SELECT clinicname, SUM(nopatients) AS no_patients, SUM(totalprofit) AS total_profit FROM report GROUP BY clinicname");
$results = $this->db->resultset();
    if(!(empty($results)))
    {  
        return $results;}}

function seequestions() {
    $this->db->query("SELECT question.q_id, question.question, patient.name FROM question INNER JOIN patient ON question.pa_id = patient.pa_id");
    $results = $this->db->resultset();
    if ($results) {
        echo '<div style="font-family: Arial, sans-serif;">';
        foreach ($results as $result) {
            echo '<p style="background-color: #f2f2f2; padding: 10px; border-radius: 5px;">';
            echo 'Question id : ' . $result['q_id'] . ' --> ' . $result['question'] . ' FROM ' .  $result['name'];
            echo '</p>';
        }
        echo '</div>';
    } else {
        echo '<div style="font-family: Arial, sans-serif;">';
        echo '<p style="background-color: #f2f2f2; padding: 10px; border-radius: 5px;">';
        echo "NO QUESTIONS";
        echo '</p>';
        echo '</div>';
    }
}





}


?>