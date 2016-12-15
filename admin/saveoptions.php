<?
if ($_POST['theme'])
{
	$fh=fopen("config/options.dat","w");
	$data="";
	foreach($_POST as $opt=>$val)
	{
		$data.=$opt."=".$val."\n";
	}
	fwrite($fh,$data);
	?>
	Saved options.dat with:
	<?
	echo "<pre>".$data."</pre>";
}
?>