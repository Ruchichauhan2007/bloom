<?php
if($_SERVER['HTTPS_HOST'])
{
echo $_SERVER['HTTPS_HOST']."https";
}
else
{
echo $_SERVER['HTTP_HOST']."http";
}
?>