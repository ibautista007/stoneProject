<?php
try {
  echo 'Message has been sent';
  exit;
  $userName = filter_var($_POST['name'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);;
  $userEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
  $userMessage = filter_var($_POST['message'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);;
  $userSubject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);;
  $body = "
    From: ".$userName."
    <br>
    Email: ".$userEmail."
    <br>
    Message: ".$userMessage."
    <br>
    ";

    $headers = 'From: contacus@finenaturalstone.ca' . "\r\n" .
                'Reply-To: contacus@finenaturalstone.ca'. "\r\n". 
                'Content-Type: text/html; charset=UTF-8';

    mail($userEmail, $userSubject, $body, $headers);
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
