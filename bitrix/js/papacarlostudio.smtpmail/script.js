var PCSSmtpMail = {
	getSetting: function(mailType) {
		if (mailType == 'GOOGLE') {
			$('form[name="PAPACARLOSTUDIO_SMTPMAIL"] input[name="SMTP_HOST"]').val('smtp.gmail.com');
			$('form[name="PAPACARLOSTUDIO_SMTPMAIL"] select[name="SMTP_SECURE"]').val('ssl');
			$('form[name="PAPACARLOSTUDIO_SMTPMAIL"] input[name="SMTP_SECURE_PORT"]').val('465');
		} else if (mailType == 'YANDEX') {
			$('form[name="PAPACARLOSTUDIO_SMTPMAIL"] input[name="SMTP_HOST"]').val('smtp.yandex.ru');
			$('form[name="PAPACARLOSTUDIO_SMTPMAIL"] select[name="SMTP_SECURE"]').val('ssl');
			$('form[name="PAPACARLOSTUDIO_SMTPMAIL"] input[name="SMTP_SECURE_PORT"]').val('465');
		} else if (mailType == 'MAIL') {
			$('form[name="PAPACARLOSTUDIO_SMTPMAIL"] input[name="SMTP_HOST"]').val('smtp.mail.ru');
			$('form[name="PAPACARLOSTUDIO_SMTPMAIL"] select[name="SMTP_SECURE"]').val('ssl');
			$('form[name="PAPACARLOSTUDIO_SMTPMAIL"] input[name="SMTP_SECURE_PORT"]').val('465');
		}
		
		tabControl.SelectTab('smtp');
	}
}