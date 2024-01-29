<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "office";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    $sql = "SELECT * FROM service WHERE status = 'Y' AND notification_date <= NOW()";

    $result = $conn->query($sql);

if ($result !== false && $result->num_rows > 0 ) {
    while ($row = $result->fetch_assoc()) {

            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                //$mail->Username = '';
                $mail->Username = '';
                //$mail->Password = '';
                $mail->Password = '';
                $mail->SMTPSecure = 'ssl'; 
                $mail->Port = 465; 

                $mail->setFrom('');
                $mail->addAddress($row["email"]); 
                //$mail->addCC('cc@example.com');

                //$mail->addAttachment('/var/tmp/file.tar.gz');

                $mail->isHTML(true);
                $mail->Subject = 'Status about Cloud Subcription';
                $mail->Body = "Dear Concern, Service ID: " . $row["sid"] . "\r\n"."period will be end within 2 days.\n\nBest regards,\nAlif";

                $mail->send();
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
}
     else {
        echo "<tr><td colspan='3'>0 results</td></tr>";
    }
    echo 'Message has been sent';
$conn->close();
?>
