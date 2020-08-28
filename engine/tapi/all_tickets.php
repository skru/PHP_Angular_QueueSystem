<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../models/database.php';
  include_once '../models/ticket.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate ticket object
  $ticket = new Ticket($db);

  $ticket->issuedTime = isset($_GET['date']) ? $_GET['date'] : die();

  // Ticket query
  $result = $ticket->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any tickets
  if($num > 0) {
    // Ticket array
    $tickets_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $ticket_item = array(
        'id' => $id,
        'tokenNumber' => $tokenNumber,
        'called' => $called,
        'served' => $served,
        'noShow' => $noShow,
      );

      // Push to "data"
      array_push($tickets_arr, $ticket_item);
    }

    // Turn to JSON & output
    echo json_encode($tickets_arr);

  } else {
    // No tickets
    echo json_encode(
      array('message' => 'No Tickets Found')
    );
  }