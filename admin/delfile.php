<?php
if ( $_POST['type'] == "section" )
{
	$section=substr( $_POST['filename'], 4, -4 );
	$list = scandir("../sections/".$section);
	foreach($list as $file)
	{
		if ( $file != "." && $file != "..")
		{
			unlink("../sections/".$section."/".$file);
		}
	}
	rmdir("../sections/".$section);
	$filename="../sections/".$_POST['filename'];
}
elseif ( $_POST['type'] == "uploaded" )
{
	$filename="../uploaded/".$_POST['filename'];
}
else
{
	$filename="../files/".$_POST['filename'];
}
if ( !file_exists( $filename ) )
{
	echo "ERR:File does not exist!\n(".$filename.")";
}
else
{
	unlink( $filename );
	echo $_POST['type'];
}


?>