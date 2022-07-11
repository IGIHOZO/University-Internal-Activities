<?php
//====================================================================================================== CONNECTION
class DbConnect
{

    private $host='localhost';
    private $dbName = 'cards';
    private $user = 'root';
    private $pass = '';
    public $conn;
    
    // private $host='localhost';
    // private $dbName = 'eguraco1_egura';
    // private $user = 'eguraco1';
    // private $pass = 'sV.GemLj,X3Y';
    // public $conn;


    public function connect()
    {
        try {
         $conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbName, $this->user, $this->pass);
         return $conn;
        } catch (PDOException $e) {
            echo "Database Error ".$e->getMessage();
            return null;
        }
    }
}
/**
 * ====================== MAIN CLASS
 */
class MainClass extends DbConnect
{
    
    function select_modules(){
        $con = parent::connect();
        $sel_mod = $con->prepare("SELECT * FROM masters_departments");
        $sel_mod->execute();
        if ($sel_mod->rowCount()>=1) {
            while ($ft_sel_mod = $sel_mod->fetch(PDO::FETCH_ASSOC)) {
                $mod_id = $ft_sel_mod['department_id '];
                echo "<option value='$mod_id'>".$ft_sel_mod['department_name']."(".$ft_sel_mod['department_code'].")</option>";
            }
        }
    }
}

?>