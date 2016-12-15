var menulist=new Array();
var nmenus=0;

function add_menu( menu_id )
{
	var exists=false;
	
	for ( var n = 0; n < nmenus; n++ )
	{
		if ( menulist[n] == menu_id )
		{
			exists=true;
		}
	}
	
	if (!exists)
	{
		menulist[nmenus]=menu_id;
		nmenus++;
	}
}
function closemenus()
{
	for ( var n = 0; n < nmenus; n++ )
	{
		$(menulist[n]).hide();
	}
}
function openmenu( menu_id, caller_id )
{
	var x=0;
	var y=0;
	x = getleft(caller_id);
	y = gettop(caller_id);
	if ( menustart == "right" )
	{
		x+=$(caller_id).offsetWidth;
	}
	if ( menustart == "left" )
	{
		$(menu_id).show();
		x-=$(menu_id).offsetWidth;
		$(menu_id).hide();
	}
	if ( menustart == "bottom" )
	{
		y+=$(caller_id).offsetHeight;
	}
	if ( menustart == "top" )
	{
		$(menu_id).show();
		y-=$(menu_id).offsetHeight;
		$(menu_id).hide();
	}
	add_menu( menu_id );
	closemenus();
	$(menu_id).show();
	$(menu_id).style.left = x + "px";
	$(menu_id).style.top = y + "px";
	
}