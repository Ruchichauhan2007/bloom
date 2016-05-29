<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Upload patient data</title>

</head>
<body>

	<form action="../../../../dataUpload" method="post"
		enctype="multipart/form-data">
		<table>
			<tr>
				<td>User:</td>
				<td><input type="text" name="user" /></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="password" /></td>
			</tr>
			<tr>
				<td>Image:</td>
				<td><input type="text" name="imageName" /></td>
			</tr>
			<tr>
				<td>Select File type:</td>
				<td><select name="uploadType">
						<option value="CREATE_PATIENT_LAB_MATRIX">Patient lab Matrix</option>
						<option value="CREATE_PATIENT_INVENTORY">Patient Inventory and Supplies</option>
						<option value="CREATE_PATIENT_SCHEDULE">Patient vital schedule</option>
				</select>
			</tr>
			<tr>
				<td>Select file</td>
				<td><input type="file" name="file" /></td>
			</tr>
			<tr>
				<td><input type="submit" /></td>
			</tr>
		</table>
	</form>
</body>
</html>