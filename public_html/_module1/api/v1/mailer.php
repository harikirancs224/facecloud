<?php
include("phpmailer/class.phpmailer.php");
function send_mail($to,$subject,$msg,$fromname)
{
	$mailid=$to;
	$frommailid="connect@facecloud.us";
	//extract($attr);
		
	$signature='<br/>Best Regards<br/>'.SMTITLE.'<br/>connect@facecloud.us';
	if(empty($msg))
		$msg="test";
		$mail = new PHPMailer();
		//$mailid = "santosh.avudari@gmail.com";

		//GMAIL config
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			//$mail->SMTPSecure = "ssl";                 // sets the prefix to the server
			//$mail->Host       = "ns1.wayitsolutions.com";      // sets GMAIL as the SMTP server
			$mail->Host       = "mail.facecloud.us";      // sets GMAIL as the SMTP server
			$mail->Port       = 25;                   // set the SMTP port for the GMAIL server
			$mail->Username   = "yksabr8";  // GMAIL username
			$mail->Password   = "@$)%wtnm%)K";            // GMAIL password

		//End Gmail
 
 
			$mail->From       = $frommailid;
			$mail->FromName   = $fromname;
			$mail->Subject    = $subject;
		//$mail->MsgHTML("the message");

		//mail add
		
			//$body = $msg;
			$body=$msg.$signature;
			
			
			$mail->MsgHTML($body);
			//$pdf->Output('philosophy.pdf',"f");
			//$attachment = chunk_split(base64_encode($pdfdoc));
			//$mail->AddAttachment('spines.png');
			//$mail->AddReplyTo("reply@email.com","reply name");//they answer here, optional

			$mail->AddAddress($mailid,"");
			//$mail->AddAddress("$mailid","name to");
			$mail->IsHTML(true); // send as HTML
			 
			if(!$mail->Send()) {//to see if we return a message or a value bolean
				return "Mailer Error: " . $mail->ErrorInfo;
			}
			else  return "Message sent!";
}