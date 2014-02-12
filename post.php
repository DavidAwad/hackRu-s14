<?php



function host_valid($mailhost){
  $host = $mailhost;
  // Check for trailing ., we want one so DNS does not append local domain
  $numchar = strlen($mailhost);
  $dotpos = strrpos($mailhost,'.');
  if($dotpos != $numchar - 1){
    $mailhost .= '.';
  }
  $hasMX = getmxrr($host,$_);
  $hostip = gethostbyname($host);
  //console ("host_valid got mx " . print_r($hasMX, true) . " and hostip $hostip for host $host");
  if( !$hasMX && $hostip == $host ){
    return FALSE;
  } 
  return TRUE;
}

/* Is the email address valid? */
function email_host_valid($str){
  $result = TRUE;
  $emailValid=email_valid($str);
  if(!$emailValid){
    return false;
  }
  $mailhost=explode('@',$str);
  $mailhost = $mailhost[1];
  $hostValid = host_valid($mailhost);
  if(!$hostValid){
    return false;
  }

  return true;
}


//brylon - Validate email
function email_valid($email){
  if(!eregi(  "^" . "[a-z0-9]+([_\\.-][a-z0-9]+)*" . "@" . "([a-z0-9]+([\.-][a-z0-9]+)*)+" . "\\.[a-z]{2,}" . "$", $email)) {
    return false;
  }   
  return true;
}


$dbhandle = sqlite_open('signups.db', 0666, $error);
if (!$dbhandle || $error) die ($error);

$name = sqlite_escape_string($_POST['name']);
$school = sqlite_escape_string($_POST['school']);
$email = sqlite_escape_string($_POST['email']);

if (!email_host_valid($email)) die("Invalid email");

$stm = "SELECT * FROM Signups WHERE email='$email';";
$res = sqlite_query($dbhandle, $stm);

$array = sqlite_fetch_array($res);

if ($array != NULL) die("Already registered");

if ($array == NULL) {

  $stm = "INSERT INTO Signups VALUES ('$name', '$school', '$email');";
  $ok = sqlite_exec($dbhandle, $stm, $error);
  if (!$ok) die("Query exec failed: $error");

}
