<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../models/database.php';
  include_once '../models/payload.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate payload object
  $payload = new Payload($db);


  // Get ID
  $payload->ticketId = isset($_GET['ticketId']) ? $_GET['ticketId'] : die();

  $result = $payload->read();
  $num = $result->rowCount();

  // Check if any payloads
  if($num > 0) {
    // Payload array
    $payload_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $payload_item = array(
        'id' => $id,
        'text' => $text,
        'ticketId' => $ticketId,
        'signature' => $signature,
      );

      // Push to "data"
      array_push($payload_arr, $payload_item);
    }

    // Turn to JSON & output
    echo json_encode($payload_arr);

  } else {
    // No Payloads
    echo json_encode(
      array('message' => 'No Payloads Found')
    );
  }