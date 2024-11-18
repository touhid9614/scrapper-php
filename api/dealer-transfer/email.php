<?php

function report_mail($type, $mail_report)
{
    $email = ['rabbi@smedia.ca', 'tanvir@smedia.ca', 'sifat@smedia.ca'];
    $from  = "reporting@smedia.ca";

    $date = date('d/m/Y h:i:s a', time());

    $subject = "CRON Job Reporting - $type - $date";
    $message = "<b>Hello</b>,<br><p> Cron job of $type running at $date. The summary of the cron job is in the table.</p><br>";

    $message .= '<table border="1">'
        . " <thead>"
        . "         <th>Dealership</th>"
        . "         <th>status</th>"
        . " </thead>";

    foreach ($mail_report as $dealer => $status) {
        $message .= "<tr>"
            . " <td>{$dealer}</td>"
            . " <td>{$status}</td>"
            . "</tr>";
    }

    $message .= "</table>";

    SendEmail($email, $from, $subject, $message);
}