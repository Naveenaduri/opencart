<?php 

    $name = $_POST['name'];
    $phnum = $_POST['phnum'];
	$pr_id = $_POST['pr_id'];
	$conn=mysqli_connect("localhost","root","","opencart");
	$f_phnum = "SELECT * FROM `oc_product` WHERE product_id=$pr_id";
	$f_phnum = mysqli_query($conn,$f_phnum);
    $f_phnum = mysqli_fetch_assoc($f_phnum);
	$enquiry = "INSERT INTO `oc_enquiry`(`pr_id`, `c_name`, `c_phnum`, `f_phnum`) VALUES ($pr_id,'$name',$phnum,'".$f_phnum['phnum']."')";
    // echo $enquiry;
	$enquiry = mysqli_query($conn,$enquiry);
	if($enquiry)
	{
		echo "Your details are successfully submitted...The farmer will contact you";
		$username = "naveenaduri111@gmail.com";
		$hash = "ba1475525039fbdb31c9dbd7a60a0e51a66332a7485b5527f959cb1f5b0479da";

		// Config variables. Consult http://api.textlocal.in/docs for more info.
		$test = "0";
        $mob=$f_phnum['phnum'];
		// Data for text message. This is the text message data.
		$sender = "TXTLCL"; // This is who the message appears to be from.
		$numbers = "$mob"; // A single number or a comma-seperated list of numbers
		$message = "You had Recieved the Product Enquiry from the number"."$phnum";
		// 612 chars or less
		// A single number or a comma-seperated list of numbers
		$message = urlencode($message);
		$data = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;
		$ch = curl_init('http://api.textlocal.in/send/?' . $data);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); // This is the result from the API
		// echo $result."<br>";
		curl_close($ch);
	}
	else{
		echo "Error! Retry";
	}
	
?>