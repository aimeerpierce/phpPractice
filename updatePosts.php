<?php
$return = array(
	"status"=>true
);


$command = $_POST['command'];

if(strcmp($command,"delete")==0) {
	$id = $_POST['id'];
	$index = $_POST['index'];
	$user = $_POST['user'];
	$title = $_POST['title'];
	$post = $_POST['post'];
	$time = $_POST['time'];

	$posts = file_get_contents('posts.txt');
	$posts = json_decode($posts,true);
	$count = 0;
	//$newPost = array();
	//$newPost = json_decode('[]' );

	foreach( $posts as $post){

		//if($count==1) $newPost=$post;
		//if( $index==0 &&  $count==2 ) $newPost=$post;

		//if( $index==1 && count($posts)==1 ) file_put_contents("");
		//else if( $index==1 && count($posts)>1) {
		//	//$newPost = $posts[1];
		//	$index = 0;
		//}

		//else if( !$count==1 && !$count==$index){
		//	$newPost = array_push($newPost,$post);
		//}

		if( $id == $post['id'] ){
			break;
		}
		$count++;
	}
	//if( $index==1 && count($posts)==1 ) file_put_contents("");
	//else file_put_contents('posts.txt',json_encode($newPost));
	unset($posts[$count]);
	file_put_contents('posts.txt',json_encode( $posts ));
}
else if( strcmp($command,"modify")==0 ){
	$id = $_POST['id'];
	//$index = $_POST['index'];
	$user = $_POST['user'];
	$title = $_POST['title'];
	$body = $_POST['post'];
	$time = $_POST['time'];

	$posts = file_get_contents('posts.txt');
	$count = 0;
	//if($posts){
		$posts = json_decode($posts,true);
		foreach($posts as $post){

			if( strcmp($id,$post['id'])==0){
				//var_dump($id);
				//$post['body'] = $post;
				//$post -> post = $_POST['post'];
				$posts[$count]['post'] = $_POST['post'];

				//var_dump($post['post']);
			}
			$count++;
			//var_dump($post['post']);
		}
		//$posts = json_encode($posts);
		//var_dump($posts[0]['post']);
		file_put_contents('posts.txt',json_encode($posts));
	//}
	//else{

	//}
}
else{ //otherwise make a new post
	$id = $_POST['id'];
	$user = $_POST['user'];
	$title = $_POST['title'];
	$post = $_POST['post'];
	$time = $_POST['time'];

	$data = array(
		'id' => $id,
		'user' => $user,
		'title' => $title,
		'post' => $post,
		'time' => $time,
	);

	$posts = file_get_contents('posts.txt');

	if($posts){
		$posts = json_decode($posts,true);
		array_push($posts, $data);
		file_put_contents('posts.txt',json_encode($posts));
	} else {
		//var_dump($data);
		file_put_contents('posts.txt',json_encode(array($data)));
	}
}


//$newPost = $_POST['data'];
//foreach($_SESSION['posts'] as $post){
//	if( strcmp($newPost,$post)==0 ){


echo json_encode($return);

?>