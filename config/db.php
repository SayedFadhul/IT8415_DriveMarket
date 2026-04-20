<?php

function getConnection()
{
    //change the user to "root" , password to "" and can be "drivemarket_db" if it was XAMPP / local PC. 
    
    $host = "localhost";
    $user = "u202301830";        
    $password = "asdASD123!";        
    $database = "db202301830";

    $dbc = mysqli_connect($host, $user, $password, $database);

    if (mysqli_connect_errno()) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    return $dbc;
}

?>