<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


class Database{


    private $dsn = 'mysql:dbname=sakila;host=127.0.0.1;port=3306;';
    private $user = 'root';
    private $password = '1234';
	private $db;	
	
public function connectdb(){
        $con = new PDO($this->dsn, $this->user, $this->password);
		
		if($con){
			$this->db=$con;
            echo "connected to database!\n";
		}else{
            echo "sorry, failed! try again";
        }
}
public function select(){

        $query = "SELECT * FROM students";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
		return $rows;

}
public function insert($name, $email, $password, $image){
        $query = "insert into students(`username`, `email`, `password`, `image`) values(:username, :email, :password, :image)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":username",$name);
        $stmt->bindParam("email",$email);
        $stmt->bindParam("password",$password);
        $stmt->bindParam("image",$image);
        $res = $stmt->execute();
        if($res){
            echo "row inserted!";
        }else{
            echo "can't insert row!";
        }

}
public function delete($ID){
        $query = 'delete from students where `ID` = :ID';
        $stmt = $this->db->prepare ($query);
        $stmt->bindParam(":ID", $ID);
        $res=$stmt->execute ();
        if($res){
            echo "row deleted!";
        }else{
            echo "can't delete row!";
        }
}
public function update($ID, $name, $email, $password, $image){
    $update_query = 'UPDATE students SET `name`= :name, `email`= :email , `password` = :password, `image` = :image WHERE `ID` = :ID';
    $update_stmt= $this->db->prepare($update_query);
    $update_stmt->bindParam(':ID', $ID);
    $update_stmt->bindParam(':name', $name);
    $update_stmt->bindParam(':email', $email);
    $update_stmt->bindParam(':password', $password);
    $update_stmt->bindParam(':image', $image);
    $res = $update_stmt->execute();
    if($res){
        echo "row updated!";
    }else{
        echo "can't update row!";
    }

}

}

$dbcon= new Database();
$dbcon->connectdb();
$data=$dbcon->select();
foreach($data as $d){
    echo "name:".$d->name.", email:".$d->email.".\n";
}


?>