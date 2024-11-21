<?php
abstract class Person {
private string $name;
private int $phoneno;
private int $age;
private  string $gender;
private  string $address;

function setname(string $name){
    $this->name=$name;
    
} 
function getname(){
    return $this->name;} 
    function setphone(int $phone){
        $this->phoneno=$phone;
        
} 
function getphone(){
        return $this->phoneno;} 
        function setage(int $age){
            $this->age=$age;
        
} 
function getage(){         
            return $this->age;} 
            function setgender(string $gender){
                $this->gender=$gender;
            
}              
function getgender(){
                return $this->gender;} 
                function setaddres(string $address){
                    $this->address=$address;
    
}                                           
function getaddress(){
                    return $this->address;}                   

}



?>