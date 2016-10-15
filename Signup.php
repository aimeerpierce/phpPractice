<?php
$username = $_GET['user'];
$password = $_GET['psw'];
$keyString = file_get_contents('phpseclib.zip');

$keyArray = explode(" ",$keyString);
$length = $keyArray.length;
$count = 0;
while($count<)
$data = $username.":".$password.":".$keyArray[0].":".$keyArray[1];

file_put_contents(filename, data)

?>