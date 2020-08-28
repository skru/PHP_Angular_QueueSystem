<?php 
  class Transaction {
    // DB stuff
    private $conn;
    private $table = 'transaction';

    // Transaction Properties
    public $id;
    public $ticketId;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get all Transactions
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

    // //Get Single Transaction
    // public function read_single() {
    //   // Create query
    //   $query = 'SELECT *
    //     FROM ' . $this->table . '
    //     WHERE
    //       id = ?
    //     LIMIT 0,1';                    

    //   // Prepare statement
    //   $stmt = $this->conn->prepare($query);

    //   // Bind ID
    //   $stmt->bindParam(1, $this->id);

    //   // Execute query
    //   $stmt->execute();

    //   $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //   // Set properties
    //   $this->id = $row['id'];
    //   $this->text = $row['text'];
    //   $this->ticketId = $row['ticketId'];
    // }

    // Create Transaction
    public function create() {
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET ticketId = :ticketId'; //, 

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->ticketId = htmlspecialchars(strip_tags($this->ticketId));

      // Bind data
      $stmt->bindParam(':ticketId', $this->ticketId);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Payload
    // public function update() {
    //   // Create query
    //   $query = 'UPDATE ' . $this->table . '
    //   SET text = :text
    //   WHERE id = :id';

    //   // Prepare statement
    //   $stmt = $this->conn->prepare($query);

    //   // Clean data
    //   $this->text = htmlspecialchars(strip_tags($this->text));
    //   //$this->id = htmlspecialchars(strip_tags($this->id));

    //   // Bind data
    //   $stmt->bindParam(':text', $this->text);
    //   $stmt->bindParam(':id', $this->id);

    //   // Execute query
    //   if($stmt->execute()) {
    //     return true;
    //   }

    //   // Print error if something goes wrong
    //   printf("Error: %s.\n", $stmt->error);

    //   return false;
    // }

    
  }