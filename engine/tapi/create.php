<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../models/database.php';
  include_once '../models/ticket.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate ticket object
  $ticket = new Ticket($db);

  // Get raw data
  //$data = json_decode(file_get_contents("php://input"));


  //  $x = 'AA998';
  // for($i = 0; $i < 10; $i++) {
  //     echo $x++,'<br />';
  // }



  //$ticket->tokenNumber = $data->tokenNumber;
  $ticket->called = false;
  $ticket->served = false;
  $ticket->noShow = false;

  // Create ticket
  // if($ticket->create()) {
  //   echo json_encode(
  //     array('message' => 'Ticket Created')
  //   );
  // } else {
  //   echo json_encode(
  //     array('message' => 'Ticket Not Created')
  //   );
  // }
  $ticket->create();

  $ticket_arr = array(
    'id' => $ticket->id,
    'tokenNumber' => $ticket->tokenNumber,
    'called' => $ticket->called,
    'served' => $ticket->served,
    'noShow' => $ticket->noShow,
  );

  // Make JSON
  print_r(json_encode($ticket_arr));
