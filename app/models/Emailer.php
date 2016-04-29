<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Quiz\models;
use PHPMailer;
/**
 * Description of Emailer
 *
 * @author bogdanhaidu
 */
class Emailer
{
function __construct($mail_attributes=array()){
        $mail = new PHPMailer;
     	$mail->isSMTP();                                      // Set mailer to use SMTP
    	$mail->Host = 'athem.serverdedicat.net';  // Specify main and backup SMTP servers
    	$mail->SMTPAuth = true;                               // Enable SMTP authentication
    	$mail->Username = 'bhastudi@bha-studio.com';                 // SMTP username
    	$mail->Password = 'Shostac.15';                           // SMTP password
    	$mail->SMTPSecure = 'tls';  
    	$mail->setFrom('bhastudi@bha-studio.com', 'BHA Studio');
    	$mail->addAddress($mail_attributes["Email"], $mail_attributes["Name"]); 
    	// Enable TLS encryption, `ssl` also accepted
    	if (!isset($mail_attributes["Subject"])) {
    	$mail->Subject = 'Your Quiz Rezults';
    	} else {
    	$mail->Subject = $mail_attributes["Subject"];
    	}
    	$mail->Body    = $mail_attributes["Body"];
    	$mail->AltBody = "";
    	
    	if(!$mail->send()) {
    	    echo 'Message could not be sent.';
    	    echo 'Mailer Error: ' . $mail->ErrorInfo;
    	} else {
    	    echo 'Message has been sent';
    	    //echo $mail_val["Body"];
    	}
    }
}
