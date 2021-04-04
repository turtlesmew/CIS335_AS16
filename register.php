<?php
// This code was adapted from: https://codeofaninja.com/2014/06/php-object-oriented-crud-example-oop.html
// include database and object files
include_once 'config/database.php';
include_once 'objects/persons.php';
  
// get database connection
$database = new Database();
$db = $database->getConnection();
  
// pass connection to objects
$person = new Person($db);
// set page headers
$page_title = "Register";
include_once "layouts/layout_header.php";
  
echo "<div class='right-button-margin'>
        <a href='login.php' class='btn btn-default pull-right'>Login</a>
    </div>";
  
?>
<?php 
// if the form was submitted - PHP OOP CRUD Tutorial
if($_POST){
    if(empty($_POST['email'])||empty($_POST['password'])||empty($_POST['valpassword'])||empty($_POST['fname'])||empty($_POST['lname'])){
        echo "<div class='alert alert-danger'>All fields are required</div>";
    }
    elseif(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $_POST['email'])){
        echo "<div class='alert alert-danger'>Invalid email address.</div>";
    }
    else {
        $uppercase = preg_match('@[A-Z]@', $_POST['password']);
        $lowercase = preg_match('@[a-z]@', $_POST['password']);
        $number = preg_match('@[0-9]@', $_POST['password']);
        $specialChars = preg_match('@[^\w]@', $_POST['password']);
        
        if($_POST['password'] <> $_POST['valpassword']){
            echo "<div class='alert alert-danger'>Passwords do not match.</div>";
        }
        else if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($_POST['password']) < 16) {
            echo "<div class='alert alert-danger'>Password should be at least 16 characters in length and should include at least one upper case letter, one number, and one special character.</div>";
        }

        else{
            $person->role = $_POST['role'];
            $person->fname = $_POST['fname'];
            $person->lname = $_POST['lname'];
            $person->email = $_POST['email'];
            $salt = MD5(microtime(true));
            $person->password_hash = MD5($_POST['password'] . $salt);
            $person->password_salt = $salt;
    
            //check that email does not already exist
            if($person->exists()){
                echo "<div class='alert alert-danger'> Email already exists </div>";
            }
            else{
                if($person->create()){
                    echo "<div class='alert alert-success'>Successfully Registered!</div>";
                }

                else{
                    echo "<div class='alert alert-danger'>Unable Register</div>";
                }
            }
        }
    }
}
?>
<!-- HTML form for adding a person -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">

  
    <table class='table table-hover table-responsive table-bordered'>
    
        <tr>
            <td>Role</td>
            <td><select name='role'>
                <option value='user' selected>User</option>
                </select>
            </td>
        </tr>

        <tr>
            <td>First Name</td>
            <td><input type='text' name='fname' class='form-control' placeholder='John' value='<?php if(isset($_POST["fname"])){echo $_POST["fname"];}?>'/></td>
        </tr>

        <tr>
            <td>Last Name</td>
            <td><input type='text' name='lname' class='form-control' placeholder='Doe' value='<?php if(isset($_POST["lname"])){echo $_POST["lname"];}?>'/></td>
        </tr>

        <tr>
            <td>Email</td>
            <td><input type='text' name='email' class='form-control' placeholder='JohnDoe@email.com' value='<?php if(isset($_POST["email"])){echo $_POST["email"];}?>'/></td>
        </tr>

        <tr>
            <td>Password</td>
            <td><input type='password' name='password' class='form-control' placeholder='password' value='<?php if(isset($_POST["password"])){echo $_POST["password"];}?>'/></td>
        </tr>

        <tr>
            <td>Confirm Password</td>
            <td><input type='password' name='valpassword' class='form-control' placeholder='confirm password' value='<?php if(isset($_POST["valpassword"])){echo $_POST["valpassword"];}?>'/></td>
        </tr>

        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Register</button>
            </td>
        </tr>
    </table>
</form>
<?php
  
// footer
include_once "layouts/layout_footer.php";
?>