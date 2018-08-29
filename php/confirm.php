<?php
/*
Name: Gyeonglim, Isabela
Date: April 8, 2018
Purpose: Assignment4
*/

echo '<link rel="stylesheet" href="../style/main.css">';

	//tax array
	$taxArr=array(
		"Alberta"=> 0.05,
		"British Columbia"=> 0.12,
		"Manitoba"=> 0.13,
		"New Brunswick"=> 0.15,
		"Newfoundland and Labrador"=> 0.15,
		"Nova Scotia"=> 0.05,
		"Ontario"=> 0.13,
		"Prince Edward Island"=> 0.15,
		"Quebec"=> 0.14975,
		"Saskatchewan"=> 0.11,
		"Northwest Territories"=> 0.05,
		"Nunavut"=> 0.05,
		"Yukon"=> 0.05
	);

	//initializing regex patterns
	$rgxEmail='/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
	$rgxPhone='/\d{3}-\d{3}-\d{4}|\d{10}/';
	$rgxPstal = '/^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/';

	//collecting data
	$lname=$_POST['lastname'];
	$fname=$_POST['firstname'];
	$add=$_POST['address'];
	$city=$_POST['city'];
	$PV=$_POST['province'];
	$pstcode=$_POST['postalcode'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	//$email='efe';
	$qty0=$_POST['qty0'];
	$qty1=$_POST['qty1'];
	$prc0=$_POST['prc0'];
	$prc1=$_POST['prc1'];
	$product0=$_POST['product0'];
	$product1=$_POST['product1'];

	$products=array
			(
				array($product0,$qty0,$prc0),
				array($product1,$qty1,$prc1)
			);

	$errMsg="";
	$product1Tax=0;
	$product2Tax=0;
	$productFee1=0;
	$productFee2=0;

	//checking data validation
	if(!preg_match($rgxEmail,$email)){
		$errMsg.= "Email is invalid.<br/>";
	}
	if(!preg_match($rgxPhone,$phone )){
		$errMsg.= "Phone Number is invalid.<br/> ";
	}
	if(!preg_match($rgxPstal,$pstcode )){
		$errMsg.= "Postal Code is invalid.<br/> ";
	}
	if($qty0<0 || $qty1<0 ){
		$errMsg.= "quantity must not be a negative number, try again";
	}
	if($errMsg!=""){
		//call method for error
		errShow($errMsg);
	}else{		
		//make a receipt form
		print("<div id='disReceipt'><p>Your order has been processed. Please verify the informaiton</p><br/>"
				."<h4>Shipping To: </h2><div id='userInfo'>".$lname."&nbsp".$fname."<br/>"
				.$add."<br/>".$city.", ".$PV."<br/>".$pstcode
				."</div><br/><br/>"
				."<h4>Prder Information: </h2><div id='orderInfo'>"
				."<table>");
				
		//call function for receipt
		$tax=calTax($taxArr,$PV);
		
		//calculate fee 
		if($products[0][1]>0){
			$productFee1=$products[0][1]*$products[0][2];
			$product1Tax=$productFee1*$tax;
			print("<tr><td>".$products[0][1]."&nbsp&#91;".$products[0][0]."&#93; at $".$products[0][2]."&nbsp&nbsp</td><td >"
			."$".number_format((float)$productFee1,2,'.','')."</td></tr>");
		}
		if($products[1][1]>0){
			$productFee2=$products[1][1]*$products[1][2];
			$product2Tax=$productFee2*$tax;
			print("<tr><td>".$products[1][1]."&nbsp&#91;".$products[1][0]."&#93; at $".$products[1][2]."&nbsp&nbsp</td><td >"
			."$".number_format((float)$productFee2,2,'.','')."</td></tr>");
		}
		$allTax=number_format((float)$product1Tax+$product2Tax,2,'.','');
		$allPrdFee=$productFee1+$productFee2;
		$deliveryFee=0;
		$deliveryTime=0;
		
		if($allPrdFee>=0.01&&$allPrdFee<=25.00){
			$deliveryFee=3.00;
			$deliveryTime=1;
		}elseif($allPrdFee>=25.01&&$allPrdFee<=50.00){
			$deliveryFee=4.00;
			$deliveryTime=1;
		}elseif($allPrdFee>=50.01&&$allPrdFee<=75.00){
			$deliveryFee=5.00;
			$deliveryTime=3;
		}else{
			$deliveryFee=6.00;
			$deliveryTime=4;
		}
		
		$total=$product1Tax+$product2Tax+$deliveryFee+$allPrdFee;
		
		//make new instance of date 
		$edate = new DateTime();
		$edate = $edate->add(new DateInterval('P'.$deliveryTime.'D'));
		
		print("<tr><td>Tax</td><td>$".$allTax."</td></tr>");
		print("<tr id='splitTr'><td>Delevery</td><td>$".number_format((float)$deliveryFee,2,'.','')."</td></tr>");
		print("<tr><td>Total</td><td>$".number_format((float)$total,2,'.','')."</td></tr>");
		print("</table>");
		print("<br/><br/><br/><p>Estimated Delivery Date: <b>".$edate->format('Y-m-d')."</b></p>");
		print("</div>");
	}
	
	//calculating tax 
	function calTax($taxArr,$PV){
		//finding tax in a tax array with key value
		if(array_key_exists($PV,$taxArr)){
			$reTax=$taxArr[$PV];
		}else{
			//call method for error
			$errMsg.="Province Code is invalide, try again";
			errShow($errMsg);
		}
		return $reTax;
	}
	
	//error handling 
	function errShow($errMsg){
		echo $errMsg;
		echo '<br/><div id="errBack"><button type="button" onclick="javascript:history.go(-1)">BACK</button></div>';
	}	
?>
