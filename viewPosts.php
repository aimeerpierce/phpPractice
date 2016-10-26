<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<style>
#posts{
	border: 2px solid Aqua; 
	border-radius: 5px;
	width:500px;
	padding: 5px;
	overflow-wrap: break-word;
}
    h1,p {
        width: 500px;
    }
</style>
</head>
<body>

	<?php
		session_start();
    ?>

	<p style="float: right; width: 20%" ">
		User: <?php echo $_SESSION['username'] ?>
		<input type="button" id="logout" value="Log out" />
	</p>
	 
	<h1>Posts</h1>	

    <div style="width: 100%;">
        <div style="float:left; width: 50%">
			<!--
			<p>
				<textarea id="post" cols="40" rows="10"></textarea>
			</p>
			-->

			<div id="posts">
				<?php
				//session_start();

				$posts = file_get_contents('posts.txt');
				//$_SERVER['posts'] = $posts;
				$counter = 0;
				//$posts = json_decode($posts,true);
				//var_dump($posts);
				//var_dump($posts);
				if( !strcmp($posts,"[]")==0 && $posts){
					$posts = json_decode($posts);
					$_SESSION['posts'] = $posts;

					foreach($posts as $post){
						$counter += 1;
						if(strcmp($_SESSION['username'],"admin")==0){
							//echo "<p style ='font:11px/21px Arial,tahoma,sans-serif;color:#ff0000'> This is Title</p>";
							//echo "<h2>". $post->title ."</h2>";
							//echo "<p>Post Time:".$post->time."</p>";
							//echo "<p>". $post->post."<input type=\"button\" id=\"button".$counter."\" value=\"Delet\" style=\"margin-left:30px\" /></p>";

							echo "<div id=\"div".$post->id."1\"><h2>". $post->title ."</h2></div>";
							echo "<div id=\"div".$post->id."2\">Post Time:".$post->time."</div>";
							//echo "<div id=\"div".$counter."3\">". $post->post."</div><input type=\"button\" id=\"delete".$counter."\"value=\"Delete\" style=\"margin-top:30px\" />";
							echo "<div id=\"div".$post->id."3\">". $post->post."</div>";
							echo "<div id=\"div".$post->id."4\"> <input type=\"button\" id=\"delete".$counter."\"value=\"Delete\" onclick=\"$(this).deletePost(". $counter .")\" style=\"margin-top:30px\" /> </div>";

						}
						else{
							//echo "<p style ='font:20px/21px Arial,tahoma,sans-serif;color:#ff0000'> This is Title</p>";
							//echo "<div id=\"div".$post->id."1\"><h2>". $post->title ."</h2></div>";
							//echo "<p>Post Time:".$post->time."</p>";
							//echo "<div id=\"div".$post->id."2\">". $post->post."</div>";

							echo "<div id=\"div".$post->id."1\"><h2>". $post->title ."</h2></div>";
							echo "<div id=\"div".$post->id."2\">Post Time:".$post->time."</div>";
							//echo "<div id=\"div".$counter."3\">". $post->post."</div><input type=\"button\" id=\"delete".$counter."\"value=\"Delete\" style=\"margin-top:30px\" />";
							echo "<div id=\"div".$post->id."3\">". $post->post."</div>";
							//echo "<div id=\"div".$post->id."4\"> <input type=\"button\" id=\"delete".$counter."\"value=\"Delete\" style=\"margin-top:30px\" /> </div>";


							if( strcmp($_SESSION['username'],$post->user)==0){
								echo "<input type=\"button\" id=\"modify".$counter."\"value=\"Modify\" onclick=\"$(this).update(". $counter .")\" style=\"margin-top:30px\" />";
							}
						}
					}
					$_SESSION['counter'] =$post->id;
				}
				//$_SESSION['counter'] = $counter;
				if(count($posts)==0) $_SESSION['counter'] = 0;
				?>
			</div>

			<h1>Send Post Here: </h1>
			<p>Title:<input id="title" style="width:450px" /></p>
			<p><textarea id="post" rows="10" style="width:500px"></textarea></p>
			<input type="button" id="enter" value="Enter" />

        </div>
        <div2 style="float:right;" >
			<h1>Send Message</h1>
			<p>From </p>
			<input id="sender" value="<?php echo $_SESSION['username'] ?>" />
			<p>To   </p>
			<input id="receiver" />
			<p>Message:</p>
			<p>
				<textarea id="messageBox" cols="40" rows="5"></textarea>
			</p>
			<p>
				<input id="sendButton" type="button" value="Send" />
				<input type="button" id="inbox" value="Inbox" />
			</p>
        </div2>
    </div>
	<div style="clear:both"></div>

	<script>
    	var counter = "<?php echo $_SESSION['counter'] ?>";

		//function handler(){
		//	$.ajax({
		//		type:'POST',
		//		url:"updatePosts.php",
		//		dataType: 'json',
		//		data: user,
		//	});
		//}
		$(document).ready(function () {
			$('#sendButton').click(function () {
				var d = new Date();
				var send = document.getElementById("sender").value;
				var receive = document.getElementById("receiver").value;
				var message = document.getElementById("messageBox").value;
				var date = d.getHours() + ":" + d.getMinutes();

				var msg = {
					sender: send,
					receiver: receive,
					date: date,
					body: message
				};

				$.ajax({
					type: 'POST',
					url: "sendmessage.php",
					dataType: 'json',
					data: msg,
					success: function (data) {
						console.log(data);
						alert("succeed");
						document.getElementById("receiver").value = "";
						document.getElementById("messageBox").value = "";
					},
					error:function(XMLHttpRequest, textStatus, errorThrown) {
						alert(XMLHttpRequest.responseText);
						document.write(XMLHttpRequest.responseText);
				}
				});
			});

			$('#inbox').click(function () {
				window.location.href = 'inbox.php';
			});

			$('#logout').click(function () {
				window.location.href = 'logout.php';
			});

			$('#enter').click(function () {
				var user = "<?php echo $_SESSION['username'] ?>";
				var newPost = document.getElementById("post").value;
				var title = document.getElementById("title").value;
				var d = new Date();
				var date = d.getHours() + ":" + d.getMinutes();
				//var counter = "<?php echo $_SESSION['counter'] ?>";
				//var counter = "<?php echo $_SESSION['counter'] ?>";
				counter++;

				var data = {
					command:"add",
					id:counter,
					user: user,
					title:title,
					post: newPost,
					time:date
				};

				$.ajax({
					type: 'POST',
					url: "updatePosts.php",
					dataType: 'json',
					data: data,
					success: function (data) {
						console.log(data);
						alert("succeed");
						var html = $('#posts').html();
						//html += "<h2>"+ title +"</h2>";
						html += "<div id=\"div"+ counter + "1\"><h2>"+ title +"</h2></div>"

						//html +=  "<p>Post Time:" + date + "</p>";
						html += "<div id=\"div"+ counter + "2\">Post Time:" + date + "</div>";
						html += "<div id=\"div"+ counter +"3\">"+ newPost + "</div>";
						if( "<?php echo $_SESSION['username'] ?>"==="admin" ) {
							//html += "<p>"+ newPost + "<input type=\"button\" id=\"delete"+ counter + "\" value=\"Delet\" style=\"margin-left:30px\" /></p>";

							//echo "<div id=\"div".$post->id."1\"><h2>". $post->title ."</h2></div>";
							//echo "<div id=\"div".$post->id."2\">Post Time:".$post->time."</div>";
							//echo "<div id=\"div".$counter."3\">". $post->post."</div><input type=\"button\" id=\"delete".$counter."\"value=\"Delete\" style=\"margin-top:30px\" />";
							//echo "<div id=\"div".$post->id."3\">". $post->post."</div>";
							html += "<div id=\"div" + counter + "4\"> <input type=\"button\" id=\"delete" + counter + "\"value=\"Delete\" onclick=\"$(this).deletePost(" + counter + ")\" style=\"margin-top:30px\" /> </div>";
						}
						else{
							//html += "<p>"+ newPost + "<input type=\"button\" id=\"button"+ counter + "\" value=\"modify\" style=\"margin-left:30px\" /></p>";
							html +=  "<div id=\"div"+ counter +"4\"> <input type=\"button\" id=\"modify"+ counter +"\"value=\"Modify\" onclick=\"$(this).update("+ counter +")\" style=\"margin-top:30px\" /> </div>";
						}
						$('#posts').html(
							html
						);
						document.getElementById("post").value = "";
						document.getElementById("title").value = "";
					},
					error:function(XMLHttpRequest, textStatus, errorThrown) {
						alert(XMLHttpRequest.responseText);
						document.write(XMLHttpRequest.responseText);
					}
				});

			});

			//for( var i=0; i<= <?php echo $_SESSION['counter'] ?>; i++){
			//	$('#modify'+i).click(function () {
			//		update(this);
			//	});
			//}
			$.fn.update = function(that){
			//function update(that){
				//$('#posts').html("");
				//var id = $(that).attr('id').substring(6);
				var id = that
				//alert(id);
				var d = new Date();
				var date = d.getHours() + ":" + d.getMinutes();
				var updatedPost = prompt("enter updated post:");

				var data = {
					command:"modify",
					id:id,
					//index: that,
					user: "user",
					title:"title",
					post: updatedPost,
					time: date
				};

				$.ajax({
					type: 'POST',
					url: "updatePosts.php",
					dataType: 'json',
					data: data,
					success: function (data) {
						console.log(data);
						alert("succeed");
						$('#div'+id+'3').html(updatedPost);
						//divClicked(id);
					},
					error:function(XMLHttpRequest, textStatus, errorThrown) {
						alert(XMLHttpRequest.responseText);
						document.write(XMLHttpRequest.responseText);
					}
				});

				//alert(updatedPost);
			}

			function divClicked(id) {
				
				//alert('#div'+id+'2');
				//var divHtml = $('#div'+id+'2').html();
				//var divHtml = $('#div'+id+'3').val(updatedPost);
				$('#div'+id+'2').html(updatedPost);
				//alert(divHtml);
				//var editableText = $("<textarea id=\"ta"+id+"\" style=\"width: 400px\" />");
				//editableText.val(divHtml);
				//$('#div'+id+'2').replaceWith(editableText);
				//editableText.focus();
				// setup the blur event for this new textarea
				//editableText.blur(editableTextBlurred(id));
				//$("#btnAddProfile").prop('value', 'Save');
				//$('#modify'+id).click(editableTextBlurred(id),editableText);
			}
			//function editableTextBlurred(id,editableText) {
			//	var html = $('#ta'+id).val();
			//	alert(html);
			//	var viewableText = $("<div id=\"div"+id+"2\">");
			//	viewableText.html(html);
			//	$(editableText).replaceWith(viewableText);
				// setup the click event for this new div
			//	$(viewableText).click(divClicked);
			//}

			$('#modyfytest').click( function(){
				var d = new Date();
				var date = d.getHours() + ":" + d.getMinutes();

				var data = {
					command:"modify",
					index: that,
					user: "user",
					title:"title",
					post: "Changed post",
					time: date
				};

				$.ajax({
					type: 'POST',
					url: "updatePosts.php",
					dataType: 'json',
					data: data,
					success: function (data) {
						console.log(data);
						alert("succeed");
					},
					error:function(XMLHttpRequest, textStatus, errorThrown) {
						alert(XMLHttpRequest.responseText);
						document.write(XMLHttpRequest.responseText);
					}
				});
			});


			//for( var i=0; i<= <?php echo $_SESSION['counter'] ?>; i++){
			//for( var i=0; i<= 1000; i++){
			//	$('#delete'+i).click(function () {
			//		deletePost(this);
			//	});
			//}

			$.fn.deletePost = function(that){
			//function deletePost(that){
				var data = {
					command:"delete",
					id: that,
					index: that,
					user: "",
					title:"",
					post: "",
					time: ""
				};

				$.ajax({
					type: 'POST',
					url: "updatePosts.php",
					dataType: 'json',
					data: data,
					success: function (data) {
						console.log(data);
						alert("succeed");

						$('#div' + that + '1').remove();
						$('#div' + that + '2').remove();
						$('#div' + that + '3').remove();
						$('#delete' + that).remove();
					},
					error:function(XMLHttpRequest, textStatus, errorThrown) {
						alert(XMLHttpRequest.responseText);
						document.write(XMLHttpRequest.responseText);
					}
				});
			}

		});
	</script>
</body>
</html>





