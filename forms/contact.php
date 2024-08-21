<?php

try {

  if (!isValidRequest()) {
    header('Location: /contact.html?status=false');
    exit();
  }

  $userName = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
  $userEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $userMessage = filter_var($_POST['message'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
  $userSubject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);

  if(!$userName || !$userEmail || !$userMessage || !$userSubject){
    header('Location: /contact.html?status=false');
    exit();
  }


  $body = "
    From: " . $userName . "
    <br>
    Email: " . $userEmail . "
    <br>
    Message: " . $userMessage . "
    <br>
    ";

  $headers = 'From: contactus@finenaturalstone.ca' . "\r\n" .
    'Reply-To: contactus@finenaturalstone.ca' . "\r\n" .
    'Content-Type: text/html; charset=UTF-8';

  mail('contactus@finenaturalstone.ca', $userSubject, $body, $headers);
  header('Location: /contact.html?status=true');
} catch (Exception $e) {
  header('Location: /contact.html?status=false');
}


function isValidRequest()
{

  $secret = '6LfA3CoqAAAAAOeGuINCWYfy_x1M1cUCoo7OZYW0';
  $token = isset($_POST["g-recaptcha-response"]) ? $_POST["g-recaptcha-response"] : null;
  $action = 'submit';
  if (!$token) {
    return false;
  }
  // call curl to POST request 
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $secret, 'response' => $token)));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  curl_close($ch);
  $arrResponse = json_decode($response, true);


  if ($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
    return true;
  }
  return false;
}
