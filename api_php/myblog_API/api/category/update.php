<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


//including database file and category module
require_once "../../config/DatabaseConnection.php";
require_once "../../modules/Category.php";

//check if the requested method is POST
if($_SERVER['REQUEST_METHOD']=="PUT"):

    //Database connection "PDO instance"
    $connection = DatabaseConnection::get_instance()->getConnection();

    //Instantiate blog Category object
    $category = new Category($connection);

    //Get row Post data
    $data = json_decode(file_get_contents("php://input"));

    //set name attribute
    $category->id = $data->id;
    $category->name = $data->name;

    //Update post
    if($category->update()){

        echo json_encode(
            array("message"=>"Category Updated")
        );

    }else{

        echo json_encode(
            array("message"=>"Category Not Updated")
        );
    }

else:

    //Execute if the HTTP method is anything except PUT  (GET , DELETE , POST )
    echo json_encode(
        array("message"=>"HTTP method is not suitable")
    );

endif;
