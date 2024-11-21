<?php
class Appointment {
    private $date;
    private $time;
    private $db;

    
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
}

 


?>