<?php
// Database Model

class Database {
    private $conn;
    
    public function __construct() {
        global $conn;
        $this->conn = $conn;
    }
    
    /**
     * Execute query
     */
    public function query($sql) {
        return $this->conn->query($sql);
    }
    
    /**
     * Prepare statement
     */
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }
    
    /**
     * Get connection
     */
    public function getConnection() {
        return $this->conn;
    }
    
    /**
     * Escape string
     */
    public function escape($string) {
        return $this->conn->real_escape_string($string);
    }
    
    /**
     * Get last insert ID
     */
    public function getLastInsertId() {
        return $this->conn->insert_id;
    }
    
    /**
     * Get affected rows
     */
    public function getAffectedRows() {
        return $this->conn->affected_rows;
    }
}

?>
