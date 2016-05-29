<%@page import="java.net.URLDecoder"%>
<%@page import="java.io.UnsupportedEncodingException"%>
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

<%
    // Get the user name and password from he multipart items
    Cookie[] cookies = request.getCookies();
    String userName = null;
    String password = null;
    String authType = null;
    String clientId = null;
    String institutionName = "";
    String messageStr = "";
    String imageName = "";
    StringBuilder providerListStr = new StringBuilder() ; 
    
    VMCRequestInfo reqInfo = null;

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
    catch(UnsupportedEncodingException ex)
    {
    	throw new VMCException(ex.getMessage());
    }
    catch (Exception ex)
    {
    	throw new VMCException(ex.getMessage());
    }
    finally
    {
        if (reqInfo != null)
        {
            reqInfo.release();
        }
    }
%>
<center>
<h2 style="margin-top: 25px;">Bulk Upload Patient</h2>

	<p>
		<%=messageStr%>
	</p>

	<form action="../../../../dataUpload" method="post"
		enctype="multipart/form-data">
		<table style="ali">
			<tr>
				<td>&nbsp</td>
				<td>&nbsp</td>
			</tr>
			<tr>
				<td>&nbsp</td>
				<td>&nbsp</td>
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
				<td>&nbsp</td>
				<td>&nbsp</td>
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
				<td>&nbsp</td>
				<td>&nbsp</td>
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
				<td style="text-align: right;"><input type="submit"  value="Submit"  /></td>
			</tr>
		</table>
		<input type="hidden" value="CREATE_PATIENT" name="uploadType">
		<input type="hidden" value="<%= userName%>" name="user">
		<input type="hidden" value="<%= password%>" name="password">
		<input type="hidden" value="<%= imageName%>" name="imageName">
	</form>
</center>