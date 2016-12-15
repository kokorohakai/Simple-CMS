<?php
session_start();

//login system.
$_SESSION['loggedin']=false;
$_SESSION['isadmin']=false;
if ( isset( $_POST['logout'] ) || isset( $_GET['logout'] ) )
{
	unset( $_SESSION['username'] );
	unset( $_SESSION['password'] );
}
if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) )
{
	$_SESSION['username'] = $_POST['username'];
	$_SESSION['password'] = $_POST['password'];
}

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

if ( isset( $users[$_SESSION['username']]['password'] ) )
{
	if ( $users[$_SESSION['username']]['password'] == $_SESSION['password'] )
	{
		$_SESSION['loggedin'] = true;
	}
}
if ( isset( $users[$_SESSION['username']]['admin'] ) )
{
	if ( $users[$_SESSION['username']]['admin'] == "1" )
	{
		$_SESSION['isadmin'] = true;
	}
}
//end login system.

?>
<html>
	<head>
		<title>
			Administrator Interface.
		</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<table class="master">
			<tr>
				<td class="tl">
				</td>
				<td class="tc">
				</td>
				<td class="tr">
				</td>
			</tr>
			<tr>
				<td class="cl">
				</td>
				<td class="center">
					<?php
					if (!$_SESSION['loggedin'] )
					{
						require("notloggedin.php");
					} else {
						require("loggedin.php");	
					}
					?>
				</td>
				<td class="cr">
				</td>
			</tr>
			<tr>
				<td class="bl">
				</td>
				<td class="bc">
				</td>
				<td class="br">
				</td>
			</tr>
		</table>
	</body>
</html>
			