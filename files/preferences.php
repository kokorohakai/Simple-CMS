<?php 
$themes = array();
$data = scandir("design");
foreach($data as $file)
{
	if (is_dir("design/".$file) && $file != "." && $file != ".." && $file != $_SESSION['theme'])
	{
		$themes[]=$file;
	}
}
$menustyles = array();
$data = scandir("admin/scripts/MenuTypes");
foreach($data as $file)
{
	if (!is_dir("admin/scripts/MenuTypes/".$file) && substr($file,0,-3) != $_SESSION['menustyle'] )
	{
		$menustyles[]=substr($file,0,-3);
	}
}
?>
<center>
	<form action="?file=preferences.php" method="post">
		<table>
			<tr>
				<td class="prefleft" align=right>
					Theme:
				</td>
				<td class="prefmid">
					&nbsp;&nbsp;
				</td>
				<td class="prefright">
					<select name="theme">
						<option value="<?=$_SESSION['theme']?>"><?=$_SESSION['theme']?></option>
						<? foreach ($themes as $theme) { ?>
							<option value="<?=$theme;?>"><?=$theme;?></option>
						<? } ?>
					</select>		
				</td>
			</tr>
			<tr>
				<td class="prefleft" align=right>
					Menu Style:
				</td>
				<td class="prefmid">
					&nbsp;&nbsp;
				</td>
				<td class="prefright">
					<select name="menustyle">
						<option value="<?=$_SESSION['menustyle']?>"><?=$_SESSION['menustyle']?></option>
						<? foreach ($menustyles as $menustyle) { ?>
							<option value="<?=$menustyle;?>"><?=$menustyle;?></option>
						<? } ?>
					</select>		
				</td>
			</tr>
			<tr>
				<td class="prefleft" align=right>
					Theme Color:
				</td>
				<td class="prefmid">
					&nbsp;&nbsp;
				</td>
				<td> 
					<input name="tcolor" class="color" value="<?=$_SESSION['tcolor']?>" onchange="changecolor()" id="color">
				</td>
			</tr>
			<tr>
				<td class="prefleft" align=right>
					<input type="checkbox" name="savecookie">
				</td>
				<td class="prefmid">
					&nbsp;&nbsp;
				</td>
				<td class="prefright">
					Remember my settings.
				</td>
			</tr>
			<tr>
				<td colspan=3 align=middle>
					<input type="submit" value="change settings">
				</td>
			</tr>
		</table>
	</form>
</center>