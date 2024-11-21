<?php
class Post{
    private $db;
private string $content;
public function __construct(){
    $this->db=new Database();
 }
function setcontent(string $content){
    $this->content=$content;
}
function getcontent(){
    $this->content;
}

}



?>