<?php
$filename="../sections/".$_POST['section']."/".$_POST['filename'];

if ( !file_exists( $filename ) )
{
	echo "ERR:File does not exist!\n(".$filename.")";
}
else
{
	unlink( $filename );
	echo "section";
}


?>