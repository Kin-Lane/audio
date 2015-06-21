<?php
$route = '/audio/:audio_id/';
$app->put($route, function ($audio_id) use ($app){
	
 	$request = $app->request(); 
 	$_POST = $request->params();	
	
	if(isset($_POST['name'])){ $name = $_POST['name']; } else { $name = ''; }
	if(isset($_POST['description'])){ $description = $_POST['description']; } else { $description = ''; }		
	if(isset($_POST['url'])){ $url = $_POST['url']; } else { $url = ''; }
	if(isset($_POST['thumbnailUrl'])){ $thumbnailUrl = $_POST['thumbnailUrl']; } else { $thumbnailUrl = ''; }
	if(isset($_POST['creator'])){ $creator = $_POST['creator']; } else { $creator = ''; }

  	$LinkQuery = "SELECT * FROM audio WHERE audio_id = " . $audio_id;
	//echo $LinkQuery . "<br />";
	$LinkResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());
	
	if($LinkResult && mysql_num_rows($LinkResult))
		{	
		$query = "UPDATE audio SET ";

		if(isset($name))
			{
			$query .= "name='" . mysql_real_escape_string($name) . "'"; 
			} 
		if(isset($description))
			{
			$query .= ",description='" . mysql_real_escape_string($description) . "'"; 
			} 
		if(isset($url))
			{
			$query .= ",url='" . mysql_real_escape_string($url) . "'"; 
			} 
		if(isset($thumbnailUrl))
			{
			$query .= ",thumbnailUrl='" . mysql_real_escape_string($thumbnailUrl) . "'"; 
			} 						
		if(isset($creator))
			{
			$query .= ",creator='" . mysql_real_escape_string($creator) . "'"; 
			} 	
		
		$query .= " WHERE audio_id = " . $audio_id;
		
		//echo $query . "<br />";
		mysql_query($query) or die('Query failed: ' . mysql_error());
		
		$ReturnObject = array();												
		$ReturnObject['message'] = "Audio Updated!";
		$ReturnObject['audio_id'] = $audio_id;			
					
		}
	else 
		{	
		$Link = mysql_fetch_assoc($LinkResult);	
			
		$ReturnObject = array();												
		$ReturnObject['message'] = "Audio Doesn't Exist!";			
		$ReturnObject['audio_id'] = $audio_id;	
		
		}		

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));	
		
	});
?>