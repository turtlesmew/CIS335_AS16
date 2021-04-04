<?php
// This code was adapted from: https://codeofaninja.com/2014/06/php-object-oriented-crud-example-oop.html
session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}
// get ID of the person to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
  
// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$person = new Person($db);
  
// set ID property of person to be read
$person->id = $id;
  
// read the details of person to be read
$person->readOne();
// set page headers
$page_title = "List one Person";
include_once "layouts/layout_header.php";
  
// list button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Back to list";
    echo "</a>";
echo "</div>";
// HTML table for displaying a person details
echo "<table class='table table-hover table-responsive table-bordered'>";

    echo "<tr>";
        echo "<td>Role</td>";
        echo "<td>{$person->role}</td>";
    echo "</tr>";

    echo "<tr>";
        echo "<td>Name</td>";
        echo "<td>{$person->fname} {$person->lname}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>Email</td>";
        echo "<td>{$person->email}</td>";
    echo "</tr>";

    if($person->phone){
        echo "<tr>";
            echo "<td>Phone</td>";
            echo "<td>{$person->phone}</td>";
        echo "</tr>";
    }

    if($person->address){
        echo "<tr>";
            echo "<td>Address</td>";
            echo "<td>{$person->address} {$person->address2} {$person->city}, {$person->state} {$person->zip_code}</td>";
        echo "</tr>";
    }

echo "</table>";
// set footer
include_once "layouts/layout_footer.php";
?>