<?php
// This code was adapted from: https://codeofaninja.com/2014/06/php-object-oriented-crud-example-oop.html
// with some ideas taken from files on canvas
session_start();

// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$person = new Person($db);
// set page headers
$page_title = "Login";
include_once "layouts/layout_header.php";
echo "<div class='input-group col-md-3 pull-left margin-right-1em'>
    <a href='#' class='btn btn-default pull-left'>Github Source Code</a>
    </div>";

echo "<div class='right-button-margin'>
        <a href='register.php' class='btn btn-default pull-right'>Register</a>
    </div>";
?>
<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
    if(empty($_POST['email'])||empty($_POST['password'])){
        echo "<div class='alert alert-danger'>Email and password are required</div>";
    }
    elseif(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $_POST['email'])){
        echo "<div class='alert alert-danger'>Invalid email address.</div>";
    }
    else {
        // set person values
        $person->email = $_POST['email'];
        $password = $_POST['password'];
        if($person->login($password)){
            $_SESSION['email'] = $person->email;
            $_SESSION['role'] = $person->getRole();
            header('Location:index.php');
        }
        else{
            echo "<div class='alert alert-danger'>Invalid email or password</div>";
        }
    }
}
?>
<!-- HTML form for adding a person -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">

  
    <table class='table table-hover table-responsive table-bordered'>
        <tr>
            <td>Email</td>
            <td><input type='text' name='email' class='form-control' placeholder='example@domain.com' value='<?php if(isset($_POST["email"])){echo $_POST["email"];}?>'/></td>
        </tr>

        <tr>
            <td>Password</td>
            <td><input type='password' name='password' class='form-control' placeholder='password'/></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Login</button>
            </td>
        </tr>
    </table>
</form>
<?php
  
// footer
include_once "layouts/layout_footer.php";
?>