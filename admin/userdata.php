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
if ( isset( $_POST['user'] ) )
{
	$user = $_POST['user'];
}
else
{
	$user = "(none)";
}
if ( isset( $_POST['mode'] ) )
{
	if ( $_POST['mode'] == 'edituser' )
	{
		?>
		<br>
			<b class="user">Edit User "<?php echo $user;?>"</b><br>
			<br>
			<hr>
			<br>
			<center>
				To change type without changing the password, leave the password fields blank.<br><br>
				<table style="width:300px;">
					<tr>
						<td>
							New Password
						</td>
						<td>
							<input type="password" class="text" name="password" id="password">
						</td>
					</tr>
					<tr>
						<td>
							Confirm Password
						</td>
						<td>
							<input type="password" class="text" name="confirm" id="confirm">
						</td>
					</tr>
					<tr>
						<td>
							Type
						</td>
						<td>
							<select name="type">
							<?php
								if ( $users[$user]['admin'] == '1' )
								{
									echo "<option value='1'>admin</option>";
									echo "<option value='0'>user</option>";
								}
								else
								{
									echo "<option value='0'>user</option>";
									echo "<option value='1'>admin</option>";
								}
							?>
							</select>
						</td>
					</tr>
					<tr>
						<td>
						</td>
						<td>
							<input type="button" class="submit" value="change settings" onclick="saveSettings();">
						</td>
					</tr>
				</table>
			</center>
		<?php
	}
	elseif ( $_POST['mode'] == "deluser" )
	{
		?>
		<br>
		<b class="user">Delete User "<?php echo $user;?>"?</b><br>
		<br>
		<hr>
		<br>
		<center>
			<table>
				<tr>
					<td style="width:100px;">
						<select name="confirmdelete">
							<option value="no">no</option>
							<option value="yes">yes</option>
						</select>
						<br>
						<input type="button" class="submit" value="confirm" onclick="saveSettings();">
					</td>
				</tr>
			</table>
		</center>
		<?php
	}
	elseif ( $_POST['mode'] == "adduser" )
	{
		?>
		<br>
		<b class="user">Add a New User</b><br>
		<br>
		<hr>
		<center>
			<table style="width:300px;">
				<tr>
					<td>
						Username
					</td>
					<td>
						<input type="text" class="text" name="username" id="username">
					</td>
				</tr>
				<tr>
					<td>
						Password
					</td>
					<td>
						<input type="password" class="text" name="password" id="password">
					</td>
				</tr>
				<tr>
					<td>
						Confirm Password
					</td>
					<td>
						<input type="password" class="text" name="confirm" id="confirm">
					</td>
				</tr>
				<tr>
					<td>
						Type
					</td>
					<td>
						<select name="type">
							<option value='0'>user</option>
							<option value='1'>admin</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="button" class="submit" value="Add User" onclick="saveSettings();">
					</td>
				</tr>
			</table>
		</center>
		<?php
	}
	elseif ( $_POST['mode'] == "mypass" )
	{
		?>
		<br>
		<b class="user">Change My Password</b><br>
		<br>
		<hr>
		<center>
			<table style="width:300px;">
				<tr>
					<td>
						Password
					</td>
					<td>
						<input type="password" class="text" name="password" id="password">
					</td>
				</tr>
				<tr>
					<td>
						Confirm Password
					</td>
					<td>
						<input type="password" class="text" name="confirm" id="confirm">
					</td>
				</tr>
				<tr>
					<td>
					</td>
					<td>
						<input type="button" class="submit" value="Change Password" onclick="saveSettings();">
					</td>
				</tr>
			</table>
		</center>
 		<?php
	}
}
?>