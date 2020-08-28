<?php 
  class Payload {
    // DB stuff
    private $conn;
    private $table = 'payload';

    // Payload Properties
    public $id;
    public $text;
    public $ticketId;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get all Payloads
    public function read() {
      // Create query
      $query = 'SELECT *
        FROM ' . $this->table . ' 
        WHERE
         ticketId = ?
        ';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

       $stmt->bindParam(1, $this->ticketId);

      // Execute query
      $stmt->execute();

      return $stmt;
    }


    // Create Payload
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET text = :text, ticketId = :ticketId, signature = :signature'; //, 

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->text = htmlspecialchars(strip_tags($this->text));
      $this->ticketId = htmlspecialchars(strip_tags($this->ticketId));
      $this->signature = htmlspecialchars(strip_tags($this->signature));

      // Bind data
      //$stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':text', $this->text);
      $stmt->bindParam(':ticketId', $this->ticketId);
      $stmt->bindParam(':signature', $this->signature);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }    
  }