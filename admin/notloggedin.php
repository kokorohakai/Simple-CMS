<script language="javascript" type="text/javascript" src="scripts/md5.js"></script>
<script type="text/javascript">
	function hashpassword()
	{
		password=document.getElementById('password');
		password.value=hex_md5(password.value);
	}
</script>
<form method="post" action="." onSubmit="hashpassword();">
	<center>
		<table class="login">
			<tr>
				<td style="width:5px;height:5px"></td>
				<td style="width:90px;height:5px"></td>
				<td style="width:200px;height:5px"></td>
				<td style="width:5px;height:5px"></td>
			</tr>
			<tr>
				<td style="width:5px;height:20px"></td>
				<td colspan=2 style="text-align:center;" class="login">
					Please log in:
				</td>
				<td style="width:5px;height:20px"></td>
			</tr>
			<tr>
				<td style="width:5px;height:20px"></td>
				<td class="login">
					Username:
				</td>
				<td class="login">
					<input type="text" id="username" name="username" class="text">
				</td>
				<td style="width:5px;height:20px"></td>
			</tr>
			<tr>
				<td style="width:5px;height:20px"></td>
				<td class="login">
					Password:
				</td>
				<td class="login">
					<input type="password" id="password" name="password" class="text">
				</td>
				<td style="width:5px;height:20px"></td>
			</tr>
			<tr>
				<td style="width:5px;height:20px"></td>
				<td style="width:40px;height:20px"></td>
				</td>
				<td class="login" style="width:100%;">
					<input type="submit" value="login" class="submit">
				</td>
				<td style="width:5px;height:20px"></td>
			</tr>
			<tr>
				<td style="width:5px;height:5px"></td>
				<td style="width:40px;height:5px"></td>
				<td style="width:200px;height:5px"></td>
				<td style="width:5px;height:5px"></td>
			</tr>
		</table>
	</center>
</form>