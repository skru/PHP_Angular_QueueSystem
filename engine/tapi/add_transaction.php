<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../models/database.php';
  include_once '../models/transaction.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate payload object
  $transaction = new Transaction($db);

  // Get raw data
  $data = json_decode(file_get_contents("php://input"));

  $transaction->text = $data->text;
  $transaction->ticketId = $data->ticketId;

  // Create ticket
  if($transaction->create()) {
    echo json_encode(
      array('message' => 'Transaction Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Transaction Not Created')
    );
  }
