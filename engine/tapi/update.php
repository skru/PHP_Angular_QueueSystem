<!-- <?php 
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

  // Instantiate blog post object
  $ticket = new Ticket($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $ticket->id = $data->id;
  $ticket->tokenNumber = $data->tokenNumber;

  // $ticket->title = $data->title;
  // $ticket->body = $data->body;
  // $ticket->author = $data->author;
  // $ticket->category_id = $data->category_id;

  // Update post
  if($ticket->update()) {
    echo json_encode(
      array('message' => 'Ticket Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Ticket Not Updated')
    );
  }
 -->