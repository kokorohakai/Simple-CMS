<?php 
session_start();
set_time_limit(300);
if (count($_FILES)>0)
{
	if (!move_uploaded_file($_FILES["filename"]["tmp_name"], "../uploaded/".$_FILES["filename"]["name"]))
	{
		echo "An error occured.	Could not upload file.";
	}
}
?>
<html>
	<head>
		<title>
			Administrator Interface.
		</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<script language="javascript" type="text/javascript" src="scripts/prototype.js"></script>
	</head>
	<body>
		<table style="width:100%;height:100%;">
			<tr><td style="width:50%;height:50px;"></td><td style="width:300px;height:50px;"></td><td style="width:50%;height:50px;"></td></tr>
			<tr>
				<td style="width:50%;height:100px;"></td>
				<td style="width:300px;text-align:center;background:white;border:3px solid #ccc;">
					<div id="prompt" style="display:inline;">
						<form method="post" action="uploadfile.php" enctype="multipart/form-data">
							<input type="file" id="filename" name="filename">
							<input type="submit" value="upload file">
						</form>
					</div>
				</td>
				<td style="width:50%;"></td>
			</tr>
			<tr><td style="width:50%;height:100%;"></td><td style="width:300px;height:100%;"></td><td style="width:50%;height:100%;"></td></tr>
		</table>
		<script language="javascript" type="text/javascript">
			parent.$('status').innerHTML="Upload a file";
			parent.updateTreeImages();
		</script>
	</body>
</html>