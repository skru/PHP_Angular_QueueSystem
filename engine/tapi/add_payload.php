<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../models/database.php';
  include_once '../models/payload.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate payload object
  $payload = new Payload($db);

  // Get raw data
  $data = json_decode(file_get_contents("php://input"));

  $payload->text = $data->text;
  $payload->ticketId = $data->ticketId;
  $payload->signature = $data->signature;

  // Create ticket
  if($payload->create()) {
    echo json_encode(
      array('message' => 'Payload Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Payload Not Created')
    );
  }
