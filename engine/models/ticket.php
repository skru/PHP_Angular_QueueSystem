<?php 
  class Ticket {
    // DB properties
    private $conn;
    private $table = 'ticket';

    // Ticket Properties
    private $counterMin = "A000";
    private $counterMax = "Z999";
    public $id;
    public $tokenNumber;
    public $called;
    public $served;
    public $noShow;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
      $this->called = false;
      $this->served = false;
      $this->noShow = false;
    }

    // Get all tickets
    public function read() {
      // Create query
      $query = 'SELECT *
        FROM ' . $this->table . ' 
        WHERE 
        DATE(issuedTime) = :issuedTime
        ORDER BY
         id';

      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->issuedTime = htmlspecialchars(strip_tags($this->issuedTime));

      // Bind ID
      $stmt->bindParam(':issuedTime', $this->issuedTime);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    public function read_all() {
      // Create query
      $query = 'SELECT *
        FROM ' . $this->table . ' 

        ORDER BY
         id';

      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Ticket
    public function read_single() {
      // Create query
      $query = 'SELECT *
        FROM ' . $this->table . '
        WHERE
          id = ?
        LIMIT 0,1';
                  
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->tokenNumber = $row['tokenNumber'];
      $this->called = $row['called'];
      $this->served = $row['served'];
      $this->noShow = $row['noShow'];
    }

    

    // Create Ticket
    public function create() {

      // Get last ticket to calculate tokenNumber
      $query = 'SELECT *
        FROM ' . $this->table . '
        ORDER BY id
        DESC
        LIMIT 0,1';
                  
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($row){
        $lastTokenNumber = $row['tokenNumber'];

        if ($lastTokenNumber === $this->counterMax){
          $newTokenNumber = $this->counterMin;
        } else {
          $newTokenNumber = ++$lastTokenNumber;
        }
        
      } else {
        $newTokenNumber = $this->counterMin;
      }

      // Create query to create new ticket using generated tokenNumber
      $query = 'INSERT INTO ' . $this->table . ' 
      SET 
      tokenNumber = :tokenNumber, 
      called = false,
      served = false,
      noShow = false';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $newTokenNumber = htmlspecialchars(strip_tags($newTokenNumber));

      // Bind data
      $stmt->bindParam(':tokenNumber', $newTokenNumber);

      // Execute query
      $stmt->execute();
      //$row = $stmt->fetch(PDO::FETCH_ASSOC);

      $query = 'SELECT *
        FROM ' . $this->table . '
        ORDER BY id
        DESC
        LIMIT 0,1';
                  
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id = $row['id'];
      $this->tokenNumber = $row['tokenNumber'];
      $this->called = $row['called'];
      $this->served = $row['served'];
      $this->noShow = $row['noShow'];
    }

    // Ticket Call
    public function ticket_call() {

      $query = 'UPDATE ' . $this->table . '
        SET called = true
        WHERE id = :id';

      $stmt = $this->conn->prepare($query);

      // Bind data
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Ticket Serve
    public function ticket_serve() {
 
      $query = 'UPDATE ' . $this->table . '
              SET served = true,
              servedTime = CURRENT_TIMESTAMP
              WHERE id = :id';

      $stmt = $this->conn->prepare($query);

      // Bind data
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Ticket No Show
    public function ticket_no_show() {

      $query = 'UPDATE ' . $this->table . '
              SET noShow = true
              WHERE id = :id';

      $stmt = $this->conn->prepare($query);

      // Bind data
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }


    // Get Issued Count
    public function read_issued_count() {
      // Create query
      $query = 'SELECT *
        FROM ' . $this->table . '
        WHERE
        DATE(issuedTime) = :issuedTime';
                  
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->issuedTime = htmlspecialchars(strip_tags($this->issuedTime));

      // Bind ID
      $stmt->bindParam(':issuedTime', $this->issuedTime);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Called Count
    public function read_called_count() {
      // Create query
      $query = 'SELECT *
        FROM ' . $this->table . '
        WHERE
        DATE(issuedTime) = :issuedTime
        AND called = true';
                  
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->issuedTime = htmlspecialchars(strip_tags($this->issuedTime));

      // Bind ID
      $stmt->bindParam(':issuedTime', $this->issuedTime);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get No Show Count Count
    public function read_no_show_count() {
      // Create query
      $query = 'SELECT *
        FROM ' . $this->table . '
        WHERE
        DATE(issuedTime) = :issuedTime
        AND noShow = true
        AND served = false';
                  
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->issuedTime = htmlspecialchars(strip_tags($this->issuedTime));

      // Bind ID
      $stmt->bindParam(':issuedTime', $this->issuedTime);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
    
  }