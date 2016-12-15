<?
	@session_start();
	require("functions.php");
	$section= substr($_POST['section'], 4, -4 );
	$list = scandir("../sections/".$section);
	$section = urlencode($section);
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	echo '<input type="button" class="head" onclick="addsubsection('."'".$section."'".')" value="Add sub section"><br>';
	foreach ($list as $file)
	{
		if ( substr( $file, -3, strlen($file) ) == "php" )
		{
			$filecaption = caption_str($file);
			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			if ($_SESSION['isadmin'])
			{
				echo '<img class="head" src="img/up.jpg" class="head" onclick="movesubup('."'".$file."','".$section."')".'" alt="Raise file.">';
				echo '<img class="head" src="img/rename.jpg" onclick="renamesubfile('."'".$file."','".$filecaption."','".$section."')".'" alt="rename file">';
				echo '<img class="head" src="img/delete.jpg" onclick="confirmsubdel('."'".$file."','".$filecaption."','".$section."')".'" alt="delete file">';
			}
			echo '<img class="head" src="img/link.jpg" onclick="insertsublink('."'".substr($file,4,-4)."','".$filecaption."','".$section."')".'" alt="create hyperlink">';
			echo " ";
			echo '<a href="editsub.php?section='.$section.'&file='.$file.'" target="theiframe">';
			echo $filecaption;
			echo '</a><br>';			
		}
	}
	$_SESSION['opensection'][$section]=true;
?>