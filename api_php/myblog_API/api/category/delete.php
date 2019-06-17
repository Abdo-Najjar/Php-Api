<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

//including database file and category module
require_once "../../config/DatabaseConnection.php";
require_once "../../modules/Category.php";



//check if the requested method is POST
if ($_SERVER['REQUEST_METHOD'] == "DELETE"):

    //Database connection "PDO instance"
    $connection = DatabaseConnection::get_instance()->getConnection();

    //Instantiate blog Category object
    $category = new Category($connection);

    //Get row Post data
    $data = json_decode(file_get_contents("php://input"));

    //set name attribute
    $category->id = $data->id;

    //create post
    if ($category->delete()) {

        echo json_encode(
            array("message" => "Category Deleted")
        );

    } else {

        echo json_encode(
            array("message" => "Category Not Deleted")
        );
    }

else:

    //Execute if the HTTP method is anything except POST  (GET , DELETE , PUT )
    echo json_encode(
        array("message" => "HTTP method is not suitable")
    );

endif;
