
<div style="float:center; font: verdana; padding: 7px 12px; background-color: #FFFFCC; color: #000000;">
<form action="" method="get">
<table>
	<tr>
    	<td><strong>Search</strong></td><td></td>
    </tr>
    <tr>
    	<td>Employee ID</td><td>First Name</td><td>Last Name</td>
    </tr>
    <tr>
    	<td><input type="text" name="employeeid" /></td>
        <td><input type="text" name="firstname" /></td>
        <td><input type="text" name="lastname" /></td>
    </tr>
    <tr>
    	<td colspan="3" align="right">
        (Leave all blank to view all)
        <input type="checkbox" name="checkemployeeid[]" value="1" checked = "checked">
        <input type="checkbox" name="checkemployeeid[]" value="2">
        <input type="checkbox" name="checkemployeeid[]" value="3">
        <input type="checkbox" name="checkemployeeid[]" value="4">
        <input type = "hidden" name = "searching" value="1" />
        <input type="submit" name="search" value="Search" /></td>
    </tr>
</table>
</form>
</div>
