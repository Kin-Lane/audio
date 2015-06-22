<?php
$route = '/audio/';	
$app->post($route, function () use ($app){

   $host = $_SERVER['HTTP_HOST'];		
 	$audio_id = decrypt($audio_id,$host);

 	$request = $app->request(); 
 	$_POST = $request->params();			
	
	if(isset($_POST['name'])){ $name = $_POST['name']; } else { $name = ''; }
	if(isset($_POST['description'])){ $description = $_POST['description']; } else { $description = ''; }		
	if(isset($_POST['url'])){ $url = $_POST['url']; } else { $url = ''; }
	if(isset($_POST['thumbnailUrl'])){ $thumbnailUrl = $_POST['thumbnailUrl']; } else { $thumbnailUrl = ''; }
	if(isset($_POST['creator'])){ $creator = $_POST['creator']; } else { $creator = ''; }
	
  	$LinkQuery = "SELECT * FROM audio WHERE url = '" . $url . "'";
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());
	
	if($LinkResult && mysql_num_rows($LinkResult))
		{	
		$Link = mysql_fetch_assoc($LinkResult);	
		
		$audio_id = $Link['audio_id'];

		$audio_id = encrypt($audio_id,$host);
			
		$ReturnObject = array();												
		$ReturnObject['message'] = "Audio Already Exists!";			
		$ReturnObject['audio_id'] = $audio_id;	
		
		}
	else 
		{				
			
		$query = "INSERT INTO audio(";		
	
		
		if(isset($name)){ $query .= "name,"; } 
		if(isset($description)){ $query .= "description,"; }
		if(isset($url)){ $query .= "url,"; }
		if(isset($thumbnailUrl)){ $query .= "thumbnailUrl,"; }
		if(isset($creator)){ $query .= "creator"; }
		
		$query .= ") VALUES(";		
		
		if(isset($name)){ $query .= "'" . mysql_real_escape_string($name) . "',"; } 
		if(isset($description)){ $query .= "'" . mysql_real_escape_string($description) . "',"; } 
		if(isset($url)){ $query .= "'" . mysql_real_escape_string($url) . "',"; }
		if(isset($thumbnailUrl)){ $query .= "'" . mysql_real_escape_string($thumbnailUrl) . "',"; }  
		if(isset($creator)){ $query .= "'" . mysql_real_escape_string($creator) . "'"; } 
		
		$query .= ")";
		
		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		$audio_id = mysql_insert_id();

      $audio_id = encrypt($audio_id,$host);
		
		$ReturnObject = array();												
		$ReturnObject['message'] = "Audio Added!";
		$ReturnObject['audio_id'] = $audio_id;	
					
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));				

	});
?>