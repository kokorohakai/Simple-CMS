<?php
$thefilename = urlencode(str_replace("\'","¤",$_POST['filename']));

$testfile = $thefilename;

$list = scandir("../sections/".$_POST['section']);
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
	$n = sprintf("%03d",$n);
	$file = "../sections/".$_POST['section']."/".$n.".".$testfile.".php";
	$filehandle = fopen($file,"w");
	fwrite($filehandle,"This is a blank file");
	fclose($filehandle);
	echo "section";
}
?>