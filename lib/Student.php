

<?php

include_once 'Session.php';
include 'Database.php';




class Student{
	private $db;
	public function __construct() {
        $this->db = new Database();    
    }

    public function getRegularStudent() {
    	$sql = "SELECT * FROM student WHERE status = :status";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':status', 2);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function getReqStudent() {
    	$sql = "SELECT * FROM student WHERE status = :status";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':status', 1);
        $query->execute();
        $result = $query->fetchAll();

        return $result;
    }

    public function isFound($data){
        $sql = "SELECT * FROM hallRequest WHERE studentID = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $data);
        $query->execute();
        $result = $query->fetchAll();

        foreach ($result as $key) {
            if($key == $data){
                return true;
            }
        }
        return false;


    }

    public function hallReques($data){
        $student_id = $data['student_id'];
        $first = $data['first'];
        $second = $data['second'];
        $third = $data['third'];
        $four = $data['four'];

        $sqll = "UPDATE student SET 
        hallStatus = :hallstatus
        WHERE student_id = :id";

        
        $sql = "INSERT INTO hallRequest(studentID,firstChoice,secondChoice,thirdChoice,fourtChoice,status) VALUES(:student_id,:first,:second,:third,:four,:statu)";
        $query = $this->db->pdo->prepare($sql);
        $queryy = $this->db->pdo->prepare($sqll);


        $query->bindValue(':student_id', $student_id);
        $query->bindValue(':first', $first);
        $query->bindValue(':second', $second);
        $query->bindValue(':third', $third);
        $query->bindValue(':four', $four);
        $query->bindValue(':statu', 'pending');

        $queryy->bindValue(':hallstatus', 'pending');
        $queryy->bindValue(':id', $student_id);
        
        $res = $queryy->execute();
        $result = $query->execute();

        if($result){
            $msz = "<div class='alert alert-success'><strong>Hall Request has been succesfully</strong></div>";
            
            return $msz;
        }else{
         $msz = "<div class='alert alert-success'><strong>Success</strong>! O-Ops</div>";
         return $msz;
     }
 }

 public function getChoice(){
    $sql = "SELECT * FROM hallRequest WHERE studentID = :id";
    $query = $this->db->pdo->prepare($sql);
    $query->bindValue(':id', $_SESSION['id']);
    $query->execute();
    $result = $query->fetch();

    return $result;
}

public function getAllHall(){
    $sql = "SELECT * FROM hall";
    $query = $this->db->pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll();
    return $result;
}

public function getHallById($data){
    $sql = "SELECT * FROM uniqueHall WHERE student_id = :id";
    $query = $this->db->pdo->prepare($sql);
    $query->bindValue(':id', $data);
    $query->execute();
    $result = $query->fetch();

    return $result;
}

public function setRoomChoice($data,$hall,$id){
    $fst    = $data['first'];
    $scnd   = $data['second']; 
    $thd    = $data['third'];


    $sql = "INSERT INTO roomChoice(student_id,firstChoice,secondChoice,thirdChoice,hallName,status) VALUES(:student_id,:first,:second,:third,:hallName,:statu)";
    $query = $this->db->pdo->prepare($sql);



    $query->bindValue(':student_id', $id);
    $query->bindValue(':first', $fst);
    $query->bindValue(':second', $scnd);
    $query->bindValue(':third', $thd);
    $query->bindValue(':hallName', $hall);
    $query->bindValue(':statu', 'pending');


    $result = $query->execute();
    if($result){
        $msz = "<div class='alert alert-success'><strong>Hall Request has been succesfully</strong></div>";

        return $msz;
    }else{
     $msz = "<div class='alert alert-success'><strong>Success</strong>! O-Ops</div>";
     return $msz;
 }



}
public function getAllRoomByHall($data){
    $sql = "SELECT * FROM room WHERE hallName = :id";
    $query = $this->db->pdo->prepare($sql);
    $query->bindValue(':id', $data);
    $query->execute();
    $result = $query->fetchall();

    return $result;
}

public function getSeatChoiceById($data){
    $sql = "SELECT * FROM roomChoice WHERE student_id = :id";
    $query = $this->db->pdo->prepare($sql);
    $query->bindValue(':id', $data);
    $query->execute();
    $result = $query->fetch();

    return $result;
}

public function getStudentById($data){
    $sql = "SELECT * FROM student WHERE student_id = :id";
    $query = $this->db->pdo->prepare($sql);
    $query->bindValue(':id', $data);
    $query->execute();
    $result = $query->fetch();

    return $result;
}

public function getSeat($data){
    $sql = "SELECT * FROM room WHERE roomNumber = :id";
    $query = $this->db->pdo->prepare($sql);
    $query->bindValue(':id', $data);
    $query->execute();
    $result = $query->fetch();
    Session::set("cur_seat_room",$result['currentSeat']);
    return $result;
}

public function setStudentSeatStatus($data){
    $roomnumber     =   $data['room_number'];

    $studentid      =   $data['std_id'];
    $hallname       =   $data['hall_name'];


    $seat = Session::get('cur_seat_room');
    $seat = (int) $seat+1;


    
    $sql = "INSERT INTO selectRoom(student_id,roomNumber,hallName) VALUES(:id,:roomnumber,:hallname)";
    $sql1 = "UPDATE uniqueHall SET status = :stat WHERE student_id = :stdi";
    $sql2  = "UPDATE roomChoice SET status = :statu WHERE student_id = :stdid";
    $sql3 = "UPDATE room SET currentSeat = :seat WHERE roomNumber = :room";


    $query  = $this->db->pdo->prepare($sql);
    $query1 = $this->db->pdo->prepare($sql1);
    $query2 = $this->db->pdo->prepare($sql2);
    $query3 = $this->db->pdo->prepare($sql3);



    $query->bindValue(':id', $studentid);
    $query->bindValue(':roomnumber', $roomnumber);
    $query->bindValue(':hallname', $hallname);



    $query1->bindValue(':stdi', $studentid);
    $query1->bindValue(':stat', 'Accepted');


    $query2->bindValue(':stdid', $studentid);
    $query2->bindValue(':statu', 'Accepted');

    $query3->bindValue(':seat', $seat);
    $query3->bindValue(':room', $roomnumber);

    $result = $query->execute();
    $query1->execute();
    $query2->execute();
    $query3->execute();

    if ($result) {
        $msz = "<div class='alert alert-success'><strong>Success </strong> ! hall added.</div>";
        return $msz;
    } else {
        $msz = "<div class='alert alert-danger'><strong>Error</strong></div>";
        return $msz;
    }


}

public function getRoomSeat($data){
    $sql = "SELECT * FROM selectRoom WHERE student_id = :id";
    $query = $this->db->pdo->prepare($sql);
    $query->bindValue(':id', $data);
    $query->execute();
    $result = $query->fetch();

    return $result;
}







}





?>