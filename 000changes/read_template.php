<?php
// This code was adapted from: https://codeofaninja.com/2014/06/php-object-oriented-crud-example-oop.html
//logout button
echo "<div class='left-button-margin'>";
    echo "<a href='logout.php' class='btn btn-primary pull-left'>Logout</a>";
echo "</div>";
// create person button
echo "<div class='right-button-margin'>";
    echo "<a href='create_person.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-plus'></span> Add Person";
    echo "</a>";
echo "</div>";

// display people if there are any
if($total_rows>0){
  
    echo "<table class='table table-hover table-responsive table-bordered'>";
        echo "<tr>";
            echo "<th>Last Name</th>";
            echo "<th>First Name</th>";
            echo "<th>Email</th>";
            echo "<th>Role</th>";
            echo "<th>Actions</th>";
        echo "</tr>";
  
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
  
            extract($row);
  
            echo "<tr>";
                echo "<td>{$lname}</td>";
                echo "<td>{$fname}</td>";
                echo "<td>{$email}</td>";
                echo "<td>{$role}</td>";
  
                echo "<td>";
  
                    // read button
                    echo "<a href='read_one.php?id={$id}' class='btn btn-primary left-margin'>";
                        echo "<span class='glyphicon glyphicon-list'></span> Read";
                    echo "</a>";
  
                    // edit button
                    echo "<a href='update_person.php?id={$id}' class='btn btn-info left-margin'>";
                        echo "<span class='glyphicon glyphicon-edit'></span> Edit";
                    echo "</a>";
  
                    // delete button
                    echo "<a delete-id='{$id}' delete-name='{$fname} {$lname}' class='btn btn-danger delete-object'>";
                        echo "<span class='glyphicon glyphicon-remove'></span> Delete";
                    echo "</a>";
  
                echo "</td>";
  
            echo "</tr>";
  
        }
  
    echo "</table>";
  
    // paging buttons
    include_once 'config/paging.php';
}
  
// tell the user there are no people
else{
    echo "<div class='alert alert-danger'>No persons found.</div>";
}
?>
