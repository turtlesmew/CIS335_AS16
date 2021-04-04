<?php
    // This code was adapted from: https://codeofaninja.com/2014/06/php-object-oriented-crud-example-oop.html
    
    // core.php holds pagination variables
    include_once 'config/core.php';

    //database.php specifies Database class
    include_once 'config/database.php';

    //persons.php specifies Person class
    include_once 'objects/persons.php';

    //instantiate Database class and connect
    $database = new Database();
    $db = $database->getConnection();

    //instantiate Person class
    $person = new Person($db);

    $page_title = "Persons List";
    include_once "layouts/layout_header.php";

    //query records from SQL table
    $stmt = $person->readAll($from_record_num, $records_per_page);

    // specify the page where paging is used
    $page_url = "index.php?";

    // count total rows - used for pagination
    $total_rows=$person->countAll();   

    // read_template.php controls how the product list will be rendered
    include_once "read_template.php";
    
    // layout_footer.php holds our javascript and closing html tags
    include_once "layouts/layout_footer.php";
?>