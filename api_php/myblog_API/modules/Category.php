<?php


class Category
{

    //DB stuff
    private $conn;

    //Post Properties
    public $id;
    public $name;
    public $created_at;

    //constructor with DB
    public function __construct(PDO $connection=null)
    {
        $this->conn = $connection;
    }


    //Get all Categories
    public function read(){
        //Create query
        $query = "Select id , name , created_at from categories order by created_at desc ";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Execute query
        $stmt->execute();

        return $stmt;
    }


    //Get  Category
    public function read_single(){
        //Create query
        $query = "Select id , name , created_at from categories where id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(":id" , $this->id);

        //Execute query
        $stmt->execute();

        return $stmt;
    }


    //Create Category
    public function create(){
        //Create query
        $query = "insert into categories set name = :name";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(":name" , $this->name);

        //Execute query
        if($stmt->execute()){
            return true;
        }else{
            //Print Error if something goes wrong
            printf("Error: %s .\n",$stmt->errorCode());
            return false;
        }

    }


    //Update Category
    public function update(){
        //Create query
        $query = "update  categories set name = :name where id = :id";


        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind attributes
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":id",$this->id);


        //Execute query
        if($stmt->execute()){
            return true;
        }else{
            //Print Error if something goes wrong
            printf("Error: %s .\n",$stmt->errorCode());
            return false;
        }
    }

    //Delete Category
    public function delete(){
        //Create query
        $query = "delete from categories where  id = :id";

        //Prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(":id" , $this->id);


        //Execute query
        if($stmt->execute()){
            return true;
        }else{
            //Print Error if something goes wrong
            printf("Error: %s .\n",$stmt->errorCode());
            return false;
        }
    }
}