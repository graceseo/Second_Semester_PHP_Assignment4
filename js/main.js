//
//Name: Gyeonglim
//Date: April 8, 2018
//Purpose: Assignment4
//

/*if products was comming from database, this array variable would recieve data*/
var foodArr=[["image/meowMix.jpg","White Fish Cat Food 1.36 Kilograms"
				,"25.99","fstfd"],
			["image/realAdult.jpg","Purrfect Bistro Salmon, Medium, Green"
				,"19.00","scdfd"]];

/* showing data with for statement*/
$( document ).ready(function() {
	jQuery.each( foodArr, function( i, val ) {
	  $("#foodDiv").append('<div class="foodlist" id='+val[3]+'><img src="'+val[0]+'"><br/>'
		+'<h5>'+val[1]+'</h5>'+'$'+val[2]
		+'<br/><input id=qty'+i+' name=qty'+i+' type="number" min="0" value="1">'
		+'<input type="hidden" value='+val[2]+' name=prc'+i+'>'
		+'<input type="hidden" value="'+val[1]+'" name=product'+i+'><br/>');
	});
});
//initializing regex patterns
var rgxEmail=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
var rgxPhone=/\d{3}-\d{3}-\d{4}|\d{10}/;
var rgxPstal = /^[A-Za-z]\d[A-Za-z][ -]?\d[A-Za-z]\d$/;

/* checking data validation*/
function validate(){
	var fstName=document.getElementById('fstnm').value;
	var lstName=document.getElementById('lstnm').value;
	var address=document.getElementById('add').value;
	var city=document.getElementById('ct').value;
	var pCode=document.getElementById('pstcode').value;
	var phone=document.getElementById('phn').value;
	var email=document.getElementById('mail').value;
	var qty0=document.getElementById('qty0').value;
	var qty1=document.getElementById('qty1').value;
	var errMsg="";
	var j;

	console.log("tet");
	
	if(lstName.trim()=="" ){
		errMsg=errMsg+"Last name is empty!!!<br/>";
		document.getElementById('lstnm').focus();
	}
	if(fstName.trim()==""){
		errMsg=errMsg+"Fist name is empty!!!<br/>";
		document.getElementById('fstnm').focus();
	}
	if(address.trim()==""){
		errMsg=errMsg+"address is empty!!!<br/>";
		document.getElementById('add').focus();
	}
	if(city.trim()==""){
		errMsg=errMsg+"city is empty!!!<br/>";
		document.getElementById('ct').focus();
	}
	if(pCode.trim()==""|| !rgxPstal.test(pCode.trim())){
		errMsg=errMsg+"Postal Code is invalid!!!<br/>";
		document.getElementById('pstcode').focus();
	}
	if(phone.trim()==""|| !rgxPhone.test(phone.trim())){
		errMsg=errMsg+"phone number is invalid!!!<br/>";
		document.getElementById('phn').focus();
	}
	if(email.trim()=="" || !rgxEmail.test(email.trim())){
		errMsg=errMsg+"email address is invalid!!!<br/>";
		document.getElementById('mail').focus();
	}
		
	if((qty1==0 && qty0==0)||(qty1<0 || qty0<0)){
		errMsg=errMsg+"please choose more than 0 quantity<br/>";
		document.getElementById('qty0').focus();
	}
	
	if(errMsg!=""){
		document.getElementById("err").innerHTML=errMsg;	
	}else{
		document.orderForm.submit();
	}
}

/*filling data to test this web page*/
function autoFill(){
	document.getElementById('fstnm').value='Seo';
	document.getElementById('lstnm').value='Grace';
	document.getElementById('add').value='204b Hespeler Road';
	document.getElementById('ct').value='Cambridge';
	document.getElementById('pstcode').value='n1n 2h2';
	document.getElementById('phn').value='222-222-22222';
	document.getElementById('mail').value='abc22@gmail.com';
}