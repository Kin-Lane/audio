<?php
$route = '/audio/:audio_id/';
$app->delete($route, function ($audio_id) use ($app){
	
	$ReturnObject = array();

	$query = "DELETE FROM audio WHERE audio_id = " . $audio_id;
	//echo $query . "<br />";
	mysql_query($query) or die('Query failed: ' . mysql_error());	

	$ReturnObject = array();												
	$ReturnObject['message'] = "Audio Deleted!";			
	$ReturnObject['audio_id'] = $audio_id;	

	$app->response()->header("Content-Type", "application/json");
	echo stripslashes(format_json(json_encode($ReturnObject)));	

	});	
?>