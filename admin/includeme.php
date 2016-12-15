<?
function generatelinks( $sectionlist )
{
	$name = "design/".$_SESSION['theme']."/link.html";
	$linkstyle="";
	if (file_exists($name))
	{
		$fh = fopen($name,'r');
		$linkstyle = fread( $fh, filesize($name));
	}
	else
	{
		$linkstyle = "<headlink>";
	}
	foreach ( $sectionlist as $n=>$d )
	{
		$link = $linkstyle;
		$link = str_replace( '<headlink>', '<a href="'.$d['link'].'" class="headlink" id="hla_'.id_name($n).'">'.$d['caption'].'</a>', $link );
		$sectionlist[$n]['linkhtml'] = '<div class="headlink" style="display:inline;" id="hld_'.id_name($n).'" '.
						 'onmouseover="'.
						 "changeclass('hld_" . id_name($n) . "' , '" . "headhoverlink" . "');" .
						 "changeclass('hla_" . id_name($n) . "' , '" . "headhoverlink" . "');" .
						 "openmenu('menu_".id_name($n)."','hld_" . id_name($n) . "');" . '" ' .
						 'onmouseout="' .
						 "changeclass('hld_" . id_name($n) . "' , '" . "headlink" . "');" .
						 "changeclass('hla_" . id_name($n) . "' , '" . "headlink" . "')".'"' .
						 '>'.$link.
						 "</div>"."\n";
	}
	return $sectionlist;	
}
function generatemenus( $sectionlist )
{
	$name = "design/".$_SESSION['theme']."/menulink.html";
	$linkstyle="";
	if (file_exists($name))
	{
		$fh = fopen($name,'r');
		$linkstyle = fread( $fh, filesize($name));
	}
	else
	{
		$linkstyle = "<menulink>";
	}
	$name = "design/".$_SESSION['theme']."/menu.html";
	$menustyle="";
	if (file_exists($name))
	{
		$fh = fopen($name,'r');
		$menustyle = fread( $fh, filesize($name));
	}
	else
	{
		$menustyle = "<menulist>";
	}
	foreach ( $sectionlist as $n=>$d )
	{
		$ml = "";
		foreach ($sectionlist[$n]['sub'] as $sn=>$sd)
		{
			$link = '<a href="'.$sd['link'].'" class="menulink" id="mla_'.id_name($sn).'">'.$sd['caption'].'</a>';
			$ml .= '<div class="menulink" id="mld_'.id_name($sn).'" '.
						 'onmouseover="'.
						 "changeclass('mld_" . id_name($sn) . "' , '" . "menuhoverlink" . "');" .
						 "changeclass('mla_" . id_name($sn) . "' , '" . "menuhoverlink" . "');" . '"' .
						 'onmouseout="' .
						 "changeclass('mld_" . id_name($sn) . "' , '" . "menulink" . "');" .
						 "changeclass('mla_" . id_name($sn) . "' , '" . "menulink" . "')".'"' .
						 '>'.str_replace("<menulink>",$link,$linkstyle).
						 "</div>"."\n";
		}
		
		$ms = $menustyle;
		$ms = str_replace("<menulist>","<div class='menulist'>".$ml."</div>\n",$ms);
		$sectionlist[$n]['menu']="<div id='menu_".id_name($n)."' style='display:none;position:absolute;z-index:1000;' class='menu'>".
								 $ms.
								 "</div>"."\n";
	}
	return $sectionlist;
}
function caption_str( $str )
{
	$b=0;
	if ($str[3]==".")
	{
		$b=4;
	}
	$str = str_replace('+',' ',$str);
	$str = substr( $str, $b, -4);
	$str = urldecode($str);
	$str = str_replace("¤","&#146;",$str);
	return $str;
}

function id_name( $str )
{
	for ( $a = 0; $a< strlen( $str ); $a++ )
	{
		$b = ord($str[$a]);
		$swap=true;
		if ( $b >= 65 && $b <= 90 ) 
		{
			$swap = false;
		}
		if ( $b >= 97 && $b <= 122 )
		{
			$swap = false;
		}
		if ($swap)
		{
			$str[$a]="_";
		}
	}
	return $str;
}

function FirstSection()
{
	$str = "";
	$list = scandir("sections");
	if (isset($list[2]))
	{
		$str = substr($list[2],4,-4);
	}
	return $str;
}

function FirstSubSection()
{
	$str = "";
	$list = scandir("sections");
	if (isset($list[2]))
	{
		$list = scandir("sections/".substr($list[2],4,-4));
		if ( isset($list[2]) )
		{
			$str = substr($list[2],4,-4);
		}
	}
	return $str;	
}


function GenSectionList()
{
	$slist=array();
	$list = scandir("sections");
	foreach ($list as $file)
	{
		if ( $file !="." && $file != ".." && is_dir("sections/".$file) != true )
		{
			$entry=substr($file,4,-4);
			if (is_dir("sections/".$entry))
			{
				$slist[$entry]['link'] = "?section=".$entry;
				$slist[$entry]['file'] = "sections/".$file;
				$slist[$entry]['caption'] = caption_str($file);
				$slist[$entry]['sub'] = array();
				$sublist = scandir("sections/".$entry);
				foreach ($sublist as $subfile )
				{
					if ( $subfile != "." && $subfile != ".." && is_dir("sections/".$entry."/".$subfile) != true)
					{
						$subentry = substr($subfile,4,-4);
						$slist[$entry]['sub'][$subentry]['link'] = "?section=".$entry."&subsection=".$subentry;
						$slist[$entry]['sub'][$subentry]['file'] = "sections/".$entry."/".$subfile;
						$slist[$entry]['sub'][$subentry]['caption'] = caption_str($subfile);
					}
				}
			}
		}
	}
	return $slist;
}
?>