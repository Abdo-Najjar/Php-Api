<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

//including database file and post module
require_once "../../config/DatabaseConnection.php";
require_once "../../modules/Post.php";

//check if the HTTP method is get or head
if($_SERVER['REQUEST_METHOD'] == "GET" ||$_SERVER['REQUEST_METHOD']=="HEAD"):


    //Database connection "PDO instance"
    $connection = DatabaseConnection::get_instance()->getConnection();

    //Instantiate blog post object
    $post = new Post($connection);

    //Get ID
    $post->id = isset($_GET['id'])? $_GET['id'] : die("");

    //Get post
    $post->read_single();


    //Make json
    echo json_encode($post);



else:

    //Execute if the HTTP method is anything except GET (POST , DELETE , PUT )
    echo json_encode(
        array("message"=>"HTTP method not suitable")
    );

endif;
