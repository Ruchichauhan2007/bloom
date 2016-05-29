<?php

class DateUtil
{
/*-- Dec 16 23:14 PM -- */
	function   formatDatetoDashboardCardDate($dateObj)
	{
		$numericMonth = $dateObj->{month};

		$month = array(
			$numericMonth => 'Jan',
			$numericMonth => 'Feb',
			$numericMonth => "Mar",
			$numericMonth => "Apr",
			$numericMonth => "May",
			$numericMonth => "Jun",
			$numericMonth => "Jul",
			$numericMonth => "Aug",
			$numericMonth => "Sep",
			$numericMonth => "Oct",
			$numericMonth => "Nov",
			$numericMonth => "Dec"
		);

		$retDate = str_replace(Array_keys($month), Array_values($month), $numericMonth);

		$retDate = $retDate." ".$dateObj->{dayOfMonth}." ".$dateObj->{hourOfDay}.":";

		if($dateObj->{minute} < 10)
		{
			$retDate = $retDate."0".$dateObj->{minute};
		}
		else
		{
			$retDate = $retDate."".$dateObj->{minute};
		}

		if($dateObj->{hourOfDay} >= 12)
		{
			$dm="PM";
		}
		else
		{
			$dm="AM";
		}

		$retVal = $retDate." ".$dm;

		return $retVal;
	}
// MM/dd/YYYY
	function   formatDatetoContentLibCardDate($dateObj)
	{
		$numericMonth = $dateObj->{month};
		$dayOfMonth = $dateObj->{dayOfMonth};
		if($dayOfMonth < 10)
		{
			$dayOfMonth = "0".$dayOfMonth;
		}
		if($numericMonth < 10)
		{
			$numericMonth = "0".$numericMonth;
		}
		$retDate = $numericMonth."/".$dayOfMonth."/".$dateObj->{year};

		return $retDate;
	}

	function   formatDatetoCardDate($dateObj)
	{
			$dob = explode(" ",$dateObj);
			$retVal = $dob[1]." ".$dob[2];
			$strTime = explode(":",$dob[3]);
			$hour = $strTime[0];
			$mintes = $strTime[1];

			if($hour>=12)
			{
				$dm="PM";
			}
			else
			{
				$dm="AM";
			}

			$retVal = $retVal." ".$hour.":".$mintes." ".$dm;

			return $retVal;
	}
/*
	----Date Format 2014-10-15T22:54:43-----
*/
	function formatCreatedDate($dateObj)
	{
		$dob = explode("T",$dateObj);
		$date = $dob[0];
		$ufTime = explode(".",$dob[1]);
		$time = $ufTime[0];
		$splittedTime = explode(":",$time);

		$splittedDate = explode("-",$date);

		$numMonth =  $splittedDate[1];
		$month = date("M", mktime(null, null, null, $numMonth));
		$day = $splittedDate[2];
		$hours = $splittedTime[0];
		$ampm = "am";
		if($hours >= 12)
		{
			if( $hours != 12)
            {
                 $hours = $hours - 12;
            }
			$ampm = "pm";
		}
		$minutes = $splittedTime[1];

		$retVal = $month." ".$day ." ".$hours.":".$minutes." ".$ampm;

		return $retVal;
	}

	function   formatDatetoPatientCardDate($dateObj)
	{
			$dob = explode(" ",$dateObj);

			if($dob[1] == "Jan")
			{
				$month="01";
			}
			else if($dob[1] == "Feb")
			{
				$month="02";
			}
			else if($dob[1] == "Mar")
			{
				$month="03";
			}
			else if($dob[1] == "Apr")
			{
				$month="04";
			}
			else if($dob[1] == "May")
			{
				$month="05";
			}
			else if($dob[1] == "Jun")
			{
				$month="06";
			}
			else if($dob[1] == "Jul")
			{
				$month="07";
			}
			else if($dob[1] == "Aug")
			{
				$month="08";
			}
			else if($dob[1] == "Sep")
			{
				$month="09";
			}
			else if($dob[1] == "Oct")
			{
				$month="10";
			}
			else if($dob[1] == "Nov")
			{
				$month="11";
			}
			else if($dob[1] == "Dec")
			{
				$month="12";
			}

			$retVal = $month."/".$dob[2]."/".$dob[5];

			return $retVal;
	}

	// MM-dd-YYYY
	function formatDatetoStr($dateObj)
	{
		$dob = explode("T",$dateObj);
		$date = $dob[0];

		$splittedDate = explode("-",$date);

		$numMonth =  $splittedDate[1];

		$retVal = $numMonth."/".$splittedDate[2] ."/".$splittedDate[0];
		
		if(strlen($retVal) <= 2)
		{
			$retVal = "";
		}

		return $retVal;
	}

	// MM-dd-YY HH:MM AM/PM
	function formatPatientCareHeaderDatetoStr($dateObj)
	{
		$dob = explode("T",$dateObj);
		$date = $dob[0];
		$ufTime = explode(".",$dob[1]);
		$time = $ufTime[0];
		$splittedTime = explode(":",$time);

		$splittedDate = explode("-",$date);

		$numMonth =  $splittedDate[1];
		$day = $splittedDate[2];
		$hours = $splittedTime[0];
		$ampm = "AM";
		if($hours >= 12)
		{
			if( $hours != 12)
            {
                 $hours = $hours - 12;
            }
			$ampm = "PM";
		}
		$minutes = $splittedTime[1];

		$retVal = $numMonth."/".$day ."/".substr($splittedDate[0], 2, 4)." ".$hours.":".$minutes." ".$ampm;

		return $retVal;
	}
	
	function formatPatientCareOldDate($dateObj)
	{
		$dob = explode("T",$dateObj);
		$date = $dob[0];
		$ufTime = explode(".",$dob[1]);
		$time = $ufTime[0];
		$splittedTime = explode(":",$time);

		$splittedDate = explode("-",$date);

		$numMonth =  $splittedDate[1];
		$day = $splittedDate[2];
		$hours = $splittedTime[0];
		$ampm = "AM";
		if($hours >= 12)
		{
			if( $hours != 12)
            {
                 $hours = $hours - 12;
            }
			$ampm = "PM";
		}
		$minutes = $splittedTime[1];

		$retVal = $numMonth."/".$day ."/".$splittedDate[0]." ".$hours.":".$minutes." ".$ampm;

		return $retVal;
	}
/*-- Dec 16,2014 23:14 PM --   2014-11-11T13:47:48.343+0530 */
	function   formatDatetoPatientcareObservation($dateObj)

	{

		$dob = explode("T",$dateObj);
		$date = $dob[0];
        $splitmonth = 	explode("-",$dob[0]);
         $numericMonth =  $splitmonth[1];
		 $numericdate =  $splitmonth[2];
		 $year = $splitmonth[0];
		$splittedDate = explode(".",$dob[1]);
		$time= explode(":",$splittedDate[0]);
		$hours = $time[0];
		$minute = $time[1];
		$newtime = $time[0].":".$time[1];

		if($numericMonth==1)
		{
			$numericMonth = 'Jan';

		}
		else if($numericMonth==2)
		{
			$numericMonth ='Feb';

		}
		else if($numericMonth==3)
		{
			$numericMonth ='Mar';

		}
		else if($numericMonth==4)
		{
			$numericMonth ='Apr';

		}
		else if($numericMonth==5)
		{
			$numericMonth ='May';

		}
		else if($numericMonth==6)
		{
			$numericMonth ='Jun';

		}
		else if($numericMonth==7)
		{
			$numericMonth ='Jul';

		}
		else if($numericMonth==8)
		{
			$numericMonth ='Aug';

		}
		else if($numericMonth==9)
		{
			$numericMonth ='Sep';

		}
		else if($numericMonth==10)
		{
			$numericMonth ='Oct';

		}
		else if($numericMonth==11)
		{
			$numericMonth ='Nov';

		}
		else if($numericMonth==12)
		{
			$numericMonth ='Dec';

		}


			if($minute < 10)
		{

			$minute = "0".$minute;
		}
		else
		{
			$minute = $minute;
		}

		if($hours >= 12)
		{
			$dm="PM";
		}
		else
		{
			$dm="AM";
		}
		if($hours > 12)
		{
		 $hours = $hours - 12;
		}
		 $retVal = $numericMonth." ".$numericdate.",".$year." ".$hours.":".$minute. " ".$dm;

		return $retVal;

	}
	
	/*-- 16 dec 2014 23:14 PM --   2014-11-11T13:47:48.343+0530 */
	function   formatDatetoPatientcareCommunication($dateObj)

	{

		$dob = explode("T",$dateObj);
		$date = $dob[0];
        $splitmonth = 	explode("-",$dob[0]);
         $numericMonth =  $splitmonth[1];
		 $numericdate =  $splitmonth[2];
		 $year = $splitmonth[0];
		$splittedDate = explode(".",$dob[1]);
		$time= explode(":",$splittedDate[0]);
		$hours = $time[0];
		$minute = $time[1];
		$newtime = $time[0].":".$time[1];

		if($numericMonth==1)
		{
			$numericMonth = 'JAN';

		}
		else if($numericMonth==2)
		{
			$numericMonth ='FEB';

		}
		else if($numericMonth==3)
		{
			$numericMonth ='MAR';

		}
		else if($numericMonth==4)
		{
			$numericMonth ='APR';

		}
		else if($numericMonth==5)
		{
			$numericMonth ='MAY';

		}
		else if($numericMonth==6)
		{
			$numericMonth ='JUN';

		}
		else if($numericMonth==7)
		{
			$numericMonth ='JUL';

		}
		else if($numericMonth==8)
		{
			$numericMonth ='AUG';

		}
		else if($numericMonth==9)
		{
			$numericMonth ='SEP';

		}
		else if($numericMonth==10)
		{
			$numericMonth ='OCT';

		}
		else if($numericMonth==11)
		{
			$numericMonth ='NOV';

		}
		else if($numericMonth==12)
		{
			$numericMonth ='DEC';

		}


			if($minute < 10)
		{

			$minute = "0".$minute;
		}
		else
		{
			$minute = $minute;
		}

		if($hours >= 12)
		{
			$dm="PM";
		}
		else
		{
			$dm="AM";
		}
		if($hours > 12)
		{
		 $hours = $hours - 12;
		}
		 $retVal = $numericdate." ".$numericMonth." ".$year." ".$hours.":".$minute. " ".$dm;

		return $retVal;

	}

	/*-- Dec 16,2014  ---   2014-11-11T13:47:48.343+0530 */
	function   formatDateForDob($dateObj)

	{

		$dob = explode("T",$dateObj);
		$date = $dob[0];
		$splitmonth = 	explode("-",$dob[0]);
		$numericMonth =  $splitmonth[1];
		$numericdate =  $splitmonth[2];
		$year = $splitmonth[0];
		$splittedDate = explode(".",$dob[1]);
		$time= explode(":",$splittedDate[0]);
		$hours = $time[0];
		$minute = $time[1];
		$newtime = $time[0].":".$time[1];

		if($numericMonth==1)
		{
			$numericMonth = 'Jan';

		}
		else if($numericMonth==2)
		{
			$numericMonth ='Feb';

		}
		else if($numericMonth==3)
		{
			$numericMonth ='Mar';

		}
		else if($numericMonth==4)
		{
			$numericMonth ='Apr';

		}
		else if($numericMonth==5)
		{
			$numericMonth ='May';

		}
		else if($numericMonth==6)
		{
			$numericMonth ='Jun';

		}
		else if($numericMonth==7)
		{
			$numericMonth ='Jul';

		}
		else if($numericMonth==8)
		{
			$numericMonth ='Aug';

		}
		else if($numericMonth==9)
		{
			$numericMonth ='Sep';

		}
		else if($numericMonth==10)
		{
			$numericMonth ='Oct';

		}
		else if($numericMonth==11)
		{
			$numericMonth ='Nov';

		}
		else if($numericMonth==12)
		{
			$numericMonth ='Dec';

		}


		if($minute < 10)
		{

			$minute = "0".$minute;
		}
		else
		{
			$minute = $minute;
		}

		if($hours >= 12)
		{
			$dm="PM";
		}
		else
		{
			$dm="AM";
		}
		if($hours > 12)
		{
			$hours = $hours - 12;
		}
		$retVal = $numericMonth." ".$numericdate.",".$year;

		return $retVal;

	}

	/** Format Input date into Calendar */
	function   formatInputDateIntoCalendar($dateObj)
	{
		$pos = strpos($dateObj, "/");

		if($pos === FALSE)
		{
			$dateArray = explode("-", $dateObj);
		}
		else
		{
			$dateArray = explode("/", $dateObj);
		}

		$dateObj = $dateArray[2]."-".$dateArray[0]."-".$dateArray[1];
		$retDate = formatISO8601Date(strtotime($dateObj));

		return $retDate;
	}
}
?>