<?php

$thefilename = urlencode(str_replace("\'","¤",$_POST['filename']));

if ( $_POST['type'] == 'file' )
{
	$file = "../files/".$thefilename.".php";
	if (file_exists($file))
	{
		echo "ERR:File already exists";
	}
	else
	{
		$filehandle = fopen($file,"w");
		fwrite($filehandle,"This is a blank file");
		fclose($filehandle);
		echo "file";
	}
}
if ( $_POST['type'] == 'section' )
{
	$testfile = $thefilename;
	
	$list = scandir("../sections/");
	$error=false;
	$n=1;
	foreach($list as $file)
	{
		if ( substr( $file, -3, strlen($file) ) == "php" )
		{
			if ( $testfile == substr( $file, 4, -4 ) )
			{
				$error=true;
				echo "ERR:File already exists";
			}
			if ( intval(substr($file,0,3)) >= $n )
			{
				$n=intval(substr($file,0,3))+1;
			}
		}
	}
	if (!$error)
	{
		@mkdir("../sections/".$testfile);
		@mkdir("../revisions/".$testfile);
		$n = sprintf("%03d",$n);
		$file = "../sections/".$n.".".$testfile.".php";
		$filehandle = fopen($file,"w");
		fwrite($filehandle,"This is a blank file");
		fclose($filehandle);
		echo "section";
	}
}
?>