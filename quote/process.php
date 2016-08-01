<?php

define('constVar', TRUE);

// No direct access to this file 
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'); 
if(!IS_AJAX) {die('Restricted access');}

$errors         = array();      // array to hold validation errors
$data           = array();      // array to pass back data

// validate user input ======================================================
    // if field is empty or invalid, add appropriate error message to errors array
    if (empty($_POST['deliveryDate'])) {
        $errors['deliveryDate'] = 'Please enter a delivery date';
    }
    if (empty($_POST['pale'])) {
        $errors['pale'] = 'Please select a type of beer';
    }
    if (empty($_POST['quantity'])) {
        $errors['quantity'] = 'Please select a number of bottles';
    }
    if (empty($_POST['firstName'])) {
        $errors['firstName'] = 'Please enter your first name';
    }
    if (empty($_POST['surname'])) {
        $errors['surname'] = 'Please enter your surname';
    }
    if (empty($_POST['email'])) {
        $errors['email'] = 'Please enter an email address';
    }
    if (empty($_POST['postcode'])) {
        $errors['postcode'] = 'Please enter a postcode';
    }
    if (empty($_POST['houseNum'])) {
        $errors['houseNum'] = 'Please enter a house name or number';
    }
    if (empty($_POST['city'])) {
        $errors['city'] = 'Please enter a town or city';
    }
    if (empty($_POST['county'])) {
        $errors['county'] = 'Please select a county';
    }
    if (empty($_POST['address1'])) {
        $errors['address1'] = 'Please enter a street name';
    }

    // if there are any errors in our errors array, return a success boolean of false then add errors to data.errors
    if ( ! empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {
// Skip db call if validation fails============================================                

//-------------PROCEED WITH FORM PROCESSING-------------//
include 'functions.php';

// set the timezone
date_default_timezone_set('Europe/London');
        
// get data from form
$designs = db_quote($_POST['designs']);
$ukDate = $_POST['deliveryDate'];
$bits = explode('/',$ukDate);
$usDate = $bits[1].'/'.$bits[0].'/'.$bits[2];		
$deliveryDate = db_quote(date('Y-m-d', strtotime($usDate)));
if (empty($_POST['pale330'])) {
	$pale330 = db_quote('off');
} else {
	$pale330 = db_quote($_POST['pale330']);
}
if (empty($_POST['pale500'])) {
	$pale500 = db_quote('off');
} else {
	$pale500 = db_quote($_POST['pale500']);
}
if (empty($_POST['ipa330'])) {
	$ipa330 = db_quote('off');
} else {
	$ipa330 = db_quote($_POST['ipa330']);
}
if (empty($_POST['ipa500'])) {
	$ipa500 = db_quote('off');
} else {
	$ipa500 = db_quote($_POST['ipa500']);
}
if (empty($_POST['stout330'])) {
	$stout330 = db_quote('off');
} else {
	$stout330 = db_quote($_POST['stout330']);
}
if (empty($_POST['stout500'])) {
	$stout500 = db_quote('off');
} else {
	$stout500 = db_quote($_POST['stout500']);
}		
$quantity = db_quote($_POST['quantity']);
$nameTag = db_quote($_POST['nameTag']);
$nameTagText = db_quote($_POST['nameTagText']);
$wrapping = db_quote($_POST['wrapping']);
$ribbon = db_quote($_POST['ribbon']);
$firstName = db_quote($_POST['firstName']);
$surname = db_quote($_POST['surname']);
$email = db_quote($_POST['email']);		
$phone = db_quote($_POST['phone']);
$postcode = db_quote($_POST['postcode']);		
$houseNum = db_quote($_POST['houseNum']);
$flat = db_quote($_POST['flat']);
$city = db_quote($_POST['city']);
$county = db_quote($_POST['county']);
$company = db_quote($_POST['company']);
$address1 = db_quote($_POST['address1']);
$address2 = db_quote($_POST['address2']);			
$requirements = db_quote($_POST['requirements']);

    
 $result = db_query("INSERT INTO `potentialOrders` (`designs`, `deliveryDate`, `pale330`, `pale500`, `ipa330`, `ipa500`, `stout330`, `stout500`, `quantity`, `nameTag`, `nameTagText`, `wrapping`, `ribbon`, `firstName`, `surname`, `email`, `phone`, `postcode`, `houseNum`, `flat`, `city`, `county`, `company`, `address1`, `address2`, `requirements`) VALUES (" . $designs . ", " . $deliveryDate . ", " . $pale330 . ", " . $pale500 . ", " . $ipa330 . ", " . $ipa500 . ", " . $stout330 . ", " . $stout500 . ", " . $quantity . ", " . $nameTag . ", " . $nameTagText . ", " . $wrapping . ", " . $ribbon . ", " . $firstName . ", " . $surname . ", " . $email . ", " . $phone . ", " . $postcode . ", " . $houseNum . ", " . $flat . ", " . $city . ", " . $county . ", " . $company . ", " . $address1 . ", " . $address2 . ", " . $requirements . ")");
        if($result === false) {
            // if there is an insert error, return a generic error message
            $data['success'] = false;
            $errors['email'] = 'Oops! Something went wrong. Please try again later, or drop us an email at info@hoppiness.uk';    
            $data['errors']  = $errors;
        } else {
            
            // We successfully inserted a row into the database
            // add a message of success and provide a true success variable
            $data['success'] = true;
            $data['message'] = "Added";
        }  

// ----email---- // 

$emailRequirements = $_POST['requirements'];
$emailRequirements = nl2br($emailRequirements);      
        
$timeStamp = date("F j, Y, g:i a");
        
$emailFrom = "<automated@hoppiness.uk>";
 
$emailSubject = "New Customer Enquiry: ".$timeStamp;
    
$to = "<newenquiries@hoppiness.uk>";
 
$headers = "From: $emailFrom" . "\r\n";
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


$emailBody= "
<html>
<head>
<title>New Order Enquiry</title>
</head>
<body>
<table>
<tr>
<th>No. of Designs</th>
</tr>
<tr>
<td>$designs</td>
</tr>
</table>
<table>
<tr>
<th>Delivery Date</th>
</tr>
<tr>
<td>$ukDate</td>
</tr>
</table>
<table>
<tr>
<th>Pale 330ml</th>
<th>Pale 330ml</th>
<th>IPA 330ml</th>
<th>IPA 500ml</th>
<th>Stout 330ml</th>
<th>Stout 500ml</th>
</tr>
<tr>
<td>$pale330</td>
<td>$pale500</td>
<td>$ipa330</td>
<td>$ipa500</td>
<td>$stout330</td>
<td>$stout500</td>
</tr>
</table>
<table>
<tr>
<th>No. of Bottles</th>
</tr>
<tr>
<td>$quantity</td>
</tr>
</table>
<table>
<tr>
<th>No. of Name Tags</th>
</tr>
<tr>
<td>$nameTag</td>
</tr>
</table>
<table>
<tr>
<th>Name Tag Text</th>
</tr>
<tr>
<td>$nameTagText</td>
</tr>
</table>
<table>
<tr>
<th>No. of Paper Wrappings</th>
</tr>
<tr>
<td>$wrapping</td>
</tr>
</table>
<table>
<tr>
<th>No. of Ribbons</th>
</tr>
<tr>
<td>$ribbon</td>
</tr>
</table>
<table>
<tr>
<th>First Name</th>
</tr>
<tr>
<td>$firstName</td>
</tr>
</table>
<table>
<tr>
<th>Surname</th>
</tr>
<tr>
<td>$surname</td>
</tr>
</table>
<table>
<tr>
<th>Email Address</th>
</tr>
<tr>
<td>$email</td>
</tr>
</table>
<table>
<tr>
<th>Phone No.</th>
</tr>
<tr>
<td>$phone</td>
</tr>
</table>
<table>
<tr>
<th>Postcode</th>
</tr>
<tr>
<td>$postcode</td>
</tr>
</table>
<table>
<tr>
<th>House Name/No.</th>
</tr>
<tr>
<td>$houseNum</td>
</tr>
</table>
<table>
<tr>
<th>Flat/Apartment No.</th>
</tr>
<tr>
<td>$flat</td>
</tr>
</table>
<table>
<tr>
<th>City</th>
</tr>
<tr>
<td>$city</td>
</tr>
</table>
<table>
<tr>
<th>County</th>
</tr>
<tr>
<td>$county</td>
</tr>
</table>
<table>
<tr>
<th>Company Name</th>
</tr>
<tr>
<td>$company</td>
</tr>
</table>
<table>
<tr>
<th>Street Name</th>
</tr>
<tr>
<td>$address1</td>
</tr>
</table>
<table>
<tr>
<th>Address Line 2</th>
</tr>
<tr>
<td>$address2</td>
</tr>
</table>
<table>
<tr>
<th>Extra Info/Requirements</th>
</tr>
<tr>
<td>$emailRequirements</td>
</tr>
</table>
</body>
</html>
";		

mail($to,$emailSubject,$emailBody,$headers);        
        
}

//------------FORM PROCESSING-------------//

    // return data to an AJAX call
    echo json_encode($data);
            
        
?>