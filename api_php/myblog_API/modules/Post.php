<?php


class Post
{

    //DB stuff
    private $conn;

    //Post Properties
    public $id;
    public $title;
    public $body;
    public $category_id;
    public $category_name;
    public $author;
    public $created_at;


    //constructor with DB
    public function __construct(PDO $connection = null)
    {
        $this->conn = $connection;
    }


    //Get function
    public function read(){
        //Create Query
        $query = "select c.name as category_name , p.title , p.id , p.category_id , 
                   p.author,p.body, p.created_at  from posts p
                  left join categories  c on p.category_id = c.id order by p.created_at desc ";

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //execute query
        $stmt->execute();

        return $stmt;
    }


    //Get single post function
    public function read_single(){
        //Create Query
        $query = "select c.name as category_name , p.title , p.id , p.category_id , 
                   p.author,p.body, p.created_at  from posts p
                  left join categories  c on p.category_id = c.id 
                  where p.id = ? LIMIT 0,1
                  ";

        //prepare statement
        $stmt = $this->conn->prepare($query);

        //Bind ID
        $stmt->bindParam(1 , $this->id);

        //Execute the query
        $stmt->execute();

        if($stmt->rowCount()<=0){
            return;
        }
        //Fetching the query
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        //setting the object attributes
        $this->title = $row['title'];
        $this->body = $row['body'];
        $this->category_id = $row["category_id"];
        $this->category_name = $row['category_name'];
        $this->author = $row['author'];
        $this->created_at = $row['created_at'];

    }

    //Create a New Post
    public function create(){

        //Create query
        $query = "insert into posts set  title = :title,
                      body= :body ,
                      author=:author,
                      category_id=:category_id";

        // Prepare statement
        $stmt =  $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id= htmlspecialchars(strip_tags($this->category_id));

        //Bind data
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id',$this->category_id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print Error if something goes wrong
        printf("Error %s .\n" , $stmt->errorCode());

        return false;
    }



    //Update post
    public function update(){
        //Create query
        $query = "UPDATE posts set  title = :title,
                      body= :body ,
                      author=:author,
                      category_id=:category_id 
                      where id = :id";

        // Prepare statement
        $stmt =  $this->conn->prepare($query);

        //Clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id= htmlspecialchars(strip_tags($this->category_id));
        $this->id= htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':title',$this->title);
        $stmt->bindParam(':body',$this->body);
        $stmt->bindParam(':author',$this->author);
        $stmt->bindParam(':category_id',$this->category_id);
        $stmt->bindParam(':id',$this->id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print Error if something goes wrong
        printf("Error %s .\n" , $stmt->errorCode());

        return false;
    }

    //Delete post
    public function delete(){
        //Create query
        $query = "DELETE FROM posts where id = :id";

        // Prepare statement
        $stmt =  $this->conn->prepare($query);

        //Clean data
        $this->id= htmlspecialchars(strip_tags($this->id));

        //Bind data
        $stmt->bindParam(':id',$this->id);

        //Execute query
        if($stmt->execute()){
            return true;
        }

        //Print Error if something goes wrong
        printf("Error %s .\n" , $stmt->errorCode());

        return false;
    }

}