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

  // Get ID
  $ticket->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get ticket
  $ticket->read_single();

  // Create array
  $ticket_arr = array(
    'id' => $ticket->id,
    'tokenNumber' => $ticket->tokenNumber,
    'called' => $ticket->called,
    'served' => $ticket->served,
    'noShow' => $ticket->noShow,
  );

  // Make JSON
  print_r(json_encode($ticket_arr));