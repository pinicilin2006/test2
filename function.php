<?php
function num_message()
{
	$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/data.xml');
	$num = $xml->messages->message->count();
	return $num;
}

function add_message($user_name, $user_message, $parent = false)
{
	// $parent = 2;
	$id_message = num_message()+1;
	$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/data.xml');
	$message = $xml->messages->addChild('message');
	$message->addChild('id', $id_message);
	$message->addChild('time', time());
	$message->addChild('user_name', $user_name);
	$message->addChild('user_message', $user_message);
	if($parent)
	{

		if(!isset($xml->answers->{"parent_$parent"}))
		{
			$xml->answers->addChild("parent_$parent");
		}
		$xml->answers->{"parent_$parent"}->addChild('answer', $id_message);
	}
	$xml->last_message = time();
	if($xml->asXML(__DIR__.'/data.xml'))
	{
		return true;
	} else {
		return false;
	}	
}

function all_message()
{
	$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/data.xml');
	$all_data = array();
	foreach ($xml->messages->message as $mes)
	{
		
		if($xml->xpath("/data/answers/*[answer='".$mes->id."']")){
			continue;
		}
		$all_data["$mes->id"] = (array)$mes;
		if(isset($xml->answers->{"parent_$mes->id"}))
		{
			foreach ($xml->answers->{"parent_$mes->id"} as $an)
			{
				//print_r($an->answer);
				foreach($an->answer as $a)
				{
					$b = $xml->xpath("/data/messages/message[id='".$a."']");
					foreach($b as $c)
					{
						$all_data["$mes->id"]['answer'][] = (array)$c;
					}
				}
			}

		}
	}
	return $all_data;
}
?>
