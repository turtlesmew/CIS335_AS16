<?php
// This code was adapted from: https://codeofaninja.com/2014/06/php-object-oriented-crud-example-oop.html
session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}
// check if value was posted
if($_POST){
  
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/persons.php';
  
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
  
    // prepare person object
    $person = new Person($db);
      
    // set person id to be deleted
    $person->id = $_POST['object_id'];
      
    // delete the person, IF ADMIN ONLY
    if($_SESSION['role'] <> 'admin' ){
        header("Location: index.php");
    }
    else{
        if($person->delete()){
            echo "Object was deleted.";
        }
          
        // if unable to delete the person
        else{
            echo "Unable to delete object.";
        }
    }
}
?>