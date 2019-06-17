<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


//including database file and category module
require_once "../../config/DatabaseConnection.php";
require_once "../../modules/Category.php";

//check if the requested method is POST
if($_SERVER['REQUEST_METHOD']=="GET"):

    //Database connection "PDO instance"
    $connection = DatabaseConnection::get_instance()->getConnection();

    //Instantiate blog Category object
    $category = new Category($connection);

    //Blog Categories query
    $stmt = $category->read();

    //Rows count
    $num = $stmt->rowCount();

    //check if there is any Categories in result from query
    if($num > 0){
        //array of the categories
        $category_arr= array();

        //create data section
        $category_arr['data'] = array();

        //fetch the rows
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            //Instantiate blog Category object
            $category = new Category();
            //set the attribute
            $category->id = $row['id'];
            $category->name = $row['name'];
            $category->created_at = $row['created_at'];
            array_push($category_arr['data'] , $category);
        }

        echo json_encode($category_arr);

    }else{
        echo json_encode(
            array("message"=>"No Category")
        );
    }

else:

    //Execute if the HTTP method is anything except GET  (POST , DELETE , PUT )
    echo json_encode(
        array("message"=>"HTTP method is not suitable")
    );

endif;
