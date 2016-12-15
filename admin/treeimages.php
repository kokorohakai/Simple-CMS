<?php
@session_start();
?>
<b>Uploaded files:</b><br>
<input type="button" class="head" onclick="$('theiframe').src='uploadfile.php'" value="Add new file"><br>
<?php
$list = scandir("../uploaded/");
foreach($list as $file)
{
	if ( $file != "." && $file != ".." )
	{
		$file = str_replace('+',' ',$file);
		$filecaption = urldecode($file);
		
		if ($_SESSION['isadmin'])
		{
			echo '<img class="head" src="img/delete.jpg" onclick="confirmdel('."'".urlencode($file)."','".$filecaption."','uploaded')".'" alt="delete file">';
		}
		echo '<img class="head" src="img/link.jpg" onclick="insertlink('."'".urlencode($file)."','".$filecaption."','uploaded')".'" alt="create hyperlink">';
		echo " ";
		echo '<a href="../uploaded/'.$file.'">';
		echo $filecaption;
		echo '</a>';
		echo "<br>";
	}
}