<?
function caption_str( $str )
{
	$b=0;
	if ($str[3]==".")
	{
		$b=4;
	}
	$str = str_replace('+',' ',$str);
	$str = substr( $str, $b, -4);
	$str = urldecode($str);
	$str = str_replace("¤","&#146;",$str);
	return $str;
}

function id_name( $str )
{
	for ( $a = 0; $a< strlen( $str ); $a++ )
	{
		$b = ord($str[$a]);
		$swap=true;
		if ( $b >= 65 && $b <= 90 ) 
		{
			$swap = false;
		}
		if ( $b >= 97 && $b <= 122 )
		{
			$swap = false;
		}
		if ($swap)
		{
			$str[$a]="_";
		}
	}
	return $str;
}

?>