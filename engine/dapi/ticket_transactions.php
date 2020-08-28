<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../models/database.php';
  include_once '../models/transaction.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate payload object
  $transaction = new Transaction($db);


  // Get ID
  $transaction->ticketId = isset($_GET['ticketId']) ? $_GET['ticketId'] : die();

  $result = $transaction->read();
  $num = $result->rowCount();

  // Check if any payloads
  if($num > 0) {
    // Payload array
    $transaction_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $transaction_item = array(
        'id' => $id,
        'ticketId' => $ticketId,
      );

      // Push to "data"
      array_push($transaction_arr, $transaction_item);
    }

    // Turn to JSON & output
    echo json_encode($transaction_arr);

  } else {
    // No Payloads
    echo json_encode(
      array('message' => 'No transactions Found')
    );
  }