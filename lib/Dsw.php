

<?php

	include_once 'Session.php';
	include 'Database.php';
	



class Dsw{
	private $db;
	public function __construct() {
        $this->db = new Database();    
    }
    //hall create
    public function create($data) {
        $hall_name      = $data['hall_name'];


        $sql = "INSERT INTO hall(hallName) VALUES(:hall_name)";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':hall_name', $hall_name);
        $result = $query->execute();
        if($result){
            $msz = "<div class='alert alert-success'><strong>Success! </strong>New Hall Created</div>";
            return $msz;
        }else{
             $msz = "<div class='alert alert-success'><strong>Wrong </strong>! O-Ops</div>";
            return $msz;
        }

    }

    public function getAllHall(){
        $sql = "SELECT * FROM hall";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function updateHall($data){


        $h_id = $data['hall_id'];
        $h_name = $data['ha_name'];

       
        $sql = "UPDATE hall SET 
                        hallName = :h_name
                        
                    WHERE hallID= :h_id";

        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':h_id', $h_id);
        $query->bindValue(':h_name', $h_name);
        

        $result = $query->execute();
        if ($result) {
            $msz = "<div class='alert alert-success'><strong>Success</strong> ! updated.</div>";
            return $msz;
        } else {
            $msz = "<div class='alert alert-danger'><strong>Error</strong> ! Deafult password not updated.</div>";
            return $msz;
        }


           
    }

    public function deleteHall($data){
        $id = $data['id'];

        if ($id == "") {
            $msz = "<div class='alert alert-danger'>Invalid Id !</div>";
            return $msz;
        } else {
            $sql = "DELETE FROM hall WHERE hallID = :id";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $result = $query->execute();

            if ($result) {
                $msz = "<div class='alert alert-success'><strong>Success</strong> ! Provost Deleted.</div>";
                return $msz;
            } else {
                $msz = "<div class='alert alert-danger'><strong>Error</strong> ! Provost not Deleted.</div>";
                return $msz;
            }
        }
    }


   


    //provost Create

    public function addNewProvost($data){

        $p_id = $data['provost_id'];
        $p_name = $data['provost_name'];
        $hall_name = $data['hall_name'];
        $department = $data['department'];
        $designation = $data['designation'];
        $m_number = $data['m_number'];
        $email = $data['email'];
        $pass = $data['pass'];

        $sql = "INSERT INTO provost(provostId,provostName,hallName,Department,Designation,mobileNumber,email,PASS) VALUES(:p_id,:p_name,:hall_name,:department,:designation,:m_number,:email,:pass)";

        $sqll = "INSERT INTO users(id,email,password,user_role,status) VALUES(:u_id,:u_email,:u_pass,:usr_role,:stst)";

        $query = $this->db->pdo->prepare($sql);
        $queryy = $this->db->pdo->prepare($sqll);



        $query->bindValue(':p_id', $p_id);
        $query->bindValue(':p_name', $p_name);
        $query->bindValue(':hall_name', $hall_name);
        $query->bindValue(':department', $department);
        $query->bindValue(':designation', $designation);
        $query->bindValue(':m_number', $m_number);
        $query->bindValue(':email', $email);
        $query->bindValue(':pass', $pass);



        $queryy->bindValue(':u_id', $p_id);
        $queryy->bindValue(':u_email', $email);
        $queryy->bindValue(':u_pass', $pass);
        $queryy->bindValue(':usr_role', 2);
        $queryy->bindValue(':stst', 2);

        


        $result = $query->execute();
        $queryy->execute();

        if($result){
            $msz = "<div class='alert alert-success'><strong>Success</strong>New Provost Created</div>";
            return $msz;
        }else{
             $msz = "<div class='alert alert-success'><strong>Success</strong>! O-Ops</div>";
            return $msz;
        }


    }


    public function getAllProvost(){
        $sql = "SELECT * FROM provost";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function updateProvost($data)
    {
        $p_id = $data['uprovost_id'];
        $p_name = $data['uprovost_name'];
        $hall_name = $data['uhall_name'];
        $department = $data['udepartment'];
        $designation = $data['udesignation'];
        $m_number = $data['um_number'];
        $email = $data['uemail'];
        $sql = "UPDATE provost SET 
                        provostName = :p_name,
                        hallName = :hall_name,
                        Department = :department,
                        Designation = :designation,
                        mobileNumber = :m_number,
                        email = :email
                    WHERE provostId= :p_id";

        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':p_id', $p_id);
        $query->bindValue(':p_name', $p_name);
        $query->bindValue(':hall_name', $hall_name);
        $query->bindValue(':department', $department);
        $query->bindValue(':designation', $designation);
        $query->bindValue(':m_number', $m_number);
        $query->bindValue(':email', $email);

        $result = $query->execute();
        if ($result) {
            $msz = "<div class='alert alert-success'><strong>Success</strong> ! updated.</div>";
            return $msz;
        } else {
            $msz = "<div class='alert alert-danger'><strong>Error</strong> ! Deafult password not updated.</div>";
            return $msz;
        }

           
    }


    public function deleteProvost($data){
        $id = $data['id'];

        if ($id == "") {
            $msz = "<div class='alert alert-danger'>Invalid Id !</div>";
            return $msz;
        } else {
            $sql = "DELETE FROM provost WHERE provostId = :id";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':id', $id);
            $result = $query->execute();

            if ($result) {
                $msz = "<div class='alert alert-success'><strong>Success</strong> ! Provost Deleted.</div>";
                return $msz;
            } else {
                $msz = "<div class='alert alert-danger'><strong>Error</strong> ! Provost not Deleted.</div>";
                return $msz;
            }
        }
    }



    public function getRequest(){
        $sql = "SELECT * FROM hallRequest";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }
    public function getStudentSort(){
        $sql = "SELECT * FROM student WHERE hallStatus = :sta  ORDER BY total_credit DESC,CGPA  DESC";

        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':sta', 'pending');
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }




}





?>