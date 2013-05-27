<?php
// if($_SERVER["REQUEST_METHOD"] == 'POST') {

  // EDIT THE 2 LINES BELOW AS REQUIRED
  $email_to = "barfek@gmail.com";
  $email_subject = "Wiadomość z szach-mat.info";


  function died($error) {
    // your error code can go here
    die();
  }

  function validate_phone($phone) {
    preg_replace('/[^0-9+]/', '', $phone);
    if(strlen($phone) < 9) {
      $error .= 'Nieprawidłowy numer telefonu.<br>';
    }
    else {
      $error .= '';
    }
    return $error;
  }

  function validate_email($email) {
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
    if(!preg_match($email_exp,$email)) {
      $error .= 'Nieprawidłowy adres email.<br>';
    }
    else {
      $error .= '';
    }
    return $error;
  }

  function validate_message($message) {
    $string_exp = "/^[A-Za-z .'-]+$/";
    if(strlen($message) < 2) {
      $error .= 'Nieprawidłowa treść wiadomości.<br>';
    }
    else {
      $error .= '';
    }
    return $error;
  }

  function validate_form($phone, $email, $message) {
    $error = "";
    // Case 1: No email
    // > validate phone & message[if non-empty]
    if (!empty($phone) && empty($email)) {
      $error .= validate_phone($phone);
      if (!empty($message)) {
        $error .= validate_message($message);
      }
    }
    // Case 2: No phone
    // > validate email & message
    else if (empty($phone) && !empty($email)) { //
      $error .=
        validate_email($email) . validate_message($message);
    }
    // Case 3: All fields non-empty
    // > validate phone, email & message
    else if (!empty($phone) && !empty($email)) {
      $error .=
        validate_phone($phone) . validate_email($email) . validate_message($message);
    }
    // Case 4: Only message non-empty
    else if (!empty($message)) {
      $error .=
        'Podaj email lub telefon!<br>';
    }
    // Case 5: All fields empty
    else {
      $error .=
        'Musisz podać przynajmniej numer telefonu!<br>';
    }
    return $error;
  }

  // validation expected data exists
  if(!isset($_POST['telephone']) || !isset($_POST['email']) || !isset($_POST['message'])) {
    died('Niestety, formularz zawiera błędy.');
  }

  $telephone = $_POST['telephone'];
  $email_from = $_POST['email'];
  $message = $_POST['message'];

  $error = validate_form($telephone, $email_from, $message);

  // check error status & send message if ok
  if(strlen($error) > 0) {
    die(json_encode(array(
      'status' => 0,
      'message'=> $error
    )));
    exit;
  }
  else {
    $data = array(
      'status' => 1,
      'message' => 'Dzięki za wiadomość!<br>',
    );

    $json_string = json_encode($data);

    echo $json_string;
  }

/* EMAIL MESSAGE BELOW */

  $email_message = "Zawartość formularza:\n\n";

  function clean_string($string) {
    $bad = array("content-type","bcc:","to:","cc:","href");
    return str_replace($bad,"",$string);
  }

  $email_message .=
    "Telefon: ".clean_string($telephone)."\n" .
    "Email: ".clean_string($email_from)."\n\n" .
    "Wiadomość: \n\n".clean_string($message)."\n";


  // create email headers
  $headers = 'Od: Wiadomość z szach-mat.info\r\n'.
    'Odpowiedz do: '.$email_from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
  @mail($email_to, $email_subject, $email_message, $headers);
// }
?>
