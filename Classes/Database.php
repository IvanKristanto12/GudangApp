<?php
//------------------------------------------------------------------------------------------------------------------------------------------------
//-------------------------------------------------------------- SQL SERVER ----------------------------------------------------------------------
class Database
{
    //CONFIG
    protected $servername = "IFUNK-VAIO\TESTSERVER";
    protected $username = "admin";
    protected $password = "TestServer12";
    protected $dbname = "GordenDB";
    protected $db_connection;

    /**
     *  @method fungsi untuk me-koneksi.
     *  @param -
     *  @return -
    */
    function openConnection(){
        try {
            $this->db_connection = new PDO("sqlsrv:Server=".$this->servername.";Database=".$this->dbname,$this->username,$this->password);
            $this->db_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die(print_r($e->getMessage()));
        }
    }

    /**
     *  @method fungsi untuk me-execute query SELECT atau StoredProcedure (yang mengembalikan sesuatu).
     *  @param string nama StoredProcedure.
     *  @param string parameter berupa array untuk StoredProcedure jika ada.
     *  @return - jika berhasil akan mengembalikan hasil dari query, 
     *            jika tidak akan mengembalikan FALSE.
    */
    function executeQuery($sp_name , $param){
        $this->openConnection();
        $query = "SET NOCOUNT ON; exec $sp_name ";
        $query .= $param[0];
        for($i = 1 ; $i<count($param) ; $i++){
            $query .= ", " . $param[$i];
        }   
        $getResult = $this->db_connection->prepare($query);
        $getResult->execute();
        $result = $getResult->fetchAll(PDO::FETCH_BOTH);
        $res = [];
        foreach($result as $row){
             $res[] = $row;
        }
        return $res;
    }

    /**
     *  @method fungsi untuk me-execute query INSERT, UPDATE, DELETE atau StoredProcedure (yang tidak mengembalikan sesuatu).
     *  @param string nama StoredProcedure.
     *  @param string parameter berupa array untuk StoredProcedure jika ada.
     *  @return - jika berhasil akan mengembalikan hasil dari query, 
     *            jika tidak akan mengembalikan FALSE.
    */
    function executeNonQuery($sp_name , $param){
        $this->openConnection();
        $query = "SET NOCOUNT ON; exec $sp_name ";
        $query .= $param[0];
        for($i = 1 ; $i<count($param) ; $i++){
            $query .= ", " .$param[$i];
        } 
        $getResult = $this->db_connection->prepare($query);
        $getResult->execute();
    }
}

