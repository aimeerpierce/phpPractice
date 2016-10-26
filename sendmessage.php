
<?php
//session_start();
//echo $_REQUEST["send"];
$return = array(
	"status"=>false
);
	//$dataa =  $_POST['data'];
	//echo $dataa -> send;
$path = 'phpseclib';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);
include_once('Crypt/RSA.php');
//$_SESSION['test'] = $_POST['sender'];
				//$data = array(
    				//"sender" => $_POST['sender'],
    				//"receiver" => $_POST['receiver'],
    				//"date" => $_POST['date'],
    				//"body" =>$_POST['body']
					//"sender" => $dataa -> send,
    				//"receiver" => $dataa -> receive,
    				//"date" => $dataa -> date,
    				//"body" =>$dataa -> message
    			//);

				$users = file_get_contents('users.txt');
				if($users){
					$users = json_decode($users);
					foreach($users as $user){
						if(strcmp($user->name,$_POST['receiver'])==0){
							$public_key = $user->publickey;
							//var_dump($public_key);
							$encrypt = rsa_encrypt(json_encode($_POST['body']),$public_key);

							//$data['body'] = rsa_encrypt($data['body'],$public_key);

							//$data = array(
								//"sender" => $_POST['sender'],
								//"receiver" => $_POST['receiver'],
								//"date" => $_POST['date'],
								//"body" => $encrypt,
								//"body" =>$_POST['body']
								//);

							//$messages = file_get_contents('messages.txt');
							//$messages =
							//if($messages){
								//$messages = json_decode($messages);
								//array_push($messages, $data);
								//$messages = json_encode($messages);
								//file_put_contents('messages.txt',json_encode($messages));
							//} else {
							//	file_put_contents('messages.txt',json_encode(array($data)) );
								//file_put_contents('messages.txt',$data );
							//}

							file_put_contents('messages.txt',$_POST['sender']."delimiter". $_POST['receiver']."delimiter".$_POST['date']."delimiter".$encrypt."delimiterForEachMsg",FILE_APPEND);
						}
					}

					//$messages = file_get_contents('messages.txt');
					//if($messages){
					//	$messages = json_decode($messages);
					//	array_push($messages, $encrypt);
					//	file_put_contents('messages.txt',json_encode($messages));

					//} else {
					//	file_put_contents('messages.txt',json_encode(array($messages)));
					//}

				}

				function rsa_encrypt($string, $public_key)
				{
					//Create an instance of the RSA cypher and load the key into it
					$cipher = new Crypt_RSA();
					$cipher->loadKey($public_key);
					//Set the encryption mode
					$cipher->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
					//Return the encrypted version
					return $cipher->encrypt($string);
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
				echo json_encode($return);
?>

