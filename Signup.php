<?php

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

$arr = array(
	"name" => $_POST['name'],
	"password" => $_POST['password'],
	"publickey" => $public_key,
	"privatekey" => $private_key,
);

file_put_contents('users.txt', json_encode($arr),FILE_APPEND);

echo json_encode($arr);

?>