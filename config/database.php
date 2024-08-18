<?php

// singleton connection class

class Connection {
  private static $instance = null;
  private $conn;
  private $host = '127.0.0.1';
  private $user = 'root';
  private $pass = '';
  private $name = 'pengaduan';

  // private $host = '127.0.0.1';
  // private $user = 'pendidik_pengadu';
  // private $pass = 'EhtXpeg4c0Dh';
  // private $name = 'pendidik_pengaduan';

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