<?php
  $to      = "sealofhealth@gmail.com";
  $message = "
  Hello $uname,
  <br /><br />
  Welcome to Seal of Health!<br/>
  To complete your registration, please click on the following link
  <br /><br />
  <a href='https://sealofhealth.com/verify.php?id=$userID&code=$code'>Click HERE to Activate</a>
  <br /><br />
  Thank You,
  <br/>
  Seal of Health Development Team";
  $subject = "Confirm Registration";
  $headers = 'From: noreply@sealofhealth.com' . "\r\n";
  mail($email, $subject, $message, $headers);
?>
