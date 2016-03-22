<?php
include("phpmailer/class.phpmailer.php");
function pushmail($to,$attr)
{
	$mailid=ADMINEMAIL;$subject="";$msg="";$fromname=SMTITLE;$frommailid="connect@shankam.in";
	extract($attr);
	if(empty($to))
	{
		$mailid=ADMINEMAIL;
		//alert("mailid empty");
	}
		
	$signature='<br/>Best Regards<br/>'.SMTITLE.'<br/>connect@gmail.com';
if(empty($msg))
$msg="test";
		$mail = new PHPMailer();
		//$mailid = "santosh.avudari@gmail.com";

		//GMAIL config
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			//$mail->SMTPSecure = "ssl";                 // sets the prefix to the server
			//$mail->Host       = "ns1.wayitsolutions.com";      // sets GMAIL as the SMTP server
			$mail->Host       = "mail.shankam.in";      // sets GMAIL as the SMTP server
			$mail->Port       = 25;                   // set the SMTP port for the GMAIL server
			$mail->Username   = "sct6w8";  // GMAIL username
			$mail->Password   = "shankam120$$$";            // GMAIL password
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
			// echo "Mailer Error: " . $mail->ErrorInfo;
			}/* else  echo "Message sent!";*/
}