<?php
	$filename = $_POST['filename'];
	$list = scandir("../sections/");
	$newlist = array();
	$a=1;
	foreach($list as $file)
	{
		if ( $file != "." && $file != ".." && !is_dir("../sections/".$file) )
		{
			$newlist[$a]['oldfn'] = $file;
			$newfilename = sprintf("%03d",$a).".".substr($file,4,strlen($file));
			if ( $file == $filename )
			{
				if ($a > 1)
				{
					$newlist[$a]['newfn'] = sprintf("%03d",$a-1).".".substr($file,4,strlen($file));
					$newlist[$a-1]['newfn'] = sprintf("%03d",$a).".".substr($newlist[$a-1]['newfn'],4,strlen($newlist[$a-1]['newfn']));
				}
			}
			else
			{
				$newlist[$a]['newfn'] = $newfilename;	
			}
			$a++;	
		}
	}
	foreach ($newlist as $a)
	{
		if ( $a['newfn'] != $a['oldfn'] )
		{
			rename("../sections/".$a['oldfn'],"../sections/".$a['newfn']);
		}	
	}
	echo "section";
?>