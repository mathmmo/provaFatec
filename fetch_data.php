<?php

include('database_connection.php');

$query = "SELECT * FROM roteiro ORDER BY id";

$statement = $connect->prepare($query);

if($statement->execute()){
    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
    //Return of data
    echo json_encode($data);
}

?>