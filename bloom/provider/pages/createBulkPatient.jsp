<%@ page language="java" contentType="text/html; charset=ISO-8859-1"
	pageEncoding="ISO-8859-1"%>
<%@ page import="javax.servlet.ServletContext"%>
<%@ page import="javax.servlet.ServletException"%>
<%@ page import="javax.servlet.annotation.WebServlet"%>
<%@ page import="javax.servlet.http.HttpServlet"%>
<%@ page import="javax.servlet.http.HttpServletRequest"%>
<%@ page import="javax.servlet.http.HttpServletResponse"%>



<%@page import="com.vmc.emr.api.EMR"%>
<%@page import="com.vmc.emr.info.ProviderInfo"%>
<%@page import="com.vmc.core.internal.util.JobUtil"%>
<%@page import="com.vmc.core.internal.info.VMCRequestInfo"%>
<%@page import="com.vmc.emr.bl.EMRHelper"%>



<%@ page import="com.vmc.core.info.VMCServiceInfo"%>

<%@ page import="com.vmc.core.util.MessageDefs"%>
<%@ page import="com.vmc.core.util.VMCException"%>
<%@ page import="com.vmc.core.util.VMCLogger"%>

<%@ page import="java.util.*"%>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Sample Content Upload</title>

<%
    // Get the user name and password from he multipart items
    String userName = null;
    String password = null;
    String clientId = null;
    String institutionName = "";
    String messageStr = "";
    String imageName = "";
    StringBuilder providerListStr = new StringBuilder() ; 
    VMCRequestInfo reqInfo = null;

    try
    {
        String hostName=request.getServerName();
        reqInfo = JobUtil.getVMCRequest(hostName);

        ProviderInfo[] providerList = EMRHelper.getInstance().getProviderList(reqInfo,
                false,"");
        if(providerList != null && providerList.length > 0 )
        {
            for(ProviderInfo prov: providerList)
            {
	        	providerListStr.append("<option value=\"" + prov.getProviderId() + "\">" + ( prov.getLastName() + ", " + prov.getFirstName())  ) ;
            }
        }
        
    }
    catch (Exception ex)
    {

    }
    finally
    {
        if (reqInfo != null)
        {
            reqInfo.release();
        }
    }
%>



</head>
<body>
	<p>
		<%=messageStr%>
	</p>

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
				<td>Primary Provider:</td>
				<td> 
					<select name = "primary"> 
						<%= providerListStr %>
					</select>
				</td>
			</tr>
			<tr>
				<td>Secondary Provider:</td>
				<td>
					<select name = "secondary"> 
						<%= providerListStr %>
					</select>
				</td>
			</tr>
			<tr>
				<td>Select file</td>
				<td><input type="file" name="file" /></td>
			</tr>
			<tr>
				<td><input type="submit" /></td>
			</tr>
		</table>
		<input type="hidden" value="CREATE_PATIENT" name="uploadType">
	</form>
</body>
</html>