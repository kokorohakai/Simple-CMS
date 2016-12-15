<?php
session_start();
require("functions.php");
set_magic_quotes_runtime(false);
if ( isset( $_GET['edittype'] ) )
{
	$_SESSION['edittype']=$_GET['edittype'];
}
if ( !isset( $_SESSION['edittype'] ) )
{
	$_SESSION['edittype']='html';
}
//array(2) { ["type"]=>  string(7) "section" ["file"]=>  string(12) "001.Home.php" } 
$cururl="editsub.php?section=".urlencode($_GET['section'])."&file=".urlencode($_GET['file']);

$prefix = "../sections/".$_GET['section']."/";
$caption = caption_str($_GET['file']); 

if ( isset( $_POST['filedata'] ) )
{
	$time = urlencode(date(" Y-m-d H:i:s"));
	copy ($prefix.urlencode($_GET['file']),"../revisions/".$_GET['section']."/".urlencode($_GET['file']).$time);
	$filehandle = fopen ($prefix.urlencode($_GET['file']),"w");
	fwrite($filehandle,stripslashes($_POST['filedata']));
	fclose($filehandle);
}
if (!isset($_GET['revision']))
{
	$name = $prefix.urlencode($_GET['file']);
	$file = fopen($name,"r");
	$filedata = fread($file, filesize($name));
	fclose($file);
}
else
{
	$name = "../revisions/".$_GET['section']."/".urlencode($_GET['revision']);
	$file = fopen($name,"r");
	$filedata = fread($file, filesize($name));
	fclose($file);
}
if ( !isset( $_POST['filedata'] ) )
{
?>
<html>
	<head>
		<title>
			Administrator Interface.
		</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="scripts/htmlarea/htmlarea.css">
	  <script type="text/javascript">
	  	parent.$('status').innerHTML="Loading...";
    	_editor_url = "scripts/htmlarea/";
      _editor_lang = "en";
    </script>
  	<script language="javascript" type="text/javascript" src="scripts/prototype.js"></script>
		<script language="javascript" type="text/javascript" src="scripts/htmlarea/htmlarea.js"></script>
	</head>
	<body style="background:white;margin:0px;padding:0px;">
		<form method="post" action="<?php echo $cururl;?>">
		 	<table style="width:99%;height:99%;">
		  	<tr>
			  	<td style="width:100%;">
						<textarea name="filedata" id="filedata" class="filedata" style="width:100%;height:100%;"><?php echo $filedata;?></textarea>
					</td>
					<td style="width:150px;" valign="top">
						<input type="submit" class="head" value="Save file" style="width:100%;">
						<input type="button" class="head" onclick="parent.$('theiframe').src='<?php echo $cururl.'&edittype=raw';?>';" value="Edit as text" style="width:100%;">
						<input type="button" class="head" onclick="parent.$('theiframe').src='<?php echo $cururl.'&edittype=html';?>';" value="Edit as HTML" style="width:100%;">
						<hr>
						<b>Revisions:</b>
						<hr>
						<div id="revisions" name="revisions" class="revisions">
							<?php
								echo '<a href="'.$cururl.'">';
								echo "current";
								echo "</a>";
								echo "<br>";
								$files = scandir("../revisions/".$_GET['section'],true);
								foreach ($files as $file)
								{
									$oldfile = urlencode($_GET['file']);
									$a=strlen($oldfile);
									$b=strlen($file);
									if ( $oldfile == substr($file,0,$a) )
									{
										echo '<a href="'.$cururl.'&revision='.$file.'">';
										echo urldecode(substr($file,$a,$b));
										echo "</a>";
										echo "<br>";
									}
								}
							?>
						</div>
					</td>
				</tr>
			</table>
		</form>
		<?php
		if ( $_SESSION['edittype'] == 'html' )
		{
			?>
			<script language="javascript" type="text/javascript">
			  //HTMLArea.loadPlugin("SpellChecker");//here as an example
      	HTMLArea.onload = function() {
      	  var editor = new HTMLArea("filedata");
    	    //editor.registerPlugin(SpellChecker);
  	      editor.generate();
	      };
      	HTMLArea.init();
      </script>
			<?php
		}
		else
		{
			?>
			<script language="javascript" type="text/javascript">
				function insertAtCaret( text ) { 
					var txtarea = $('filedata');
					var scrollPos = txtarea.scrollTop;
					var strPos = 0;
					var br = ""
					if ( txtarea.selectionStart || txtarea.selectionStart == '0')
					{
						br = "ff"
					}
					else
					{
						br = "ie"
					} 
					if (br == "ie") { 
						txtarea.focus(); 
						var range = document.selection.createRange(); 
						range.moveStart ('character', -txtarea.value.length); 
						strPos = range.text.length; 
					} else if (br == "ff") strPos = txtarea.selectionStart; 
					
					var front = (txtarea.value).substring(0,strPos); 
					var back = (txtarea.value).substring(strPos,txtarea.value.length); 
					txtarea.value=front+text+back; 
					strPos = strPos + text.length; 
					if (br == "ie") { 
						txtarea.focus(); 
						var range = document.selection.createRange(); 
						range.moveStart ('character', -txtarea.value.length); 
						range.moveStart ('character', strPos); range.moveEnd ('character', 0); range.select(); 
					} else if (br == "ff") { 
						txtarea.selectionStart = strPos; 
						txtarea.selectionEnd = strPos; 
						txtarea.focus(); 
					} 
					
					txtarea.scrollTop = scrollPos; 
				}
			</script>
			<?php	
		}
		?>
		<script language="javascript" type="text/javascript">
			parent.$('status').innerHTML="Editing: <?php echo $caption;?>";
		</script>
	</body>
</html>
<?php 
}
else
{
	?>
	<html>
		<head>
			<title>
				Administrator Interface.
			</title>
			<link rel="stylesheet" type="text/css" href="style.css">
			<link rel="stylesheet" type="text/css" href="scripts/htmlarea/htmlarea.css">
			<script type="text/javascript">
	    </script>
		</head>
		<body style="background:white;margin:0px;padding:0px;">
			<center>
				<br>
				<br>
				Saved file <?php echo $caption;?>.<br>
				(The page will reload in 2 seconds)<br>
			</center>
			<script language="javascript" type="text/javascript">
				function refreshme()
				{
					location.href='<?php echo $cururl;?>'
				}
				
				setTimeout ( refreshme, 2000 );
			</script>
		</body>
	</html>
	<?php
}
?>