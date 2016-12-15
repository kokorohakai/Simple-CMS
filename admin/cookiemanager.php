<?
function loadsitedata()
{
	if (file_exists("admin/config/options.dat"))
	{
		$fh=fopen("admin/config/options.dat","r");
		$data=fread($fh,filesize("admin/config/options.dat"));
		$peices = explode("\n",$data);
		foreach ($peices as $peice)
		{
			if (strlen($peice) > 1)
			{
				$p = explode("=",$peice);
				$_SESSION[$p[0]]=$p[1];
			}
		}
	}
	else
	{
		$_SESSION['theme'] = "default";
		$_SESSION['menustyle']= "fade";
		$_SESSION['tcolor']= "6F6F6F";
	}
}

if ( isset ( $_POST['theme'] ) )
{
	$_SESSION['theme'] = $_POST['theme'];
	$_SESSION['menustyle'] = $_POST['menustyle'];
	$_SESSION['tcolor'] = $_POST['tcolor'];
	if ( isset($_POST['savecookie']) )
	{
		if ($_POST['savecookie'] == "on")
		{
			setcookie('theme',$_POST['theme'],time()+60*60*24*9999);
			setcookie('menustyle',$_POST['menustyle'],time()+60*60*24*9999);
			setcookie('tcolor',$_POST['tcolor'],time()+60*60*24*9999);
		}
	}
	else
	{
		if ( isset( $_COOKIE['theme'] ) )
		{
			setcookie( 'theme','', time() - 3600 );
			setcookie( 'menustyle','', time() - 3600 );
			setcookie( 'tcolor','', time() - 3600 );
			unset( $_COOKIE['theme'] );
			unset( $_COOKIE['menustyle'] );
			unset( $_COOKIE['tcolor'] );
		}
	}
}

if (!isset($_SESSION['theme']))
{
	if (isset($_COOKIE['theme']))
	{
		$_SESSION['theme'] = $_COOKIE['theme'];
		$_SESSION['menustyle'] = $_COOKIE['menustyle'];
		$_SESSION['tcolor'] = $_COOKIE['tcolor'];
	}
	else
	{
		loadsitedata();
	}
}
?>