<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../models/database.php';
  include_once '../models/ticket.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate ticket object
  $ticket = new Ticket($db);

  // Get raw data
  $data = json_decode(file_get_contents("php://input"));

  // // Set ID to update
  $ticket->id = $data->id;

  // Update ticket
  if($ticket->ticket_no_show()) {
    echo json_encode(
      array('message' => 'Ticket No Show')
    );
  } else {
    echo json_encode(
      array('message' => 'Ticket Not No Show')
    );
  }
