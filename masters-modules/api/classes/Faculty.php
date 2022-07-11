<?php
include_once "Database.php";
class Faculty{

    public $conn;
    private $validate;
    function __construct()
    {
        $db = new Database();
        $this->conn = $db->connection();
    }

    function get(){
        $qy = $this->conn->query("SELECT * FROM masters_faculties");
        $data = $qy->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
?>