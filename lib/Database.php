<?php

class Database{
    
    public $options  = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,);
    
    protected $con; 
    
    public function openConnection(){
        try{
            
            $this->con = new PDO(DBHOST, DBUSER,DBPASS,$this->options);
            return $this->con;
            
        }catch (PDOException $e){
            
            echo "There is some problem in connection: " . $e->getMessage();
            
        }
    }
    
    
    
    public function closeConnection() {
        $this->con = null;
    }
    
    
    
    
    // private $Connection;

    // function __construct() {
    //   $this->Connection = mysqli_connect(SERVER, DBUSER, DBPASS);
    //   mysqli_select_db($this->Connection, DBNAME);
    //   mysqli_set_charset($this->Connection,"utf8");
    // }

    // public function query($Query){
    //   $ResultReferance = mysqli_query($this->Connection, $Query) or die(mysqli_error($this->Connection));
    //   $ResultsData = array();
    //   if(!is_bool($ResultReferance)){
    //     while($ResultsData[] = mysqli_fetch_object($ResultReferance));
    //     mysqli_free_result($ResultReferance);
    //   }
    //   return $ResultsData;
    // }

    // public function last_id(){
    //   return mysqli_insert_id($this->Connection);
    // }

    // function __destruct() {
    //   mysqli_close($this->Connection);
    // }
    
    // function getOptions(){
        
    // }
}
?>