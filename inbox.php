<html>
<head>
	<title>Inbox</title>
</head>
<body>

	<?php
	session_start();
	//var_dump($_SESSION['username']);
	//var_dump($_SESSION['privatekey']);

	$path = 'phpseclib';
	set_include_path(get_include_path() . PATH_SEPARATOR . $path);
	include_once('Crypt/RSA.php');
	$messages = file_get_contents('messages.txt');
	$messageArray = explode("delimiterForEachMsg",$messages);
	if(!strcmp($messages,"")==0){

		$count = count($messageArray);


		for( $i=0; $i<$count-1; $i++){

			$message = explode("delimiter",$messageArray[$i]);

			if( strcmp($message[1],$_SESSION['username'])==0){
				//var_dump($_SESSION['privatekey']);
				echo "<p>"."From ".$message[0]."(".$message[2]."): ".rsa_decrypt($message[3],$_SESSION['privatekey'])."</p>";
			}
		}
	}
	else{
		echo "No Message.";
	}

	function rsa_decrypt($string, $private_key)
	{
		//Create an instance of the RSA cypher and load the key into it
		$cipher = new Crypt_RSA();
		$cipher->loadKey($private_key);
		//Set the encryption mode
		$cipher->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
		//Return the decrypted version
		return $cipher->decrypt($string);
}

	?>
	<p></p>
	<input type="button" onclick="backHandler()" value="Back" />

	<script>
    	function backHandler() {
    		window.location = 'viewPosts.php';
    	}
	</script>
</body>
</html>