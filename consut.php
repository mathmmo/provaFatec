<?php 

include('database_connection.php');

$formData = json_decode(file_get_contents("php://input"));

$error = [];
$message = '';
$validationError = '';
$firstName = '';
$lastName = '';


if(empty($formData->firstName)){
    $error[] = 'Necessario informar primeiro nome';
}else{
    $firstName = $formData->firstName;
}
if(empty($formData->lastName)){
    $error[] = 'Necessario informar ultimo nome';
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
    if($formData->action == "Alterar"){
        $data = array (
            ':firstName'     => $firstName,
            ':lastName'      => $lastName,
            ':id'            => $formData->id
        );
        $query = "UPDATE names SET firstName = :firstName, lastName = :lastName WHERE id = :id";
        $statement = $connect->prepare($query);
        if($statement->execute($data)){
            $message = 'Registro alterado';
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