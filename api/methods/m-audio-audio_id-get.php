<?php
$route = '/audio/:audio_id/';
$app->get($route, function ($audio_id)  use ($app){


	$ReturnObject = array();
		
	$Query = "SELECT * FROM audio WHERE audio_id = " . $audio_id;
	//echo $Query . "<br />";
	
	$AudioResult = mysql_query($Query) or die('Query failed: ' . mysql_error());
	  
	while ($Audio = mysql_fetch_assoc($AudioResult))
		{
			
		$audio_id = $Audio['audio_id'];	
		$name = $Audio['name'];
		$description = $Audio['description'];	
		$url = $Audio['url'];
		$thumbnailUrl = $Audio['thumbnailUrl'];
		$creator = $Audio['creator'];
		
		// manipulation zone
		
		$F = array();
		$F['audio_id'] = $audio_id;
		$F['name'] = $name;
		$F['description'] = $description;
		$F['url'] = $url;
		$F['thumbnailUrl'] = $thumbnailUrl;
		$F['creator'] = $creator;
		
		
		$ReturnObject = $F;
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
?>