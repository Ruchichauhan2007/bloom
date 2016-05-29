<%@page import="com.vmc.core.mongo.info.M_GoodlifeVitalInfo"%>
<%@ page import="javax.servlet.ServletContext"%>
<%@ page import="javax.servlet.ServletException"%>
<%@ page import="javax.servlet.annotation.WebServlet"%>
<%@ page import="javax.servlet.http.HttpServlet"%>
<%@ page import="javax.servlet.http.HttpServletRequest"%>
<%@ page import="javax.servlet.http.HttpServletResponse"%>



<%@page import="com.vmc.emr.api.EMR"%>

<%@page import="com.vmc.core.internal.util.JobUtil"%>
<%@page import="com.vmc.core.internal.info.VMCRequestInfo"%>
<%@ page import="com.vmc.core.info.VMCServiceInfo"%>

<%@ page import="com.vmc.core.util.MessageDefs"%>
<%@ page import="com.vmc.core.util.VMCException"%>
<%@ page import="com.vmc.core.util.VMCLogger"%>

<%@ page language="java" contentType="text/html; charset=US-ASCII"
	pageEncoding="US-ASCII"%>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=US-ASCII">
<title>Good Life Data</title>
</head>
<body>
	<%
	    // Get the user name and password from he multipart items
	    String userName = null;
	    String password = null;
	    String clientId = null;
	    String institutionName = "";
	    String messageStr = "";
	    String imageName = "";
	    StringBuilder providerListStr = new StringBuilder();
	    String institutioName = request.getServerName() ; 
	    VMCServiceInfo sc = new VMCServiceInfo();
	    sc.setChannel("BROWSER");
        sc.setInstitutionName(institutioName);
	    M_GoodlifeVitalInfo[] goodLifeArray = EMR.getInstance().getGoodlifeVitalData(sc);
	%>
	<table border="1" class="tablesorter" id="userStatusTable">
	<caption>Goodlife Vital Data</caption>
		<thead>
			<tr>
				<th>txdate</th>
				<th>Protocol</th>
				<th>C_ID</th>
				<th>MeterId</th>
				<th>TestTime</th>
				<th>Event</th>
				<th>Sugar_Level</th>																
				<th>Temperature</th>
				<th>Battery</th>
				<th>PeopleID</th>
				<th>check_id</th>

				
			</tr>
		</thead>
		<tbody>
			<%
			    M_GoodlifeVitalInfo temp = null;
			    for (int i = 0; i < goodLifeArray.length; i++)
			    {
			        temp = goodLifeArray[i];
			        
			        if(null != temp.getC_ID())
			        {
			%>
			<tr>
				<td><%=temp.getTxdate()%></td>
				<td><%= temp.getProtocol() %></td>
				<td><%=temp.getC_ID() %></td>								
				<td><%=temp.getMeterID()%></td>
				<td><%=temp.getTestTime()%></td>
				<td><%=temp.getEvent()%></td>
				<td><%=temp.getSugar_Level()%></td>								
				<td><%= temp.getTemperature()%></td>
				<td><%=temp.getBattery()%></td>
				<td><%=temp.getPeopleID()%></td>
				<td><%=temp.getCheck_id()%></td>

			</tr>
			<%
			}
			    }
			%>
		</tbody>
	</table>


</body>
</html>