<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

include root . '\private\models\signup\model_signup.php';

class controller_signup extends Controller
{
    public string $mail_error = "";

    function __construct()
    {
        $this->model = new model_signup();
        $this->view = new View();
    }

    function action_index()
    {
        $this->view->generate("/signup/signup.php");
    }

    function action_registration()
    {
        $mail = $_POST["email"];
        // $reg = "/^[0-9a-zA-Z]+(\.[0-9a-zA-Z]+)*@([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]([a-z0-9-]*[a-z0-9])?$/";
        // $reg = "/^(?:[\s]*)([\d\w]+(?:\.[\d\w]+)*@(?:[a-z\d](?:[a-z\d-]*[a-z\d])?\.)+[a-z\d](?:[a-z\d-]*[a-z\d])?)(?:[\s]*)$/";
        $reg = "/^(?:\s*)([\d\w!#$%&'*+\/=?^_`{|}~-]+(?:\.[\d\w!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z\d](?:[a-z\d-]*[a-z\d])?\.)+[a-z\d](?:[a-z\d-]*[a-z\d])?)(?:\s*)$/";
        if (preg_match($reg, $mail, $match))
        {
            if ($this->model->add_user(
                $mail,
                $_POST["username"],
                $_POST["password"]))
            {
                //$this->sendMail($mail, $_POST["username"]);
                $work_file = fopen(root . "\src\mail.txt", "a+");
                fwrite($work_file, $_POST["username"] . " " . $match[1] . "\n");
                fclose($work_file);
                $this->view->generate("/home/home.php");
                return;
            }
            else
            {
                $text_error = "User already exists";
            }
        }
        else
        {
            $text_error = "Incorrect email";
        }

        $this->view->generate("/signup/signup.php", $text_error);
    }

    private function sendMail(string $mail_string, string $user)
    {
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'courseworkksis@gmail.com';                     //SMTP username
            $mail->Password   = '15testPassword';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('elgusto@elgusto.com', 'El Gusto');
            //$mail->setFrom('course_work_ksis@mail.ru', 'El Gusto');
            $mail->addAddress($mail_string, $user);     //Add a recipient
            //$mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('courseworkksis@gmail.com', 'El Gusto');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Welcome!';
            $mail->Body    = 'Welcome to ElGusto, <bold>'.$user.'</bold>!';
            $mail->AltBody = 'Welcome to ElGusto, '.$user.'!';

            $mail->send();
            //echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}