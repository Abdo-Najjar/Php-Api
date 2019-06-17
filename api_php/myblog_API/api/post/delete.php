<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

//including database file and post module
require_once "../../config/DatabaseConnection.php";
require_once "../../modules/Post.php";

if($_SERVER['REQUEST_METHOD'] == "DELETE") {

//Database connection "PDO instance"
    $connection = DatabaseConnection::get_instance()->getConnection();

//Instantiate blog post object
    $post = new Post($connection);

//Get raw Deleted data
    $data = json_decode(file_get_contents("php://input"));

//setting attribute
    $post->id = $data->id;


//Delete post
    if ($post->delete()):
        echo json_encode(array("message" => "Post Deleted"));

    else:
        echo json_encode(array("message" => "Post Not Deleted"));
    endif;

}else{

    //Execute if the HTTP method is anything except POST  (GET , DELETE , PUT )
    echo json_encode(
        array("message"=>"HTTP method not suitable")
    );
}