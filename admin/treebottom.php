<?php
@session_start();
require("functions.php");
$list = scandir("../files/");
echo "<b>HTML Files: </b><br>";
echo '<input type="button" class="head" onclick="addfile('."'file'".')" value="Add new file">';
echo "<br>";
foreach($list as $file)
{
	if ( substr( $file, -3, strlen($file) ) == "php" )
	{
		$file = str_replace('+',' ',$file);
		$filecaption = caption_str($file);
		
		//echo '<input type="button" class="head" onclick="confirmdel('."'".$file."','".$filecaption."','file')".'" value="del">';
		echo '<img class="head" src="img/rename.jpg" onclick="renamefile('."'".urlencode($file)."','".$filecaption."','file')".'" alt="rename file">';
		echo '<img class="head" src="img/delete.jpg" onclick="confirmdel('."'".urlencode($file)."','".$filecaption."','file')".'" alt="delete file">';
		//echo '<input type="button" class="head" onclick="'."$('theiframe').src='edit.php?type=file&file=".$file."'".'" value="edit">';
		echo '<img class="head" src="img/link.jpg" onclick="insertlink('."'".urlencode($file)."','".$filecaption."','file')".'" alt="create hyperlink">';
		echo " ";
		echo '<a href="edit.php?type=file&file='.urlencode($file).'" target="theiframe">';
		echo $filecaption;
		echo '</a>';
		echo "<br>";
	}
}
?>