<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


//including database file and category module
require_once "../../config/DatabaseConnection.php";
require_once "../../modules/Category.php";

//check if the requested method is POST
if($_SERVER['REQUEST_METHOD']=="GET"):

    //check if ID isset
    if(isset($_GET['id'])):

    //Database connection "PDO instance"
    $connection = DatabaseConnection::get_instance()->getConnection();

    //Instantiate blog Category object
    $category = new Category($connection);

    //Instantiate ID in Blog Category
    $category->id = $_GET['id'];

    //Blog Category query Get Category
    $stmt = $category->read_single();

    //Fetch raws
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //Set attributes
    $category->name = $row['name'];
    $category->created_at = $row['created_at'];


    //Make json
    echo json_encode($category);


    else:
        //Die if the ID is not set in the HTTP GET request
        die();

    endif;

else:

    //Execute if the HTTP method is anything except GET  (POST , DELETE , PUT )
    echo json_encode(
        array("message"=>"HTTP method is not suitable")
    );

endif;
