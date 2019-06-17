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

    // Blog post query
    $result = $post->read();

    //Get row count
    $num = $result->rowCount();

    // check if any posts
    if($num > 0){

        //post array
    $post_arr = array();
    $post_arr['data'] = array();


        while ($row = $result->fetch(PDO::FETCH_ASSOC)){

            //creating a post object
            $post_item = new Post();

            //setting up the values of the object post
            $post_item->id = $row['id'];
            $post_item->title = $row['title'];
            $post_item->body = html_entity_decode($row['body']);
            $post_item->category_id = $row['category_id'];
            $post_item->category_name = $row['category_name'];
            $post_item->author = $row['author'];
            $post_item->created_at = $row['created_at'];

                //Post to data
            array_push($post_arr['data'] , $post_item);
        }

        //sending data as json
     echo json_encode($post_arr);


    }else{
        //if the post entry is empty
        echo json_encode(
            array("message"=>"No posts found")
        );
    }

    else:

        //Execute if the HTTP method is anything except GET (POST , DELETE , PUT )
        echo json_encode(
            array("message"=>"HTTP method not suitable")
        );

endif;
