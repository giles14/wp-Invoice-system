<?php

class myDB{
    private $query;
    private $arrayquery;
    private $table;
    private $fields;
    private $values;
    private $mysqliObject;
    const debugmode = false;
    
    public function __construct(){
        
    }
    
    // This is declared as private to prevent outside of class call.   
    private function dbConnect(){
        //connection arguments
    $host = 'userdatabaseapp2.db.7957091.hostedresource.com';
    $user = 'userdatabaseapp2';
    $pass = 'uDB2012';
    $dbName = 'userdatabaseapp2';
    
    $this->mysqliObject = new mysqli( $host, $user , $pass , $dbName );
    $db = $this->mysqliObject;
    
    //$connection = new mysqli( $host, $user , $pass , $dbName );
    if (!$db)
      {
      die('Could not connect: ' . mysqli_error());
      }else {
        if(self::debugmode){
            echo('<br />Connection success!');
        }
        
      }
          
    }
    
    private function dbCloseConnection(){
        $db = $this->mysqliObject;
        if(mysqli_close($db)){
            if(self::debugmode){
            echo 'Connection succesfully closed <br />';
            }
        }else {
            die('Could not close: ' . mysqli_error());
        }
        
    }
    
    public function testConnection(){
        $this->dbConnect();
        $this->dbCloseConnection();
    }
    
    public function insertQuery($fields , $values , $table){
        
        // Preparing the information, adding single quote if it's a string.
        
        foreach($values as $value){
            $valuesquote[] = str_replace("'" , "\'" , $value);
        }
        $values = $valuesquote;
        if(is_array($values) )
        {
            $values = array_map(array($this, 'addQuotes') , $values);
        }
        
        $field = implode( ',' , $fields);
        $value = implode( ',' , $values);
        
        
        
        //Preparing the query statement
        $thequery = 'INSERT INTO ' . $table . ' ( ' . $field . ' ) ' . ' VALUES ' . '( ' . $value . ' )';
                    
        if(self::debugmode){
            echo 'function insertQuery <br />';
            echo 'param received : <br />';
            print_r($fields);
            echo '<br />';
            print_r($values);
            echo $field . '<br />';
            echo $value . '<br />';
            echo 'Quert tried: ' . $thequery; 
            
        }
        
        $this->dbConnect();
        $db = $this->mysqliObject;
        if($db->query($thequery)){
            if(self::debugmode){
                echo '<br /> Insert succesfully in: ' . $table . '<br />';
            }
            
        }else {
            echo 'Error: ' . $db->error;
        }
        $this->dbCloseConnection();
    }
    public function showQuery($query){
    
    $this->dbConnect();
    $db = $this->mysqliObject;
    if($db->query($query)){
        if(self::debugmode){
            echo '<br /> Show query Success: query used :' . $query . '<br />';
            echo 'Printing ressult <br />';
            print_r($result);
            echo '==== Finish ShowQuery ====';
        }
        $result = $db->query($query);
        $allRows = $db->affected_rows;
       
        /*while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $allRows[] = $row;
        }*/
            
        }
        else {
            echo 'Error in showQuery: ' . $db->error();
        }
        
    $this->dbCloseConnection();
    
    //echo count($allRows);
    return $allRows;   
        
    }
    
    public function countRows($query){
        $allRows = 0;
    $this->dbConnect();
    $db = $this->mysqliObject;
    if($db->query($query)){
        if(self::debugmode){
            echo '<br /> Method: countRowns =========';
            echo '<br /> Show query Success: query used :' . $query . '<br />';
            echo '<br /> $allRows :' . $allRows . '<br />';
        }
        $result = $db->query($query);
        $allRows = $db->affected_rows;
       
        /*while($result->fetch_array(MYSQLI_ASSOC)){
            $allRows ++;
        } */
            
        }else {
            echo 'Error in showQuery: ' . $db->error();
        }
        $this->dbCloseConnection();
        //$allRows = count($allRows);
        if(!isset($allRows)){
            $allRows = 0;
        }
        if(self::debugmode){
            echo '<br /> $allRows ' . $allRows . '<br />';
            echo '<br /> ====== Finish count Rows ==== <br />';
        }
        return $allRows;   
    }
    
    
    
    private function addQuotes($dataString){
        if(is_string($dataString)){
            $dataString = "'" . $dataString . "'";
            if(self::debugmode){
                echo 'Method addQuotes ====';
                echo 'function addQuotes: ';
                echo $dataString . '<br />';
                echo '<br />End addQuotesMethod ======= <br />';
            }
            
        }
        return $dataString;
    }
    
}

$myDB = new myDB();
$myDB->testConnection();



?> 
