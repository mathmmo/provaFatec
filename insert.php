<?php 

    include('database_connection.php');

    $formData = json_decode(file_get_contents("php://input"));
    
    $error = '';
    $message = '';
    $validationError = '';
    $firstName = '';
    $lastName = '';

    if(empty($formData->firstName)){
        $error[] = 'Necessário informar primeiro nome';
    }else{
        $firstName = $formData->firstName;
    }
    if(empty($formData->lastName)){
        $error[] = 'Necessário informar ultimo nome';
    }else{
        $lastName = $formData->lastName;
    }

    if(empty($error)){
        if($formData->action == 'Inserir'){
            $data = array(
                ':firstName'     => $firstName,
                ':lastName'      => $lastName
            );
            $query = "INSERT INTO names (firstName, lastName) VALUES (:firstName, :lastName)";
            $statement = $connect->prepare($query);
            if($statement->execute($data)){
                $message = 'Registro inserido';
            }
        }
    }else{
        $validationError = implode(", ", $error);
    }

    $output = [
        'error'     => $validationError,
        'message'   => $message
    ];

    echo json_encode($output);

?>