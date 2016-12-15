<?
if (isset($_POST['type']))
{
	if ($_POST['type'] == 'section')
	{
		$prefix="../sections/";
		$oldname = $prefix.str_replace("\'","¤",$_POST['oldname']);
		$newname = $prefix.substr($_POST['oldname'],0,4).urlencode(str_replace("\'","¤",$_POST['newname'])).".php";
		@rename( $prefix.substr(str_replace("\'","¤",$_POST['oldname']),4,-4), $prefix.urlencode(str_replace("\'","¤",$_POST['newname'])));
		$msg="section";
	}
	if ($_POST['type'] == 'file')
	{
		$prefix="../files/";
		$oldname = $prefix.str_replace("\'","¤",$_POST['oldname']);
		$newname = $prefix.urlencode(str_replace("\'","¤",$_POST['newname'])).".php";
		$msg="file";
	}
}
else
{
	$prefix = "../sections/".$_POST['section']."/";
	$oldname = $prefix.str_replace("\'","¤",$_POST['oldname']);
	$newname = $prefix.substr($_POST['oldname'],0,4).urlencode(str_replace("\'","¤",$_POST['newname'])).".php";
	$msg="section";
}

if (!file_exists($newname))
{
	@rename($oldname,$newname);
	echo $msg;
}
else
{
	echo "ERR:File already exists";
}
