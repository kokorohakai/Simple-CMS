<?php

?>
<script language="javascript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="javascript" type="text/javascript">
	function updateTreeTop()
	{
		var url="treetop.php";
		var myAjax = new Ajax.Request
		(
	    url, 
			{
				method: 'post', 
				onComplete: handleUpdateTreeTop
			}
		);
	}
	function handleUpdateTreeTop(rsp)
	{
		$('treetop').innerHTML=rsp.responseText;
	}
	
	function updateTreeBottom()
	{
		var url="treebottom.php";
		var myAjax = new Ajax.Request
		(
	    url, 
			{
				method: 'post', 
				onComplete: handleUpdateTreeBottom
			}
		);
	}
	function handleUpdateTreeBottom(rsp)
	{
		$('treebottom').innerHTML=rsp.responseText;
	}
	
	function updateTreeImages()
	{
		var url="treeimages.php";
		var myAjax = new Ajax.Request
		(
	    url, 
			{
				method: 'post', 
				onComplete: handleUpdateTreeImages
			}
		);
	}
	function handleUpdateTreeImages(rsp)
	{
		$('treeimages').innerHTML=rsp.responseText;
	}
	
	function moveup(file)
	{
		var params="?filename=" + file;
		var url="moveup.php";
		var myAjax = new Ajax.Request
		(
	    url, 
			{
				method: 'post', 
				parameters: params, 
				onComplete: handleAddFile
			}
		);
	}
	function movesubup(file, section)
	{
		var params="?filename=" + file + "&section=" + section;
		var url="movesubup.php";
		var myAjax = new Ajax.Request
		(
	    url, 
			{
				method: 'post', 
				parameters: params, 
				onComplete: handleAddFile
			}
		);
	}
	
	function confirmdel(file,filecaption,type)
	{
		if( confirm( "Click okay to delete file: " + filecaption ) )
		{
			var params="?type=" + type + "&filename=" + file;
			var url="delfile.php";
			var myAjax = new Ajax.Request
			(
		    url, 
				{
					method: 'post', 
					parameters: params, 
					onComplete: handleAddFile
				}
			);
		}
	}
	function confirmsubdel(file,filecaption,section)
	{
		if( confirm( "Click okay to delete file: " + filecaption ) )
		{
			var params="?section=" + section + "&filename=" + file;
			var url="delsubfile.php";
			var myAjax = new Ajax.Request
			(
		    url, 
				{
					method: 'post', 
					parameters: params, 
					onComplete: handleAddFile
				}
			);
		}
	}

	function addsubsection( section )
	{
		var file=prompt("Please input a filename");
		if (file.length > 0)
		{
			var params="?section=" + section + "&filename=" + file;
			var url="addsubfile.php";
			var myAjax = new Ajax.Request
			(
		    url, 
				{
					method: 'post', 
					parameters: params, 
					onComplete: handleAddFile
				}
			);
		}
	}

	function addfile(type)
	{
		var file=prompt("Please input a filename");
		if (file.length > 0)
		{
			var params="?type=" + type + "&filename=" + file;
			var url="addfile.php";
			var myAjax = new Ajax.Request
			(
		    url, 
				{
					method: 'post', 
					parameters: params, 
					onComplete: handleAddFile
				}
			);
		}
	}
	function handleAddFile(rsp)
	{
		//alert(rsp.responseText);//for da debuggin'
		if ( rsp.responseText.substr(0,4) == "ERR:" )
		{
			updateTreeBottom();
			updateTreeTop();
			alert(rsp.responseText.substr(4,rsp.responseText.length));
		}
		else
		{
			if ( rsp.responseText == "file" )
			{
				updateTreeBottom();
			}
			if ( rsp.responseText == "section" )
			{
				updateTreeTop();
			}
			if ( rsp.responseText == "uploaded" )
			{
				updateTreeImages();
			}
		}
	}
	function insertlink( file, caption, type )
	{
		var tlink="";
		if ( type == 'section' )
		{
			tlink = '?section='+file;
		}
		if ( type == 'file' )
		{
			tlink = '?file=' + file;
		}
		if ( type == 'uploaded' )
		{
			tlink = 'uploaded/' + file;
		}
		var text = '<a href="' + tlink + '">' + caption + '</a>';
		
		if ( parent.frames[0].insertAtCaret )
		{
			parent.frames[0].insertAtCaret( text );
		}
		else
		{
			$('holdtext').innerText = tlink;
			if ( $('holdtext').createTextRange )
			{
				Copied = $('holdtext').createTextRange();
				Copied.execCommand("Copy");
				alert("Copied to clipboard");
			}
			else
			{
				alert("copy this:\n\n" + tlink);
			}
		}
	} 
	function insertsublink( file, caption, section )
	{
		var tlink="";
		tlink = '?section=' + section + '&subsection=' + file;
		
		var text = '<a href="' + tlink + '">' + caption + '</a>';
		
		if ( parent.frames[0].insertAtCaret )
		{
			parent.frames[0].insertAtCaret( text );
		}
		else
		{
			$('holdtext').innerText = tlink;
			if ( $('holdtext').createTextRange )
			{
				Copied = $('holdtext').createTextRange();
				Copied.execCommand("Copy");
				alert("Copied to clipboard");
			}
			else
			{
				alert("copy this:\n\n" + tlink);
			}
		}
	} 
	function openme( section, file)
	{
		if ( $( section + 'state' ).value=="off")
		{
			$('h_' + section ).src = "img/open.jpg";
			$('sh_' + section ).show();
			$( section + 'state' ).value = "on";

			var params="?section=" + file;
			var url="subsections.php";
			var myAjax = new Ajax.Request
			(
		    	url, 
				{
					method: 'post', 
					parameters: params, 
					onComplete: function( rsp )
					{
						$('sh_' + section ).innerHTML = rsp.responseText;
					}
				}
			);
		}
		else
		{
			$('h_' + section ).src = "img/closed.jpg";
			$('sh_' + section ).hide();
			$( section + 'state' ).value = "off";
			$('sh_' + section ).innerHTML = " ";
			var params="?section=" + file;
			var url="closesubsection.php";
			var myAjax = new Ajax.Request
			(
		    	url, 
				{
					method: 'post', 
					parameters: params, 
				}
			);
		}
	}
	function renamefile( oldname, caption, type )
	{
		var newname=prompt("Rename "+caption+" too:\nWarning: Renaming this file will delete its revisions.");
		if (newname.length > 0)
		{
			var params="?type=" + type + "&oldname=" + oldname + "&newname=" + newname;
			var url="renamefile.php";
			var myAjax = new Ajax.Request
			(
		    url, 
				{
					method: 'post', 
					parameters: params, 
					onComplete: handleAddFile
				}
			);
		}
	}
	function renamesubfile( oldname, caption, section )
	{
		var newname=prompt("Rename "+caption+" too:\nWarning: Renaming this file will delete its revisions.");
		if (newname.length > 0)
		{
			var params="?section=" + section + "&oldname=" + oldname + "&newname=" + newname;
			var url="renamefile.php";
			var myAjax = new Ajax.Request
			(
		    url, 
				{
					method: 'post', 
					parameters: params, 
					onComplete: handleAddFile
				}
			);
		}
	}
</script>
<table style="width:100%;height:100%;">
	<tr>
		<td style="width:200px;height:50px;">
			<a href="welcome.php" target="theiframe">
				<img src="img/cmsadmin.jpg">
			</a>
		</td>
		<td style="width:100%;height:50px;">
			<!--menu/status/links/logout-->
			<table style="width:100%;height:100%;">
				<tr>
					<td>
						<div id="status" class="status">Loading...</div>
					</td>
				</tr>
				<tr>
					<td style="text-align:center;vertical-align:bottom;">
						<a class='head' href="users.php" target="theiframe">&nbsp;users&nbsp;</a>
						<a class='head' href="?logout=true">&nbsp;logout&nbsp;</a>
						<a class='head' href="options.php" target="theiframe">&nbsp;Site Options&nbsp;</a>
					</td>
				</tr>
			</table>
		</td>
		<td style="width:5px;height:50px;"></td>
	</tr>
	<tr>
		<td style="width:200px;height:33%;border:1px solid black;" valign="top">
			<div class="tree" id="treetop">
				<?php require("treetop.php");?>
			</div>
		</td>
		<td rowspan=3 style="border:1px solid black;">
			<iframe frameborder=0 class="theiframe" name="theiframe" id="theiframe" src="welcome.php"></iframe>
		</td>
		<td style="width:5px;height:100%;" rowspan=3></td>
	</tr>
	<tr>
		<td style="width:200px;height:33%;border:1px solid black;" valign="top">
			<div class="tree" id="treebottom">
				<?php require("treebottom.php");?>
			</div>
		</td>
	</tr>
	<tr>
		<td style="width:200px;height:33%;border:1px solid black;" valign="top">
			<div class="tree" id="treeimages">
				<?php require("treeimages.php");?>
			</div>
		</td>
	</tr>
	<tr>
		<td style="width:200px;height:5px;">
		<td style="width:100%;height:5px;">
		<td style="width:5px;height:5px;"></td>
	</tr>
</table>
<textarea style="display:none;" id="holdtext">
</textarea>
