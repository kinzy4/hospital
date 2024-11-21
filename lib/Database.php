<?php
class Database{
private $host= DB_HOST;
private $user= DB_USER;
private $pass= DB_PASS;
private $dbname= DB_NAME;
private $dbh;
private $error;
private $stmt;
public function __construct(){
//set connection
$dsn='mysql:host='. $this->host .';dbname='. $this->dbname;
try{
$this->dbh=new PDO($dsn,$this->user,$this->pass);
}catch(PDOException $e){
$this->error = $e.getMessage();
}
}
public function query($query){
$this->stmt=$this->dbh->prepare($query);
}
public function bind($param,$value){
    $this->stmt->bindValue($param,$value);
}
public function execute(){
    return $this->stmt->execute();
}
public function resultset(){
    $this->execute();
   return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
} 
public function single(){
    
    $this->execute();
   return $this->stmt->fetch(PDO::FETCH_ASSOC);
} 

}

?>