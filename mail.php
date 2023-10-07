<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
        $name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $subject = trim($_POST["subject"]);
        $message = trim($_POST["message"]);

        if ( empty($name) OR empty($message) OR empty($subject) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo '<p class="alert alert-danger">Пожалуйста, заполните форму и повторите попытку.</p>';
            exit;
        }

        $recipient = "sektortvoridobro@gmail.com"; //email

        $content = "Имя: $name\n";
        $content .= "Email: $email\n\n";
        $content .= "Сообщение:\n$message\n";

        $headers = "From: $name <$email>";

        if (mail($recipient, $subject, $content, $headers)) {
            http_response_code(200);
            echo '<p class="alert alert-success">Ваше обращение отправлено!</p>';
        } else {
            http_response_code(500);
            echo '<p class="alert alert-danger">Упс! Что-то пошло не так, мы не смогли отправить ваше сообщение.</p>';
        }
    } else {
        http_response_code(403);
        echo '<p class="alert alert-danger">Возникла проблема с вашей отправкой, пожалуйста, повторите попытку.</p>';
    }
?>
