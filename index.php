<?php
    require 'vendor/autoload.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    use Monolog\Level;
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    // create a log channel
    $log = new Logger('logger');
    $log->pushHandler(new StreamHandler('path/to/your.log', Level::Debug));

    // add records to the log
    $log->info('data:', ['name' => $_POST['name'], 'email' => $_POST['email'], 'desc' => $_POST['text']]);

    include 'ww.php';

    if (isset($_POST['test'])){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = EMAIL;                     //SMTP username
            $mail->Password   = WACHTWOORD;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom(EMAIL);
            $mail->addAddress($_POST['email'], $_POST['name']);     //Add a recipient
            $mail->addCC(EMAIL);


            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Uw klacht is in behandeling';
            $mail->Body    = $_POST['text'];
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
</head>
<body>
    <form action="" method="POST">
        <label>Naam</label>
        <input type="text" placeholder="Naam" name="name">
        <br>
        <label>Email</label>
        <input type="text" placeholder="Email" name="email">
        <br>
        <label>Omschrijving</label>
        <textarea rows="5" placeholder="Omschrijving" name="text"></textarea>
        <br>
        <input type="submit" placeholder="Submit" name="test">
    </form>
</body>
</html>