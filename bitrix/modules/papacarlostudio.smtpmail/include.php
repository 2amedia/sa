<?php
IncludeModuleLangFile(__FILE__);

CModule::AddAutoloadClasses('papacarlostudio.smtpmail', array(
	//General classes
	'CPapacarlostudioSmtpmail' => 'classes/general/cpapacarlostudio_smtpmail.php',
));

if (COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_ACTIVE_' . CPapacarlostudioSmtpmail::getCurSite()) == 'Y' && !function_exists('custom_mail')) {
	function custom_mail($to, $subject, $message, $additionalHeaders = '', $additionalParameters = '') {
		require __DIR__ . '/classes/general/phpmailer/PHPMailerAutoload.php';
		$mail = new PHPMailer();
		
		$mail->CharSet = 'UTF-8';
		$mail->isSMTP();
		$mail->Host = COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_HOST_' . CPapacarlostudioSmtpmail::getCurSite());
		$mail->SMTPAuth = true;
		$mail->Username = COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_LOGIN_' . CPapacarlostudioSmtpmail::getCurSite());
		$mail->Password = COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_PASSWORD_' . CPapacarlostudioSmtpmail::getCurSite());
		$mail->SMTPSecure = COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_SECURE_' . CPapacarlostudioSmtpmail::getCurSite());
		$mail->Port = COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_SECURE_PORT_' . CPapacarlostudioSmtpmail::getCurSite());
		
		$mail->setFrom(COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_EMAIL_SENDER_' . CPapacarlostudioSmtpmail::getCurSite()), COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_NAME_SENDER_' . CPapacarlostudioSmtpmail::getCurSite()));
		$mail->addAddress($to);
		$mail->isHTML(true);
		
		$mail->Subject = $subject;
		$mail->Body = $message;
		
		$arAdditionalHeaders = explode("\n", $additionalHeaders);
	 
		if (is_array($arAdditionalHeaders)){
			foreach ($arAdditionalHeaders as $key => $value) {
				$arAdditionalHeaders_ = explode(':', $value);
				
				if (strtolower(trim($arAdditionalHeaders_[0])) == 'bcc') {
					$addBccs = explode(',', $arAdditionalHeaders_[1]);
					
					foreach ($addBccs as $addBcc)
						$mail->addBCC($addBcc);
				} elseif (strtolower(trim($arAdditionalHeaders_[0])) == 'cc') {
					$addCcs = explode(',', $arAdditionalHeaders_[1]);
					
					foreach ($addCcs as $addCc)
						$mail->addCC($addCc);
				} elseif (strtolower(trim($arAdditionalHeaders_[0])) == 'reply-to') {
					$mail->addReplyTo($arAdditionalHeaders_[1]);
				} elseif (strtolower(trim($arAdditionalHeaders_[0])) == 'content-type') {
					$mail->ContentType = $arAdditionalHeaders_[1];
				} else {
					$mail->AddCustomHeader($arAdditionalHeaders_[0], $arAdditionalHeaders_[1]);
				}
			}
		}
		
		if (COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_DKIM_ACTIVE_' . CPapacarlostudioSmtpmail::getCurSite()) == 'Y') {
			$mail->DKIM_domain = COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_DKIM_DOMAIN');
			$mail->DKIM_private = __DIR__ . '/config/private_' . CPapacarlostudioSmtpmail::getCurSite() . '.key';
			$mail->DKIM_selector = COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_DKIM_SELECTOR');
			$mail->DKIM_passphrase = COption::GetOptionString(CPapacarlostudioSmtpmail::MODULE_ID, 'SMTP_DKIM_PASSPHRASE');
			$mail->DKIM_identity = $mail->From;
		}
		
		return $mail->send();
	}
}
?>