<?php
$route = '/audio/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();

	if(isset($_REQUEST['query'])){ $query = $_REQUEST['query']; } else { $query = '';}
			
	if($query=='')
		{
		$Query = "SELECT * FROM audio WHERE name LIKE '%" . $query . "%' OR description LIKE '%" . $query . "%'";
		}
	else 
		{
		$Query = "SELECT * FROM audio";		
		}
		
	$Query .= " ORDER BY name ASC";
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
		
		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});

$route = '/audio/';	
$app->post($route, function () use ($app){

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
		
		$ReturnObject = array();												
		$ReturnObject['message'] = "Audio Added!";
		$ReturnObject['audio_id'] = $audio_id;	
					
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));				

	});

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
	
//
// Begin tags
//		
	
$route = '/audio/tags/';
$app->get($route, function ()  use ($app){

	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	

	$Query = "SELECT t.tag_id, t.tag, count(*) AS Profile_Count from tags t";
	$Query .= " INNER JOIN audio_tag_pivot ctp ON t.tag_id = ctp.tag_id";
	$Query .= " GROUP BY t.tag ORDER BY count(*) DESC";

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());
	  
	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$tag_id = $Database['tag_id'];
		$tag = $Database['tag'];
		$profile_count = $Database['Profile_Count'];

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['profile_count'] = $profile_count;
		
		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});	
	
$route = '/audio/tags/:tag';
$app->delete($route, function ($tag)  use ($app){

	$ReturnObject = array();
	
 	$request = $app->request(); 
 	$params = $request->params();	

	$Query = "SELECT t.tag_id, t.tag FROM tags WHERE tag = '" . trim(mysql_real_escape_string($tag)) . "'";

	$tagResult = mysql_query($LinkQuery) or die('Query failed: ' . mysql_error());
		
	if($tagResult && mysql_num_rows($tagResult))
		{	
		$tag = mysql_fetch_assoc($tagResult);
		$tag_id = $tag['tag_id'];
		$tag_Text = $tag['tag'];

		$DeleteQuery = "DELETE FROM audio_tag_pivot WHERE tag_id = " . $tag_id;
		$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());
			
		$DeleteQuery = "DELETE FROM tags WHERE tag = '" . trim(mysql_real_escape_string($tag)) . "'";
		$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());			

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag_Text;
		$F['profile_count'] = 0;
		
		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});
	
$route = '/audio/:audio_id/tags/';
$app->get($route, function ($audio_id)  use ($app){


	$ReturnObject = array();
		
	$Query = "SELECT t.tag_id, t.tag, count(*) AS Profile_Count from tags t";
	$Query .= " JOIN audio_tag_pivot ptp ON t.tag_id = ptp.tag_id";
	$Query .= " WHERE ptp.audio_id = " . $audio_id;
	$Query .= " GROUP BY t.tag ORDER BY count(*) DESC";

	$DatabaseResult = mysql_query($Query) or die('Query failed: ' . mysql_error());
	  
	while ($Database = mysql_fetch_assoc($DatabaseResult))
		{

		$tag_id = $Database['tag_id'];
		$tag = $Database['tag'];
		$audio_count = $Database['Profile_Count'];

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['audio_count'] = $audio_count;
		
		array_push($ReturnObject, $F);
		}

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});	
		
$route = '/audio/:audio_id/tags/';
$app->post($route, function ($audio_id)  use ($app){


	$ReturnObject = array();
		
 	$request = $app->request(); 
 	$param = $request->params();	
	
	if(isset($param['tag']))
		{
		$tag = trim(mysql_real_escape_string($param['tag']));
			
		$ChecktagQuery = "SELECT tag_id FROM tags where tag = '" . $tag . "'";
		$ChecktagResults = mysql_query($ChecktagQuery) or die('Query failed: ' . mysql_error());		
		if($ChecktagResults && mysql_num_rows($ChecktagResults))
			{
			$tag = mysql_fetch_assoc($ChecktagResults);		
			$tag_id = $tag['tag_id'];
			}
		else
			{

			$query = "INSERT INTO tags(tag) VALUES('" . $tag . "'); ";
			mysql_query($query) or die('Query failed: ' . mysql_error());	
			$tag_id = mysql_insert_id();			
			}

		$ChecktagPivotQuery = "SELECT * FROM audio_tag_pivot where tag_id = " . trim($tag_id) . " AND audio_id = " . $audio_id;
		$ChecktagPivotResult = mysql_query($ChecktagPivotQuery) or die('Query failed: ' . mysql_error());
		
		if($ChecktagPivotResult && mysql_num_rows($ChecktagPivotResult))
			{
			$ChecktagPivot = mysql_fetch_assoc($ChecktagPivotResult);		
			}
		else
			{
			$query = "INSERT INTO audio_tag_pivot(tag_id,audio_id) VALUES(" . $tag_id . "," . $audio_id . "); ";
			mysql_query($query) or die('Query failed: ' . mysql_error());					
			}

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['audio_count'] = 0;
		
		array_push($ReturnObject, $F);

		}		

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});	
	
$route = '/audio/:audio_id/tags/:tag/';
$app->delete($route, function ($audio_id,$tag)  use ($app){


	$ReturnObject = array();
		
 	$request = $app->request(); 
 	$param = $request->params();	
	
	if(isset($tag))
		{
			
		$tag = trim(mysql_real_escape_string($tag));
			
		$ChecktagQuery = "SELECT tag_id FROM tags where tag = '" . $tag . "'";
		$ChecktagResults = mysql_query($ChecktagQuery) or die('Query failed: ' . mysql_error());		
		if($ChecktagResults && mysql_num_rows($ChecktagResults))
			{
			$tag = mysql_fetch_assoc($ChecktagResults);		
			$tag_id = $tag['tag_id'];

			$DeleteQuery = "DELETE FROM audio_tag_pivot WHERE tag_id = " . trim($tag_id) . " AND audio_id = " . trim($audio_id);
			$DeleteResult = mysql_query($DeleteQuery) or die('Query failed: ' . mysql_error());
			}

		$F = array();
		$F['tag_id'] = $tag_id;
		$F['tag'] = $tag;
		$F['profile_count'] = 0;
		
		array_push($ReturnObject, $F);

		}		

		$app->response()->header("Content-Type", "application/json");
		echo stripslashes(format_json(json_encode($ReturnObject)));
	});		
	
//
// End tags
//			
?>
