<?php

// singleton connection class

class Connection {
  private static $instance = null;
  private $conn;
  private $host = 'localhost';
  private $user = 'root';
  private $pass = '';
  private $name = 'pengaduan';

  private function __construct() {
    try {
      $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
    } catch (\Throwable $th) {
      die('Connection failed: ' . $this->conn->connect_error);
    }
  }

  public static function getInstance() {
    if(!self::$instance) {
      self::$instance = new Connection();
    }

    return self::$instance;
  }

  public function getConnection() {
    return $this->conn;
  }

  public function closeConnection() {
    $this->conn->close();
  }

  public function __destruct() {
    $this->closeConnection();
  }
}




?>