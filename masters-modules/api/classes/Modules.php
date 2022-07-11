<?php
include_once "Database.php";
class Modules{

    public $conn;
    private $validate;
    function __construct()
    {
        $db = new Database();
        $this->conn = $db->connection();
    }

    function get($datas){
        $datas = $datas['faculty'];
        $qy = $this->conn->query("SELECT * FROM masters_modules");
        $data = $qy->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
}
?>