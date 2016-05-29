<%@page import="java.io.UnsupportedEncodingException"%>
<%@page import="com.vmc.core.util.VMCException"%>
<%@page import="java.net.URLDecoder"%>
<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>

<%
    // Get the user name and password from he multipart items
    Cookie[] cookies = request.getCookies();
    String userName = null;
    String password = null;
    String authType = null;
    String clientId = null;
    String institutionName = "";
    String imageName = "";
    

    try
    {
    	
    	 for (Cookie cookie : cookies)
         {
         	// TODO! Remove the hard coded and create constants
     	    String name = cookie.getName();
            if (name.equalsIgnoreCase("user"))
            {
           	 userName = URLDecoder.decode(cookie.getValue(), "utf8");
            }
            else if (name.equalsIgnoreCase("password"))
            {
           	 password = URLDecoder.decode(cookie.getValue(), "utf8");
            }
            else if (name.equalsIgnoreCase("imageLoginName"))
            {
           	 imageName = cookie.getValue();
            }
            else if (name.equalsIgnoreCase("authType"))
            {
           	 authType = cookie.getValue();
            }
            //else if (name.equalsIgnoreCase("timezoneOffset"))
            //{
            //    sc.setTimeZoneOffset(Integer.parseInt(cookie.getValue()));
            //}
         }
    }
    catch(UnsupportedEncodingException ex)
    {
    	throw new VMCException(ex.getMessage());
    }
    catch (Exception ex)
    {
    	throw new VMCException(ex.getMessage());
    }
%>
<center>
<h2 style="margin-top: 25px;">Bulk Upload Inventory</h2>
	<form action="../../../../dataUpload" method="post"
		enctype="multipart/form-data">
		<table>
					<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>Select File type:</td>
				<td><select name="uploadType">
						<option value="CREATE_PATIENT_LAB_MATRIX">Patient lab Matrix</option>
						<option value="CREATE_PATIENT_INVENTORY">Patient Inventory and Supplies</option>
						<option value="CREATE_PATIENT_SCHEDULE">Patient vital schedule</option>
						<option value="CREATE_PATIENT_ORDER_RETURN">Order Return</option>
				</select>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td>Select file</td>
				<td><input type="file" name="file" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td style="text-align: right;"><input type="submit"  value="Submit" /></td>
			</tr>
		</table>
		<input type="hidden" value="<%= userName%>" name="user">
		<input type="hidden" value="<%= password%>" name="password">
		<input type="hidden" value="<%= imageName%>" name="imageName">
	</form>
</center>