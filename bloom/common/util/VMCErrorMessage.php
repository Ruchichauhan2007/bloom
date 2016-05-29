<?php
class    VMCErrorMessage
{
		function   errorMessage($error)
		{
	$VMCErrorMessageArray = array(
        'INVALID_USERNAME' => 'You have entered an incorrect username. Please try again. ',
		'USER_NOT_AUTHENTICATED' => 'You have entered an incorrect password. Please try again. ',
		'IMAGE_AND_PIN_USER_AUTHENTICATION' => 'You have selected an incorrect IMAGE or PIN, please retry. ',
		'PASSWORD_TOO_SIMPLE' => 'Password too short ,must be at least 8 characters. ',
		'PASSWORD_MATCH_FAIL' => 'Passwords do not match.',
		'CR_EmailAddress_Emails_UX' => 'Email address is already registered.',
		'DUPLICATE_USER' => 'User name already registered.',
		'CANNOT_INSERT_DUPLICATE_ENTITY' => 'Cannot insert duplicate entity.',
		'USER_NOT_ACTIVE' => 'Your account is inactive,Please contact your administrator.',
		'PATIENT_ASSIGNED_TO_PROVIDER' =>'Patient assigned to provider',
		'USERNAME_ALREADY_TAKEN' => 'User name already registered.',
		'PATIENT_ALREADY_REGISTERED_WITH_SAME_DETAILS' => 'Patient already registered with same details.',
		'PATIENT_EMAILID_ALREADY_REGISTERED' => 'Patient email address is already registered.',
		'NO_SURVEYS_CONFIGURED' => 'No survey configured.',
		'INVALID_SURVEY_CONFIGID' => 'Invalid survey config id supplied.',
		'NO_SURVEYS_ASSIGNED_TO_PATIENT' => 'No survey assigned to patient.',
		'COULD_NOT_FIND_SURVEY_PAGE' => 'Could not find survey page.',
		'INVALID_SURVEYID_SENT_FOR_UPDATE' => 'Invalid survey ID sent for update.',
		'SURVEY_ALREADY_REVIEWED_NO_FURTHER_UPDATES_ALLOWED' => 'Survey already reviewed no further updates allowed.',
		'SURVEY_CAN_NOT_BE_REVIEWED_UNTIL_ALL_PAGES_ARE_COMPLETED' => 'Survey can not be reviwed until all pages are completed.',
		'USER_DOES_NOT_EXIST_IN_SYSTEM' => 'User does not exist in system.',
		'COULD_NOT_FIND_USER_IN_KANNACT_WITH_SUPPLIED_INFORMATION' => 'The entered information does not match to our records. Please confirm you have entered the information correctly and resubmit.',
		"This copy request is illegal because it is trying to copy an object to itself without changing the object's metadata, storage class, website redirect location or encryption attributes." => 'This fax is already assigned to same patient.'
    );
	  return str_replace( array_keys($VMCErrorMessageArray), array_values($VMCErrorMessageArray), $error);
		}
}
$VMCMessage=new  VMCErrorMessage();
$VMCMessage->errorMessage($error);

?>
