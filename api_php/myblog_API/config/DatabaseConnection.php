<?php



class DatabaseConnection
{

    private $host = "localhost";
    private $user_name="root";
    private $db_name = "myblog";
    private $password="";
    private $conn ;
    private  static $instance = null;

        private function __construct()
        {
            $this->conn = null;
            try{
                $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name,$this->user_name,$this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
                $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch (PDOException $e){
                die("Connection Error ".$e->getMessage());
            }
        }

        public static function get_instance(){
            if(self::$instance==null){
               self::$instance = new DatabaseConnection();
            }
            return self::$instance;
        }

        public function getConnection(){
            return $this->conn;
        }
}
