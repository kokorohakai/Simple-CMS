<?
//error_reporting(0);
/*DO NOT EDIT THIS PAGE IF YOU DO NOT KNOW PHP!*/
/*DO NOT EDIT THIS PAGE IF YOU DO NOT KNOW PHP!*/
/*DO NOT EDIT THIS PAGE IF YOU DO NOT KNOW PHP!*/
/*include this code at the top of your index.php file, do not alter!*/
session_start();
require("admin/cookiemanager.php");
//this is the master file that will build the needed php variables.
require("admin/includeme.php");
if (file_exists("custom.php"))
{
	require("custom.php");
}
//begin variable settingif (!isset($_SESSION['section']))
{
	$_SESSION['section'] = FirstSection();
}
if (!isset($_SESSION['subsection']))
{
	$_SESSION['subsection'] = FirstSubSection();
}
if (isset($_GET['section']))
{
	$_SESSION['section'] = urlencode($_GET['section']);
	unset($_SESSION['subsection']);
}
if (isset($_GET['subsection']))
{
	$_SESSION['subsection'] = urlencode($_GET['subsection']);
}

$sectionlist = GenSectionList();
$sectionlist = generatelinks($sectionlist);
$sectionlist = generatemenus($sectionlist);

/*
Begin generating the file
*/

$name = "design/".$_SESSION['theme']."/mastertable.html";
$page = "";
if (file_exists($name))
{
	$fh = fopen($name,'r');
	$page = fread( $fh, filesize($name));
}
else
{
	$page='<html><head><javascript></head><body><banner><linkframe><bodyframe></body></html>';
}
//inject the link frame
$name = "design/".$_SESSION['theme']."/linkframe.html";
$linkframe = "";
if (file_exists($name))
{
	$fh = fopen($name,'r');
	$linkframe = '<div class="linkframe" style="display:inline;">';
	$linkframe.= fread( $fh, filesize($name));
	$linkframe.='</div>'."\n";
}
else
{
	$linkframe='<div class="linkframe" style="display:inline;"><links></div>'."\n";
}
//inject the links
$thelinks = '<div class="links" style="display:inline;">';
foreach ($sectionlist as $id=>$n)
{
	$thelinks.=$n['linkhtml'];
	$thelinks.=$n['menu'];
}
$thelinks.= '</div>'."\n";
$linkframe = str_replace("<links>",$thelinks,$linkframe);
$page = str_replace("<linkframe>",$linkframe,$page);

//inject the banner
$name = "design/".$_SESSION['theme']."/banner.html";
$banner = "";
if (file_exists($name))
{
	$fh = fopen($name,'r');
	$banner = '<div class="banner" onmouseover="closemenus();">';
	$banner.= fread( $fh, filesize($name));
	$banner.='</div>'."\n";
}
else
{
	$banner = '<div class="banner" onmouseover="closemenus();"></div>'."\n";	
}
$page=str_replace("<banner>",$banner,$page);

//inject the body frame
$name = "design/".$_SESSION['theme']."/bodyframe.html";
$bodyframe = "";
if (file_exists($name))
{
	$fh = fopen($name,'r');
	$bodyframe = '<div class="bodyframe" onmouseover="closemenus();">';
	$bodyframe.= fread( $fh, filesize($name));
	$bodyframe.='</div>'."\n";
}
else
{
	$bodyframe = '<div class="bodyframe" onmouseover="closemenus();"><bodytext></div>'."\n";
}
$page=str_replace("<bodyframe>",$bodyframe,$page);

//inject the body text, we explode it here so we can preserve any php that might have actually been used in the CMS admin interface by doing a require();
$javascript='<script type="text/javascript" language="javascript" src="admin/scripts/prototype.js"></script>'.
			'<script type="text/javascript" language="javascript" src="admin/scripts/master.js"></script>'.
			'<script type="text/javascript" language="javascript" src="design/'.$_SESSION['theme'].'/master.js"></script>'.
			'<script type="text/javascript" language="javascript" src="admin/scripts/MenuTypes/'.$_SESSION['menustyle'].'.js"></script>';
$page=str_replace("<javascript>",$javascript,$page);
$page = explode("<bodytext>",$page);
echo $page[0];
if (!isset($_GET['file']))
{
	if ( isset($_SESSION['subsection']) )
	{
		if (isset($sectionlist[$_SESSION['section']]['sub'][$_SESSION['subsection']]['file']))
		{
			$filename=$sectionlist[$_SESSION['section']]['sub'][$_SESSION['subsection']]['file'];
			
		}
	}
	else
	{
		if (isset($sectionlist[$_SESSION['section']]['file']))
		{
			$filename=$sectionlist[$_SESSION['section']]['file'];
		}
	}
}
else
{
	$filename="files/".stripslashes($_GET['file']);
}
if (file_exists($filename))
{
	require($filename);
}
else
{
	require("404.php");
}
//lets just drop the code to manage menus here.
//then the rest of the page.
$js='<script type="text/javascript" language="javascript">';
$js.="$$('.tcolor').each(function(e){e.style.backgroundColor = '#".$_SESSION['tcolor']."';});";
$js.='</script>';
$page[1]=str_replace("</body>",$js."</body>",$page[1]);
echo $page[1];
/*DO NOT EDIT THIS PAGE IF YOU DO NOT KNOW PHP!*/
/*DO NOT EDIT THIS PAGE IF YOU DO NOT KNOW PHP!*/
/*DO NOT EDIT THIS PAGE IF YOU DO NOT KNOW PHP!*/
?>