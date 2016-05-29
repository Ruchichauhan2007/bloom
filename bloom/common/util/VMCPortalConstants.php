<?php
 class VMCPortalConstants
{
	public static $ENTITYTYPE_PATIENT ="PATIENT";
	public static $ENTITYTYPE_PROVIDER ="Provider";
    public static $ENTITYTYPE_FAMILY = "FAMILY";

    public static $NO_UPDATE = "0";
    public static $INSERT = "1";
    public static $UPDATE = "2";
    public static $DELETE = "3";
//i18Ids	
	public static $EMAILI18ID = "161";
    public static $ADDRESSI18ID = "160";
    public static $PHONEI18ID = "159";


	// Various gender codes.
    public static $GENDER_MALE = "M";
    public static $GENDER_FEMALE = "F";
    public static $GENDER_NOT_AVAILABLE = "NA";
	
	//User Status
    public static $USERSTATUS_AVAILABLE = "AV";
    public static $USERSTATUS_UNAVAILABLE = "UN";
    public static $USERSTATUS_BUSY = "BUSY";

	// Different Role type
    public static $ROLETYPE_PATIENT = "ROLEPATIENT";
    public static $ROLETYPE_PROVIDER = "ROLEPROVIDER";
    public static $ROLETYPE_FAMILYADMIN = "ROLEFAMILYADMIN";

	// AuthenticationMethod
    public static $AUTHENTICATION_METHOD_IMAGEANDPIN = "IMAGEANDPIN";
    public static $AUTHENTICATION_METHOD_PASSWORD = "PASSWORD";
    public static $AUTHENTICATION_METHOD_OAUTH = "OAUTH";
    public static $AUTHENTICATION_METHOD_SIGNIN = "SIGNIN";	

	// Entity Status
    public static $ENTITY_STATUS_ACTIVE = "ACTIVE";
    public static $ENTITY_STATUS_INACTIVE = "INACTIVE";
    public static $ENTITY_STATUS_REMOVED = "REMOVED";

	public static $ALL= "ALL";
    public static $MYPATIENT= "MYPATIENT";
    public static $PHP_TRUE= "1";
    public static $PHP_FALSE= "";
    public static $PROVIDER= "Provider";

	public static $API_ADMIN = "ADMIN";
	public static $API_EMR = "EMR";

	public static $PASSWORD_CHANGE_REQUIRED = "PASSWORD_CHANGE_REQUIRED";
	
	public static $PHP_EMPTY = "";
	
	public static $API_RESPONSE_NULL = "NULL response returned from API.";
	
	public static $FORGOT_USERNAME = "FORGOT_USERNAME";
	public static $FORGOT_PASSWORD = "FORGOT_PASSWORD";
	
	public static $EMAIL_TYPE = "OFFICE";
	
	public static $GLUCOSE_VITALS = "Glucose";
	
	public static $USER_NOT_AUTHENTICATED_IMAGE_AND_PIN = "IMAGE_AND_PIN_USER_AUTHENTICATION";
	
	public static $BLANK_PARAM = array(); 
	
	public static $COOKIE_TIMEOUT = 300;
	
	public static $RECORDS_PER_PAGE = 5;
	
	public static $HTTP = "http://";
	
	public static $HTTPS = "https://";
	
	public static $TYPE_DMP = "DMP";
	
	public static $TYPE_IOP = "IOP";
	
	public static $ONCALL_PROVIDER_ID = "ON_CALL_PROVIDERID";
	
	public static $PULSE = "PULSE";
	public static $GLUCOSE = "GLUCOSE";
	public static $OXYGEN = "OXYGEN";
	public static $WEIGHT = "WEIGHT";
	public static $PEAKFLOW = "PEAK FLOW";
	public static $DIASTOLIC = "DIASTOLIC";
	public static $SYSTOLIC = "SYSTOLIC";
	
	public static $UNSPECIFIED = "UNSPECIFIED";
	public static $PRE = "PRE";
	public static $POST = "POST";
	
	// Vital loggings for blood oxygen
	public static $ONE = "1";
	public static $TWO = "2";
	public static $THREE = "3";
	public static $FOUR = "4";
	public static $FIVE = "5";
	
// Dropdown controls 
	public static $PATIENT_STATUS = "Status";
	public static $PROGRAM_TYPE = "Program Type";
	public static $TIME_ZONE = "Time Zone";
	public static $CARE_COMMUNICATION_STATUS = "Care Communication Status";
	public static $STAGE = "Stage";
	public static $PATIENT_TYPE = "Patient Type";
	public static $THIS_MONTH = "This Month";
	public static $THIS_QUARTER = "This Quarter";
	public static $PREVIOUS_QUARTER = "Previous Quarter";
	public static $GOALS = "Goals";	
}

 ?>