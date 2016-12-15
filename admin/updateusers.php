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

echo "<select id='usersel' name='usersel' class='user'>";
foreach($users as $var=>$val)
{
	echo "<option value='".$var."'>".$var."</option>";
}
echo "</select>";
?>