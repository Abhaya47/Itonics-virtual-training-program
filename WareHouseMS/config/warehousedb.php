<?php

 $db_server="localhost";
 $db_user="root";
 $db_name="warehouse";
 $db_pass="";
 $connection_string="";  
 $connection_string=mysqli_connect($db_server,$db_user,$db_pass,$db_name);

 if(!$connection_string){
    echo"Connection Failed: ".mysqli_connect_error();
 }



//  try { 
//      $connection_string=mysqli_connect($db_server,$db_user,$db_pass,$db_name);
//  }
//  catch(mysqli_sql_exception $e) {
//     echo"Connection Failed :" .$e;
//  }

 
 

 

    



?>