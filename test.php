<?php
include('invoice.php');
    
$itemo = new Item( 'Un item' , '10' , '$10.51' );
$itemo2= new Item( 'Otro Itemo' , '20' , '$1.00');
$itemo3 = new Item ('Tercer Item' , '30' , '$2.00');
$factura1 = new Invoice( 'Acme' , '22/04/88');

$factura2 = new Invoice ( 'Las Lomas' , '13/12/2011' , '$50.00' );

$factura1->addItem($itemo);
$factura1->addItem($itemo2);
$factura1->addItem($itemo3);
//$factura1->storeItems();
$factura2->addItem($itemo);
$factura2->addItem($itemo2);


$factura1->storeInvoice();
$factura2->storeInvoice();



//$factura1->printItems();

$factura1->printInvoice();
$factura2->printInvoice();
$factura2->storeItems();


$factura3 = new Invoice ('Giles  Red' , '22/04/88');
$cosa = new Item ('Un item' , '10' , '$10.51');

$factura3->addItem($cosa);
$factura3->storeItems();
$factura3->printInvoice();




    
?>            
