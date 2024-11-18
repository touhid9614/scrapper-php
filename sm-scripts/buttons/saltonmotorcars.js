const new_buttons = `<table cellpadding="30" style="border:0; margin-top:50px">
	<tr>
		<td><button type="button" class="loan-application">Loan Application</button></td>
		<td><button type="button" class="request-information">Request Information</button></td>
	</tr>
</table>`;
$("table#tblLeftMain2").after(new_buttons);
console.log("sMedia New button added from additional script");
