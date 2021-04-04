<?php
// This code was adapted from: https://codeofaninja.com/2014/06/php-object-oriented-crud-example-oop.html
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1; 
  
// set number of records per page
$records_per_page = 5;
  
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
?>