<?php
// This code was adapted from: https://codeofaninja.com/2014/06/php-object-oriented-crud-example-oop.html
session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
}
// get ID of the person to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');


// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// prepare objects
$person = new Person($db);
  
// set ID property of person to be edited
$person->id = $id;

//if the role is user, checks to see if the user is trying to update it's own record
if($_SESSION['role'] == 'user') {
    if($person->getEmail() <> $_SESSION['email']){
        header("Location: index.php");
    }
}

// read the details of person to be edited
$person->readOne();
  
// set page header
$page_title = "Update person";
include_once "layouts/layout_header.php";
  
echo "<div class='right-button-margin'>
          <a href='index.php' class='btn btn-default pull-right'>Read persons</a>
     </div>";
  
?>
<?php 
// if the form was submitted
if($_POST){
    // set person property values
    $person->role = $_POST['role'];
    $person->fname = $_POST['fname'];
    $person->lname = $_POST['lname'];
    $person->phone = $_POST['phone'];
    $person->address = $_POST['address'];
    $person->address2 = $_POST['address2'];
    $person->city = $_POST['city'];
    $person->state = $_POST['state'];
    $person->zip_code = $_POST['zip_code'];
  
    // update the person
    if($person->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "Person was updated.";
        echo "</div>";
    }
  
    // if unable to update the person, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update person.";
        echo "</div>";
    }
}
?>
  
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">

  
    <table class='table table-hover table-responsive table-bordered'>

        <tr>
            <td>Role</td>
            <td><select name='role'>
                <option value='user'>User</option>
                <?php if($_SESSION['role'] == 'admin') echo"<option value='admin'>Admin</option>"?>
                </select>
            </td>
        </tr>

        <tr>
            <td>First Name</td>
            <td><input type='text' name='fname' class='form-control' placeholder='John' value='<?php echo $person->fname; ?>'/></td>
        </tr>

        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lname' class='form-control' placeholder='Doe' value='<?php echo $person->lname; ?>'/></td>
        </tr>

        <tr>
            <td>Phone</td>
            <td><input type='tel' name='phone' class='form-control' placeholder='3036737892' value='<?php echo $person->phone; ?>' maxlength='10'/></td>
        </tr>
        
        <tr>
            <td>Address</td>
            <td><input type='text' name='address' class='form-control' placeholder='123 Elm Drive' value='<?php echo $person->address; ?>'/></td>
        </tr>

        <tr>
            <td>Address2</td>
            <td><input type='text' name='address2' class='form-control' value='<?php echo $person->address2; ?>'/></td>
        </tr>

        <tr>
            <td>City</td>
            <td><input type='text' name='city' class='form-control' placeholder='Saginaw' value='<?php echo $person->city; ?>'/></td>
        </tr>

        <tr>
            <td>State</td>
            <td><input type='text' name='state' class='form-control' placeholder='MI' value='<?php echo $person->state; ?>' maxlength='2'/></td>
        </tr>

        <tr>
            <td>Zip Code</td>
            <td><input type='number' name='zip_code' class='form-control' placeholder='48604' value='<?php echo $person->zip_code; ?>'/></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
    </table>
</form>
<?php
    //set page footer
    include_once "layouts/layout_footer.php";
?>