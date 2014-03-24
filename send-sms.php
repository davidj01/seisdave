<?php
// Install the library via PEAR or download the .zip file to your project folder.
// This line loads the library
require_once __DIR__ . '/twilio-php/Services/Twilio.php';

$sid = 'ACcc0ce8fe23f48f7dcc527e9f3b25f417'; // Your Account SID from www.twilio.com/user/account
$token = '121f5d9ef3a6cd233847c930b950ff6c'; // Your Auth Token from www.twilio.com/user/account

$client = new Services_Twilio($sid, $token);
$message = $client->account->messages->sendMessage(
  '+16122551559', // From a valid Twilio number
  '+16128125823', // Text this number
  "Danger! Someone has accessed your send-sms.php page!"
);

print $message->sid;
// Display a confirmation message on the screen
echo 'Sent message {$sms->sid}';
?>