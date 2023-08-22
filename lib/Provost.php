

<?php

	include_once 'Session.php';
	include 'Database.php';
    


?>

<?php 



class Provost{
    private $db;
    public function __construct() {
        $this->db = new Database();    
    }

    public function getStudentByHall($data){
        $sql = "SELECT * FROM uniqueHall WHERE hallName = :sta";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':sta', $data);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function getProvostById($data){
        $sql = "SELECT * FROM provost WHERE provostId = :sta";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':sta', $data);
        $query->execute();
        $result = $query->fetch();
        return $result;
    }

    public function addNewRoom($data,$hall){
        $roomnumber = $data['room_number'];
        $totalseat = $data['total_seat'];
        $currentseat = $data['current_seat'];


        $sql = "INSERT INTO room(roomNumber,totalSeat,currentSeat,hallName) VALUES(:room,:total,:current,:hall)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':room', $roomnumber);
        $query->bindValue(':total', $totalseat);
        $query->bindValue(':current', $currentseat);
        $query->bindValue(':hall', $hall);
        $result = $query->execute();
        if($result){
            $msz = "<div class='alert alert-success'><strong>Success! </strong>New Room Created</div>";
            return $msz;
        }else{
             $msz = "<div class='alert alert-warning'><strong>Wrong </strong>! O-Ops</div>";
            return $msz;
        }
    }

    public function getAllRoom($data){
        $sql = "SELECT * FROM room WHERE hallName = :sta";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':sta', $data);
        $query->execute();
        $result = $query->fetchall();
        return $result;
    }

    public function updateRoom($data){
        $hallname = $data['hall_name'];
        $roomnumber = $data['room_number'];
        $totalseat = $data['total_seat'];
        $currentseat = $data['current_seat'];

       
        $sql = "UPDATE room SET 
                        totalSeat = :ts,
                        currentSeat = :cs
                        
                    WHERE roomNumber = :room and hallName = :name ";

        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':room', $roomnumber);
        $query->bindValue(':ts', $totalseat);
        $query->bindValue(':cs', $currentseat);
        $query->bindValue(':name', $hallname);
        

        $result = $query->execute();
        if ($result) {
            $msz = "<div class='alert alert-success'><strong>Success</strong> ! updated.</div>";
            return $msz;
        } else {
            $msz = "<div class='alert alert-danger'><strong>Error</strong> ! Deafult password not updated.</div>";
            return $msz;
        }
    }

    public function deleteRoom($data){
        $roomnumber = $data['room_number'];
        $hallname = $data['hall_name'];


        if ($roomnumber == "") {
            $msz = "<div class='alert alert-danger'>Invalid Id !</div>";
            return $msz;
        } else {
            $sql = "DELETE FROM room WHERE roomNumber = :room and hallName = :name";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':room', $roomnumber);
            $query->bindValue(':name', $hallname);
            $result = $query->execute();

            if ($result) {
                $msz = "<div class='alert alert-success'><strong>Success</strong> ! Room Deleted.</div>";
                return $msz;
            } else {
                $msz = "<div class='alert alert-danger'><strong>Error</strong> ! Provost not Deleted.</div>";
                return $msz;
            }
        }

    }


    public function getRoomNumber($data){
        $sql = "SELECT * FROM room WHERE hallName = :sta";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':sta', $data);
        $query->execute();
        $result = $query->fetchall();
        return $result;
    }

    
   



}


?>