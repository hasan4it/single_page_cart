<?php
error_reporting(0);
session_start();

$products = array(

    array(
        "name" => 'Red Widget',
        "code" => 'R01',
        "price" => '32.95'
    ),

    array(
        "name" => 'Green Widget',
        "code" => 'G01',
        "price" => '24.95'
    ),
    array(
        "name" => 'Blue Widget',
        "code" => 'B01',
        "price" => '7.95'
    )
);

if(isset($_GET['product']) && !empty($_GET['product'])){

    $_SESSION['product'][] = $_GET['product'];
    header("location: ?redirect",true);

}

if(isset($_GET['empty'])){

    unset($_SESSION['product']);

}

?>
<html>
<head><title>Shopping cart</title>
</head>
<body>
<h4>We have the following products in our catalog</h4>



<div style="float:left;width:49%; border:1px solid #444;">
<div style="line-height:35px; width:98.5%;background:navy; color:#fff; font-weight:bold; padding-left:10px;">Product list</div>
<?php
    foreach($products as $product){
?>
    <p style="padding-left:10px; border-top:1px solid #444; margin:0px; padding-top:10px; padding-bottom:10px;"> <strong>Product Name:</strong> <?php echo $product["name"]?> | <strong>Price: </strong><?php echo $product['price'] ?> | <strong>Code:</strong> <?php echo $product['code']?>
    
    <small style="float:right; margin-right:50px;">
    <a href="?product=<?php echo $product['code']; ?>" title="click to add in cart" 
    style="text-decoration:none; padding:5px; background-color:navy; color:#fff; padding-left:20px; padding-right:20px;">
           Add  </a> </small>
    </p>
  
<?php
}
?>
</div>
<div style="margin-left:5px;float:left; width:49%;">
    <div style="line-height:35px; width:98.5%;background:navy; color:#fff; font-weight:bold; padding-left:10px;"> Shopping cart</div>
    <?php

    if($_SESSION['product']){
        
        $cart_products = $_SESSION['product'];

    if(count($cart_products)){

        $total = count($products);
        foreach($cart_products as $cart){

            for($i = 0; $i<$total; $i++){

                if(array_search($cart, $products[$i])){
                    
                    $arr[$products[$i]['code']] = $products[$i];
                    $arr_code[] = $products[$i]['code'];
                }
            }
        }

        }
    }
  
$sum = 0;
$summary = array_count_values($arr_code);
$codes = array_keys($summary);

$discount = 0;
echo '<table id="table2">';
echo "<tr><th>Product Name</th><th>Product Code</th><th>Price</th><th>Cart item(s)</th></tr>";
foreach($arr as $a){

    if(in_array($a['code'], $codes) ){

        if($a['code'] == 'R01' && $summary[$a['code']] > 1){
            $discount = $a['price']/2;
        }
            
        echo "<tr><td>".$a["name"].'</td><td> '.$a["code"].'</td><td> '.$a['price']."</td><td>".$summary[$a['code']]."</td></tr>";
        $sum += ($a['price']*$summary[$a['code']]);
        
    }
   
}
echo "</table>";

$sum -=round($discount,2);

if(floor($sum) >0 && floor($sum) < 50){
    $shipping_charges = "Shipping charges: 4.95";
    $echo = "<strong>Total: </strong>$".round(($sum+4.95),2);
}
elseif(floor($sum) > 49 && floor($sum) < 90){
    $shipping_charges = "Shipping charges: 2.95";
    $echo = "<strong>Total:</strong> $".round(($sum+2.95),2);
}
else{
    $shipping_charges = "Shipping free";
    $echo = "<strong>Total: </strong>$".round($sum,2);
}

if($echo){

    echo '<p style="float:left;width:80%;">'.$echo."<br><small>*".$shipping_charges."</small>"."</p>" ;
}
   
?>
<a href="?empty" style="background:maroon; color:#fff; padding:5px; text-decoration:none; float:left; margin-top:15px;">Empty Cart</a>
</div>


<div>
<table>
<tr>
    <th>Order Range</th>
    <th>Charges</th>
</tr>
<tr>
    <td>Under $50 </td>
    <td>$4.95</td>
</tr>
<tr>
    <td>Under $90 </td>
    <td>$2.95</td>
</tr>
<tr>
    <td>More than $90 </td>
    <td>Free Shipping</td>
</tr>
<tr>
    <td></td>
    <td>Under special promotion, buy one red widget, get the second half price</td>
</tr>
</table>
</div>

<style> 
            table { 
              border-collapse: collapse; 
              border: 1px solid black; 
            }  
            th, td { 
              border: 1px solid black;
              padding-left:10px; 
            } 
           
              
            table#table2 { 
              table-layout: fixed; 
              width: 100%;   
            } 
           
        </style>
</body>
</html>