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

function writeoutuserfile($users)
{
	$usersfile = fopen('config/users.dat','w');
	foreach($users as $var=>$value)
	{
		$output=$var.",".$value['password'].",".$value['admin'];
		fwrite($usersfile,$output."\n");
	}
	fclose($usersfile);
}

if ( isset( $_POST['user'] ) )
{
	$user = $_POST['user'];
}
else
{
	$user = "(none)";
}

if ( $_POST['mode'] == "mypass" )
{
	if ( $_POST['password'] != "d41d8cd98f00b204e9800998ecf8427e" )
	{
		if ( $_POST['confirm'] != "d41d8cd98f00b204e9800998ecf8427e" )
		{
			if ( $_POST['password'] == $_POST['confirm'] )
			{
				if ( isset( $users[$_SESSION['username']] ) )
				{
					$users[$_SESSION['username']]['password'] = $_POST['password'];
					writeoutuserfile($users);
					echo "<br><br>Password has been changed";
				}
				else
				{
					echo "ERR:Internal error (501)!";
				}
			}
			else
			{
				echo "ERR:Passwords don't match!";
			}
		}
		else
		{
			echo "ERR:You must confirm your password!";
		}
	}
	else
	{
		echo "ERR:You must supply a password!";
	}
}
if ( $_POST['mode'] == "edituser" )
{
	$change=true;
	if ( strlen( $_POST['password'] ) != "d41d8cd98f00b204e9800998ecf8427e" && strlen( $_POST['confirm'] ) != "d41d8cd98f00b204e9800998ecf8427e" )
	{
		if ( $_POST['password'] == $_POST['confirm'] )
		{
			$users[$_POST['usersel']]['password'] = $_POST['password'];
		}
		else
		{
			echo "ERR:Passwords do not match!";
			$change=false;
		}
	}
	
	if ($change)
	{
		$users[$_POST['usersel']]['admin']=$_POST['type'];
		writeoutuserfile($users);
		echo "<br><br>Modified user ".$_POST['usersel'];
	}
}
if ( $_POST['mode'] == "adduser" )
{
	if ( $_POST['password'] != "d41d8cd98f00b204e9800998ecf8427e" )
	{
		if ( $_POST['confirm'] != "d41d8cd98f00b204e9800998ecf8427e" )
		{
			if ( $_POST['password'] == $_POST['confirm'] )
			{
				if ( strlen( $_POST['username'] ) > 0 )
				{
					if ( !isset( $users[$_POST['username']] ) )
					{
						$users[$_POST['username']]['password'] = $_POST['password'];
						$users[$_POST['username']]['admin'] = $_POST['type'];
						writeoutuserfile($users);
						echo "<br><br>New user added:".$_POST['username'];
					}
					else
					{
						echo "ERR:User already exists!";
					}
				}
				else
				{
					echo "ERR:You must specify a username!";
				}
			}
			else
			{
				echo "ERR:Passwords don't match!";
			}
		}
		else
		{
			echo "ERR:You must confirm your password!";
		}
	}
	else
	{
		echo "ERR:You must supply a password!";
	}
}
if ( $_POST['mode'] == "deluser" )
{
	if ( $_POST['confirmdelete'] == "yes" )
	{
		if ( isset( $users[$_POST['usersel']] ) )
		{
			unset($users[$_POST['usersel']]);
			writeoutuserfile($users);
			echo "<br><br>Deleted User ".$_POST['usersel'];
		}
		else
		{
			echo "ERR:User does not exist!";
		}
	}
	else
	{
		echo "<br><br>Delete Canceled";
	}
}
?>