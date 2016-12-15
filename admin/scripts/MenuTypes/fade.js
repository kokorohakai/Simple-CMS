var menulist = new Array();
var menuopacity = new Array();
var menustate = new Array();
var nmenus=0;
var thetimer = false;

function animate()
{
	for ( var n = 0; n < nmenus; n++ )
	{
		if (menustate[menulist[n]])
		{
			menuopacity[n]+=.2;
		}
		else
		{
			menuopacity[n]-=.2;
		}
		if (menuopacity[n] > 1.0) menuopacity[n] = 1.0;
		if (menuopacity[n] < 0.0)
		{
			$(menulist[n]).hide();
			menuopacity[n] = 0.0;
		}
		$(menulist[n]).setOpacity(menuopacity[n]);
	}
	thetimer = setTimeout('animate()',67);
}

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
		menuopacity[nmenus]=0.0;
		menustate[menu_id]=true;
		$(menu_id).setOpacity(0);
		nmenus++;
	}
}
function closemenus()
{
	for ( var n = 0; n < nmenus; n++ )
	{
		//$(menulist[n]).hide();
		$(menulist[n]).style.zIndex="900";
		menustate[menulist[n]]=false;
	}
}
function openmenu( menu_id, caller_id )
{
	clearTimeout(thetimer);
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
	menustate[menu_id]=true;
	$(menu_id).show();
	$(menu_id).style.zIndex="1000";
	$(menu_id).style.left = x + "px";
	$(menu_id).style.top = y + "px";	
	thetimer = setTimeout('animate()',67);
}
