<?php
include('include/db.php');

class Invoice {
    private $id = 0;
    private $itemId;
    private $company;
    private $date;
    private $listItems = array();
    private $iterator = 0;
    
    
    public function __construct($company, $date) {
        $this->company = $company;
        $this->date = $date;
        $this->id = $this->asignID();
    }
    
    public function asignID(){
        $db = new myDB;
        //get the number of invoice's stored in the DB
        $id = $db->countRows('SELECT * FROM invoice');
        //add 1 to return a new ID
        $id ++;
        //$this->id = $id;
        return $id;
    }
    
    public function storeInvoice(){
        $fields = array( 'ownerid' , 'ownername' , 'address' , 'company');
        $values = array ('1' , 'Carlos Giles' , $this->date , $this->company);
        $db = new myDB;
        $db->insertQuery($fields,$values,'invoice');
        
    }    
    
    public function asignItemID($invoiceID){
        $itemNewID = 0;
        //Receive parameter: the id of the invoice 
        $db = new myDB;
        $queryID = $invoiceID;
        $itemNewID = ( $db->countRows("SELECT * FROM items WHERE id = " . $queryID  ));
        
        echo "<br />" . $itemNewID . " numero de items " . "in invoice $invoiceID <br />";
              
        //check if any item exist.
        if($itemNewID >= 1){
            //add the count items in the DB + the items in the current array that haven't  been stored
            $itemNewID = ($itemNewID + count($this->listItems) + 1);
            
        }else {
            $itemNewID = 0;
            $itemNewID = count($this->listItems) + 1;
        }
        
        $this->itemId = $itemNewID;
        
        //expected Return: Int. The count of Number of rows .
        return $this->itemId;      
    }
    
    public function printInvoice(){
        $elementos =  $this->productAddedNumber();
        
        $printInvoice = 'La factura con ID: ' . $this->id . '<br />';
        $printInvoice .= 'Es de la empresa ' . $this->company . '<br />';
        $printInvoice .= 'Con fecha: ' . $this->date . '<br />';
        $printInvoice .= 'Tiene elementos: ' . $elementos .'<br/>';
        
        
        
        print $printInvoice;
        echo $this->printItems();        
    }
    public function addItem(Item $item){
        //getting the item ID counting the items in listItem array, we need to add +1 because the method is 
        //called before the array_push is excecuted. 
        array_push($this->listItems , array('itemid' => $this->asignItemID($this->id) , 'description' =>$item->getDescription() , 'quantity' => $item->getQuantity() , 'unitprice' => $item->getUnitPrice() , 'subtotal' => $item->subTotal($item->getQuantity() , $item->getUnitPrice()) ));
        $this->productAddedNumber();
    }
    
    public function productAddedNumber(){
        //takes the last state of iterator and adds +1
        $numberItems = $this->iterator ++;
        return $numberItems;
        
    }
    
    public function printItems(){
        $allItems =  $this->listItems;
        $print = '<table>';
        $print .= '<tr><th>Item ID</th><th>Description</th><th>Quantity</th><th>Unit Price</th><th>Total</th>';
        foreach ($allItems as $key => $value) {
            $print .= "<tr>";
            foreach ($value as $iKey => $iValue) {
                $print .= " <td>$iValue</td>";
            }
            $print .= "</tr>";
        }
        $print .= '<td></td><td></td><td></td><td></td><td>MiTotal</td></table>';
        return $print;
        
    }
    
    
    public function storeItems(){
        $storeItemsArray = $this->listItems;
        $invoiceId = $this->id;
        $myDB = new myDB;
        
        foreach ( $storeItemsArray as $key => $value){
            $id[] = $key;
            
            
            //for every pass of the $key, we declare a new array, to prevent an array increment for all values
            //instead of only the values of the current $key
            $values = array();
            $names = array();
            //assign the invoiceID owner field and value
            $values[] = $this->asignID(); //Change to current ID
            $names[] = 'id';
            
            foreach ( $value as $iKey => $iValue ){
                //store in an array the field and the values to then store it to DB.
                $names[] = $iKey;
                $values[] = $iValue;    
            }
            
            $myDB->insertQuery($names , $values , 'items');
            // Implode the arrays to get a string separated by comas
//            $name = implode( ',' , $names);
//            $value = implode( ',' , $values);
            
            //Preparing the query 
//            $query = 'INSERT INTO ITEMS ( ' . $name . ' ) ' . ' VALUES ' . '( ' . $value . ' ) <br />';            
        }
//        $myDB = new myDB;
//        $myDB->insertQuery($query);
        echo '<br />';
        $id = implode(',' , $id);
 //       $name = implode ( ',' , $name[1][] );
 //       $values = implode ( ',' , $values[1][] );
        
        
        /*
        foreach ($storeItemsArray as $key => $value) {
            foreach ($value as $iKey => $iValue) {
                $query = 'INSERT INTO items' . .;
            }
            
        } */
        
        
    }
     
    public function printTotals(Item $item){
        
    }
}// end of Invoice Class
    
class Item {
    private $itemId;
    private $description;
    private $quantity;
    private $unitPrice;
    private $subTotal;
    private $total;
    
    public function getDescription(){
        return $this->description;
    }
    public function getQuantity(){
        return $this->quantity;
    }
    public function getUnitPrice(){
        return $this->unitPrice;
    }
    public function getSubtotal(){
        return $this->subTotal;
    }
    
    public function __construct( $description , $quantity , $unitPrice ) {
        $this->description = $description;
        $this->quantity = $quantity;
        $this->unitPrice = $unitPrice;
        $this->subTotal($quantity , $unitPrice);        
    }
    
    public function subTotal($quantity , $unitPrice){
        //need to fix the 00 after the .
        $unitPrice = str_replace( '$' , '' , $unitPrice );
        $subTotal = $quantity * $unitPrice;
        $subTotal = '$' . $subTotal;
        return $subTotal;
        
    }
        
     
}

    
?>            