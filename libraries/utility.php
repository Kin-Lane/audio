<?php

function prepareIdIn($id)
	{
	$id = str_replace(" ","+",$id);
	$id =  str_replace("~","/",$id);
	return $id;
	}

function prepareIdOut($id)
	{
	$id =  str_replace("/","%",$id);
	return $id;
	}

?>