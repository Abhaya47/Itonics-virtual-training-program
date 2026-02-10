<?php
require_once "helpers/mailer.php";

if (sendMail("tusharluitel88@gmail.com", "SMTP Test", "<b>HIII</b>")) {
    echo "Mail sent successfully";
} else {
    echo "Mail failed";
}
