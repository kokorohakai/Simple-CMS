<?php
@session_start();
require("functions.php");
$list = scandir("../sections/");
echo "<b>Sections: </b><br>";
if ($_SESSION['isadmin'])
{
	echo '<input type="button" class="head" onclick="addfile('."'section'".')" value="Add new section">';
}
echo "<br>";
foreach($list as $file)
{
	if ( substr( $file, -3, strlen($file) ) == "php" )
	{
		$file = str_replace('+',' ',$file);
		$filecaption = caption_str($file);

		if ($_SESSION['isadmin'])
		{
			echo '<img class="head" src="img/up.jpg" class="head" onclick="moveup('."'".urlencode($file)."')".'" alt="Raise file.">';
			//echo '<input type="button" class="head" onclick="confirmdel('."'".$file."','".$filecaption."','section')".'" value="del">';
			echo '<img class="head" src="img/rename.jpg" onclick="renamefile('."'".urlencode($file)."','".$filecaption."','section')".'" alt="rename file">';
			echo '<img class="head" src="img/delete.jpg" onclick="confirmdel('."'".urlencode($file)."','".$filecaption."','section')".'" alt="delete file">';
		}
		//echo '<input type="button" class="head" onclick="'."$('theiframe').src='edit.php?type=section&file=".$file."'".'" value="edit">';
		$idname=id_name($filecaption);
		echo '<img class="head" src="img/link.jpg" onclick="insertlink('."'".urlencode(substr($file,4,-4))."','".$filecaption."','section')".'" alt="create hyperlink">';
		echo " ";
		echo '<a href="edit.php?type=section&file='.$file.'" target="theiframe">';
		echo $filecaption;
		echo '</a>';
		echo '<input type="hidden" name="'.$idname.'state" id="'.$idname.'state" value="off">';
		echo '&nbsp;<img src="img/closed.jpg" onclick="openme('."'".$idname."','".urlencode($file)."'".')" class="head" id="h_'.$idname.'" alt="toggle sub files"><br>';
		echo '<div id="sh_'.$idname.'" style="display:none;" class="subsect"></div>';
		if ($_SESSION['opensection'][urlencode(substr(str_replace(" ","+",$file),4,-4))])
		{
			echo '<img class="head" src="img/pixel.jpg" onload="openme(' . "'" . $idname . "','" . urlencode($file) . "')" . '">';
		}
	}
}
?>