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
  $result = $ticket->read_issued_count();
  // Get row count
  $num = $result->rowCount();
  echo json_encode(array('count' => $num));