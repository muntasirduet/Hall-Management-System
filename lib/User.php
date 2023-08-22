

<?php

	include_once 'Session.php';
	include 'Database.php';
	



class User{
	private $db;
	public function __construct() {
        $this->db = new Database();    
    }

    public function userRegistration($data) {
        $firstname 		= $data['firstname'];
        $lastname  		= $data['lastname'];
        $father_name	= $data['father_name'];
        $mother_name	= $data['mother_name'];
        $student_id		= (int)$data['student_id'];
        $running_year	= $data['running_year'];
        $semister		= $data['semister'];
        $department		= $data['department'];
        $blood_group	= $data['blood_group'];
        $NID			= (int)$data['NID'];
        $CGPA			= $data['CGPA'];
        $total_credit	= $data['total_credit'];
        $phone_number	= $data['phone_number'];
        $email     		= $data['email'];
        $address		= $data['address'];

        $password 		= $data['password'];
        $passck			= $data['password_check'];



        if ($firstname == "" || $lastname == "" || $father_name == "" || $mother_name == "" || $student_id == "" || $running_year == "" || $semister == "" || $department == "" || $blood_group == "" || $NID == "" || $CGPA == "" || $total_credit == "" || $phone_number == "" || $email == "" || $password == "") {

            $msz = "<div class='alert alert-danger'>Field must not be empty !</div>";
            return $msz;

        } 
        else if($password !== $passck){
        	$msz = "<div class='alert alert-danger'>Confirm password does not match !</div>";
            return $msz;
        }
       
        else {
        	$sqll = "INSERT INTO users(id,email,password,user_role,status) VALUES(:id,:email,:password,:user_role,:status)";
            $sql = "INSERT INTO student(student_id, firstname, lastname, email, phone_number, father_name,mother_name,running_year,semister,department,NID,blood_group,CGPA,total_credit,address,status,user_role,reg_date,password) VALUES(:student_id, :firstname, :lastname, :email, :phone_number, :father_name,:mother_name, :running_year, :semister, :department, :NID, :blood_group,:CGPA, :total_credit, :address, :status, :user_role,:reg_date,:password)";
            $query = $this->db->pdo->prepare($sql);
            $queryy = $this->db->pdo->prepare($sqll);

            $query->bindValue(':student_id', $student_id);
            $query->bindValue(':firstname', $firstname);
            $query->bindValue(':lastname', $lastname);
            $query->bindValue(':email', $email);
            $query->bindValue(':phone_number', $phone_number);
            $query->bindValue(':father_name', $father_name);
            $query->bindValue(':mother_name', $mother_name);
            $query->bindValue(':running_year', $running_year);
            $query->bindValue(':semister', $semister);
            $query->bindValue(':department', $department);
            $query->bindValue(':NID', $NID);
            $query->bindValue(':blood_group', $blood_group);
            $query->bindValue(':CGPA', $CGPA);
            $query->bindValue(':total_credit', $total_credit);
            $query->bindValue(':address', $address);
            $query->bindValue(':status', 1);
            $query->bindValue(':user_role', 3);
            $query->bindValue(':reg_date', date("Y/m/d"));
            $query->bindValue(':password', $password);

            $queryy->bindValue(':id', $student_id);
            $queryy->bindValue(':email', $email);
            $queryy->bindValue(':user_role', 3);
            $queryy->bindValue(':password', $password);
            $queryy->bindValue(':status', 1);

            $result = $query->execute();
            $res = $queryy->execute();
            if($res){
            	$msz = "<div class='alert alert-success'><strong>Success</strong> ! New user have been registered.</div>";
                return $msz;
            }
            if ($result) {
                $msz = "<div class='alert alert-success'><strong>Success</strong> ! New user have been registered.</div>";
                return $msz;
            } else {
                $msz = "<div class='alert alert-danger'><strong>Error</strong> ! New user have not been registered.</div>";
                return $msz;
            }
        }
	}

	public function getLoginUser($email, $pass) {
        $sql = "SELECT * FROM users WHERE email = :email AND password = :pass LIMIT 1";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':email', $email);
        $query->bindValue(':pass', $pass);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if ($result->status === 0) {
            return false;
        } else {
            return $result;
        }
    }

	public function userAuthentication($data) {
        $email     = $data['email'];
        $pass      = $data['password'];

        if ($email == "" || $pass == "") {
            $msz = "<div class='alert alert-danger'>Field must not be empty !</div>";
            return $msz;
        }

        $result = $this->getLoginUser($email, $pass);


       


        

        if ($result) {
            Session::init();
            Session::set("login", true);
            Session::set("id", $result->id);
            Session::set("email", $result->email);
            Session::set("user_role", $result->user_role);
            Session::set("login_status", $result->status);
            
            Session::set("loginmsz", "<div class='alert alert-success'>You are loged in!</div>");

            
             
            

            if($result->status == 1){
                $msz = "<div class='alert alert-warning'>User Request Is being pending</div>";
                return $msz;
            }else{
                echo "<script>window.location.href='admin.php';</script>";
            }

            

        } else {
            $msz = "<div class='alert alert-danger'>Sign in failed !</div>";
            return $msz;
        }
      
    }


     public function getAllStudent(){
        $sql = "SELECT * FROM student";
        $query = $this->db->pdo->prepare($sql);
        $query->execute();
        $result = $query->fetchAll();
        return $result;
    }

    public function getStudentById($id)
    {   
        $sql = "SELECT * FROM student WHERE student_id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $id);
        $query->execute();
        $result = $query->fetch();

        return $result;
    }

    public function setStudentStatus($data){
        $sql = "UPDATE student SET status = :statu WHERE student_id = :student_id";
        $sqll = "UPDATE users SET status = :stat WHERE id = :id";

        $query = $this->db->pdo->prepare($sql);
        $queryy = $this->db->pdo->prepare($sqll);


        $query->bindValue(':statu', 2);
        $query->bindValue(':student_id', (int)$data['s_id']);

        $queryy->bindValue(':stat', 2);
        $queryy->bindValue(':id', (int)$data['s_id']);

        $query->execute();
        $queryy->execute();
        $result = $query->fetch();
        $msz = "<div class='alert alert-success'><strong>Success</strong>Student request Accepted</div>";
        return $msg;
    }




    public function getHallRequestById($data){
        $sql = "SELECT * FROM hallRequest WHERE studentID = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $data);
        $query->execute();
        $result = $query->fetch();
        return $result;
    }

    public function getSeat($data){
        $sql = "SELECT * FROM hall WHERE hallName = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $data);
        $query->execute();
        $result = $query->fetch();
        Session::set("c_seat",$result['currentSeat']);

        return $result;
    }


    public function setStudentHallStatus($data){
        $name     = $data['hall_name'];
        $id       = $data['std_id'];

        $getS = Session::get('c_seat');
        $getS = (int)$getS+1;
        



        $sqlll = "UPDATE student SET hallStatus = :statu WHERE student_id = :student_id";
        $sqll = "UPDATE hallRequest SET status = :stat WHERE studentID = :stdid";
        $sql = "INSERT INTO uniqueHall(student_id,hallName,status) VALUES(:id,:hallname,:sta)";

        $hall  = "UPDATE hall SET currentSeat = :seat WHERE hallName = :halname";

        $query = $this->db->pdo->prepare($sql);
        $queryy = $this->db->pdo->prepare($sqll);
        $queryyy = $this->db->pdo->prepare($sqlll);

        $hallq = $this->db->pdo->prepare($hall);

        $hallq->bindValue(':seat', $getS);
        $hallq->bindValue(':halname', $name);


        $query->bindValue(':id', $id);
        $query->bindValue(':hallname', $name);
        $query->bindValue(':sta', 'pending');

        $queryy->bindValue(':stdid', $id);
        $queryy->bindValue(':stat', 'Accepted');

        $queryyy->bindValue(':student_id', $id);
        $queryyy->bindValue(':statu', 'Accepted');
        
        $result = $query->execute();
        $queryy->execute();
        $queryyy->execute();
        $hallq->execute();

         if ($result) {
            $msz = "<div class='alert alert-success'><strong>Success </strong> ! hall added.</div>";
            return $msz;
        } else {
            $msz = "<div class='alert alert-danger'><strong>Error</strong></div>";
            return $msz;
        }




    }

    public function getRoomById($data){
        $sql = "SELECT * FROM selectRoom WHERE student_id = :id";
        $query = $this->db->pdo->prepare($sql);
        $query->bindValue(':id', $data);
        $query->execute();
        $result = $query->fetch();
        return $result;
    }



}





?>