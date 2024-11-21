<?php
class Question{
    private $db;
private string $question;
private string $answer;
public function __construct(){
    $this->db=new Database();
 }
function setquestion(string $question){
    $this->question=$question;
}
function getquestion(){
    return $this->question;
}
function setanswer(string $answer){
    $this->answer=$answer;
}
function getanswer(){
    return $this->answer;
}

}






?>