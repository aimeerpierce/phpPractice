<?php

//extract phpseclib.zip file to access the phpseclib library and use the RSA.php file methods
$path = './phpseclib/phpseclib';
	set_include_path($path);
	include('Crypt/RSA.php');

	$rsa = new Crypt_RSA();
	$rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
	$rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);
	extract($rsa->createKey()); /// makes $publickey and $privatekey available1024

//Private key
$private_key = $privatekey;
$public_key = $publickey;

//create array of user data to be sent to users.txt
$arr = array(
	//$_POST['name'] gets the "name" value from the JSON object 'user,' sent from Signup.html
	"name" => $_POST['name'],
	"password" => $_POST['password'],
	"publickey" => $public_key,
	"privatekey" => $private_key,
);

//file_get_contents returns the data from users.txt in a string
$users = file_get_contents('users.txt');

if($users){
	//use json_decode to turn $users string into a PHP variable
	$users = json_decode($users);

	//add the new user, $arr, to the $users array
	array_push($users, $arr);

	//put back all of the data in $users to users.txt
	//this setup allows for users.txt file to contain an array of JSON objects that are properly formatted. 
	//the format is important when accessing users.txt in the checkLogin.php file
	file_put_contents('users.txt',json_encode($users));

} else {
	//if there are no users in users.txt ($arr is the first user) call file_put_contents to an array of $arr
	file_put_contents('users.txt',json_encode(array($arr)));
}
echo json_encode($arr);

?>