<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

//including database file and post module
require_once "../../config/DatabaseConnection.php";
require_once "../../modules/Post.php";

if($_SERVER['REQUEST_METHOD'] == "PUT") {

//Database connection "PDO instance"
    $connection = DatabaseConnection::get_instance()->getConnection();

//Instantiate blog post object
    $post = new Post($connection);

//Get raw Updated data
    $data = json_decode(file_get_contents("php://input"));

//setting attribute
    $post->title = $data->title;
    $post->body = $data->body;
    $post->author = $data->author;
    $post->category_id = $data->category_id;
    $post->id = $data->id;


//Update post
    if ($post->update()):
        echo json_encode(array("message" => "Post Updated"));

    else:
        echo json_encode(array("message" => "Post Not Updated"));
    endif;

}//Execute if the HTTP method is anything except PUT  (GET , DELETE , POST )
echo json_encode(
    array("message"=>"HTTP method not suitable")
);