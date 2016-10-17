

<?php
//read users.txt file and check user/password
//return json object with success/failure info

//create array to return 
$return = array(
	"status"=>false
);

//get users from users.txt
$users = file_get_contents('users.txt');

//if there are users, parse through to check if username is present
if($users){

	//turn string into PHP variable
	$users = json_decode($users);

	//for each JSON object, check to see if the name of the user is the same as the name of the post
	//likewise for the password
	foreach($users as $user){
	 	if(strcmp($user->name,$_POST['name']) == 0 && strcmp($user->password, $_POST['password']) == 0){
	 		$return["status"] = true;
	 	}
	}
}

//return the JSON object of the php array $return
echo json_encode($return);

?>