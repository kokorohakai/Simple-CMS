<?php
session_start();
$users = array();
$usersfile = fopen('config/users.dat','r');
while ( !feof($usersfile) )
{
	$temp = explode( ',', fgets($usersfile) );
	if ( count( $temp ) > 1 )
	{
		$users[trim( $temp[0] )]['password'] = trim( $temp[1] );
		$users[trim( $temp[0] )]['admin'] = trim( $temp[2] );
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
		<script language="javascript" type="text/javascript" src="scripts/md5.js"></script>
	</head>
	<body>
		<form id="userform">
		<table style="width:100%;height:100%;">
			<tr><td style="width:5px;height:5px;"></td><td style="width:100%;height:5px;"></td><td style="width:5px;height:5px;"></td></tr>
			<tr>
				<td style="width:5px;height:100%;"></td>
				<td style="width:100%;vertical-align:middle;text-align:center;background:white;border:3px solid #ccc;">
					<table style="width:100%;height:100%">
						<tr>
							<td style="width:150px;vertical-align:top;">
								<?php
								if ($_SESSION['isadmin']==true)
								{
									echo "<div class='userlist' id='userlist'>";
									echo "<select id='usersel' name='usersel' class='user'>";
									foreach($users as $var=>$val)
									{
										echo "<option value='".$var."'>".$var."</option>";
									}
									echo "</select>";
									echo "</div><br>";
									?>
									
									<input type="button" value="edit user" class="userbutton" onclick="showdiv('edituser')"><br>
									<input type="button" value="delete user" class="userbutton" onclick="showdiv('deluser')"><br>
									<input type="button" value="add user" class="userbutton" onclick="showdiv('adduser')"><br>
									<?php
								}
								?>
								<input type="button" value="change my password" class="userbutton" onclick="showdiv('mypass')"><br>
							</td>
							<td valign=top style="vertical-align:top;text-align:center;">
								<input type="hidden" id="mode" name="mode" value="">
								<div class="userdiv" id="thediv">
								</div>
							</td>
						</tr>
					</table>
				</td>
				<td style="width:5px;"></td>
			</tr>
			<tr><td style="width:5px;height:5px;"></td><td style="width:100%;height:5px;"></td><td style="width:5px;height:5px;"></td></tr>
		</table>
		</form>
	</body>
	<script language="javascript" type="text/javascript">
		parent.$('status').innerHTML="User Manager";
		function showdiv( thediv )
		{
			parent.$('status').innerHTML="Loading...";
			$('mode').value=thediv;
			if ( $('usersel') )
			{
				var params="?mode=" + thediv + "&user=" + $('usersel').value;
			}
			else
			{
				var params="?mode=" + thediv;
			}
			var url="userdata.php";
			var myAjax = new Ajax.Request
			(
		    url, 
				{
					method: 'post', 
					parameters: params, 
					onComplete: handleShowDiv
				}
			);
		}
		
		function handleShowDiv( rsp )
		{
			$('thediv').innerHTML=rsp.responseText;
			parent.$('status').innerHTML="User Manager:" + " " + $('mode').value;
		}
		
		function saveSettings()
		{
			if ($('password'))
			{
				$('password').value=hex_md5($('password').value);
			}
			if ($('confirm'))
			{
				$('confirm').value=hex_md5($('confirm').value);
			}
			parent.$('status').innerHTML="Loading...";
			var params=$('userform').serialize();
			var url="saveuserdata.php";
			var myAjax = new Ajax.Request
			(
		    url, 
				{
					method: 'post', 
					parameters: params, 
					onComplete: handleSaveSettings
				}
			);
		}
		function handleSaveSettings(rsp)
		{
			if ( rsp.responseText.substr(0,4) == "ERR:" )
			{
				parent.$('status').innerHTML="User Manager:" + " " + $('mode').value;
				alert(rsp.responseText.substr(4,rsp.responseText.length));
			}
			else
			{
				parent.$('status').innerHTML="User Manager: Complete";
				$('thediv').innerHTML=rsp.responseText;
				updateUserList();
			}
		}
		
		function updateUserList()
		{
			if ($('userlist'))
			{
				var url="updateusers.php";
				var myAjax = new Ajax.Request
				(
			    url, 
					{
						method: 'post', 
						onComplete: handleUpdateUserList
					}
				);
			}
		}
		function handleUpdateUserList(rsp)
		{
			$('userlist').innerHTML=rsp.responseText;
		}
	</script>
</html>