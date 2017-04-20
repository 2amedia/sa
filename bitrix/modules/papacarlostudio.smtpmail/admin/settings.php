<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_before.php';
require_once $_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/modules/main/prolog.php';

IncludeModuleLangFile(__FILE__);
$MODULE_ID = 'papacarlostudio.smtpmail';
$pathPrivateKey = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/' . $MODULE_ID . '/config/private_' . $_REQUEST['SITE_ID'] . '.key';

$POST_RIGHT = $APPLICATION->GetGroupRight($MODULE_ID);

if ($POST_RIGHT == 'D')
	$APPLICATION->AuthForm(GetMessage('ACCESS_DENIED'));

CJSCore::Init(array('jquery'));
$APPLICATION->SetTitle(GetMessage($MODULE_ID . '_SETTINGS_TITLE'));
$APPLICATION->AddHeadScript('/bitrix/js/' . $MODULE_ID . '/script.js');

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_REQUEST['save'] != '' || $_REQUEST['apply'] != '') && $POST_RIGHT == 'W') {
	foreach ($_REQUEST as $key => $value) {
		if (preg_match('#^SMTP_#is', $key)) {
			if ($key == 'SMTP_DKIM_PRIVATE') {
				file_put_contents($pathPrivateKey, $value);
			} else {
				COption::SetOptionString($MODULE_ID, $key . '_' . $_REQUEST['SITE_ID'], $value);
			}
		}
	}
	
	if (!isset($_REQUEST['SMTP_ACTIVE']))
		COption::SetOptionString($MODULE_ID, 'SMTP_ACTIVE_' . $_REQUEST['SITE_ID'], 'N');
	
	if (!isset($_REQUEST['SMTP_DKIM_ACTIVE']))
		COption::SetOptionString($MODULE_ID, 'SMTP_DKIM_ACTIVE_' . $_REQUEST['SITE_ID'], 'N');
}

$privateKey = file_get_contents($pathPrivateKey);
?>
<form method="POST" action="<?=$MODULE_ID . '_settings.php?SITE_ID=' . $_REQUEST['SITE_ID'] . '&lang=' . LANG?>" name="PAPACARLOSTUDIO_SMTPMAIL">
	<?
	$aTabs = array(array(
		'DIV' => 'smtp',
		'TAB' => GetMessage($MODULE_ID . '_SETTINGS_TAB_SETTINGS_TITLE'),
		'ICON' => 'main_user_edit',
		'TITLE' => GetMessage($MODULE_ID . '_SETTINGS_TAB_SETTINGS_TITLE')
	), array(
		'DIV' => 'auth',
		'TAB' => GetMessage($MODULE_ID . '_SETTINGS_TAB_SMTP_AUTH_TITLE'),
		'ICON' => 'main_user_edit',
		'TITLE' => GetMessage($MODULE_ID . '_SETTINGS_TAB_SMTP_AUTH_TITLE')
	), array(
		'DIV' => 'dkim',
		'TAB' => GetMessage($MODULE_ID . '_SETTINGS_TAB_SMTP_DKIM_TITLE'),
		'ICON' => 'main_user_edit',
		'TITLE' => GetMessage($MODULE_ID . '_SETTINGS_TAB_SMTP_DKIM_TITLE')
	), array(
		'DIV' => 'standart_settings',
		'TAB' => GetMessage($MODULE_ID . '_SETTINGS_TAB_STANDART_SETTINGS_TITLE'),
		'ICON' => 'main_user_edit',
		'TITLE' => GetMessage($MODULE_ID . '_SETTINGS_TAB_STANDART_SETTINGS_TITLE')
	));
	
	$tabControl = new CAdminTabControl('tabControl', $aTabs);
	
	$tabControl->Begin();
	$tabControl->BeginNextTab();
	?>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_ACTIVE_TITLE')?></td>
			<td width="60%"><input type="checkbox" name="SMTP_ACTIVE" size="40" value="Y" <?=COption::GetOptionString($MODULE_ID, 'SMTP_ACTIVE_' . $_REQUEST['SITE_ID']) == 'Y' ? 'checked' : ''?> /></td>
		</tr>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_HOST_TITLE')?></td>
			<td width="60%"><input type="text" name="SMTP_HOST" size="40" value="<?=COption::GetOptionString($MODULE_ID, 'SMTP_HOST_' . $_REQUEST['SITE_ID'])?>" /></td>
		</tr>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_SECURE_TITLE')?></td>
			<td width="60%">
				<select name="SMTP_SECURE">
					<option value="" <?=COption::GetOptionString($MODULE_ID, 'SMTP_SECURE_' . $_REQUEST['SITE_ID']) == '' ? 'selected' : ''?>><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_SECURE_VALUE_NONE')?></option>
					<option value="tls" <?=COption::GetOptionString($MODULE_ID, 'SMTP_SECURE_' . $_REQUEST['SITE_ID']) == 'tls' ? 'selected' : ''?>><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_SECURE_VALUE_TLS')?></option>
					<option value="ssl" <?=COption::GetOptionString($MODULE_ID, 'SMTP_SECURE_' . $_REQUEST['SITE_ID']) == 'ssl' ? 'selected' : ''?>><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_SECURE_VALUE_SSL')?></option>
				</select>
				&nbsp;&nbsp;&nbsp;
				<?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_SECURE_PORT_TITLE')?>
				&nbsp;&nbsp;&nbsp;
				<input type="text" name="SMTP_SECURE_PORT" size="10" value="<?=COption::GetOptionString($MODULE_ID, 'SMTP_SECURE_PORT_' . $_REQUEST['SITE_ID'])?>" />
			</td>
		</tr>
	<?$tabControl->BeginNextTab()?>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_LOGIN_TITLE')?></td>
			<td width="60%"><input type="text" name="SMTP_LOGIN" size="40" value="<?=COption::GetOptionString($MODULE_ID, 'SMTP_LOGIN_' . $_REQUEST['SITE_ID'])?>" /></td>
		</tr>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_PASSWORD_TITLE')?></td>
			<td width="60%"><input type="text" name="SMTP_PASSWORD" size="40" value="<?=COption::GetOptionString($MODULE_ID, 'SMTP_PASSWORD_' . $_REQUEST['SITE_ID'])?>" /></td>
		</tr>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_EMAIL_SENDER_TITLE')?></td>
			<td width="60%"><input type="text" name="SMTP_EMAIL_SENDER" size="40" value="<?=COption::GetOptionString($MODULE_ID, 'SMTP_EMAIL_SENDER_' . $_REQUEST['SITE_ID'])?>" /></td>
		</tr>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_NAME_SENDER_TITLE')?></td>
			<td width="60%"><input type="text" name="SMTP_NAME_SENDER" size="40" value="<?=COption::GetOptionString($MODULE_ID, 'SMTP_NAME_SENDER_' . $_REQUEST['SITE_ID'])?>" /></td>
		</tr>
	<?$tabControl->BeginNextTab()?>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_DKIM_ACTIVE_TITLE')?></td>
			<td width="60%"><input type="checkbox" name="SMTP_DKIM_ACTIVE" size="40" value="Y" <?=COption::GetOptionString($MODULE_ID, 'SMTP_DKIM_ACTIVE_' . $_REQUEST['SITE_ID']) == 'Y' ? 'checked' : ''?> /></td>
		</tr>
		<tr>
			<td width="40%">
				<img src="/bitrix/js/main/core/images/hint.gif" style="margin-left: 5px;" onmouseover="BX.hint(this, '', '<?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_DKIM_DOMAIN_HELP')?>')">
				<?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_DKIM_DOMAIN_TITLE')?>
			</td>
			<td width="60%"><input type="text" name="SMTP_DKIM_DOMAIN" size="40" value="<?=COption::GetOptionString($MODULE_ID, 'SMTP_DKIM_DOMAIN_' . $_REQUEST['SITE_ID'])?>" /></td>
		</tr>
		<tr>
			<td width="40%">
				<img src="/bitrix/js/main/core/images/hint.gif" style="margin-left: 5px;" onmouseover="BX.hint(this, '', '<?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_DKIM_SELECTOR_HELP')?>')">
				<?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_DKIM_SELECTOR_TITLE')?>
			</td>
			<td width="60%"><input type="text" name="SMTP_DKIM_SELECTOR" size="40" value="<?=COption::GetOptionString($MODULE_ID, 'SMTP_DKIM_SELECTOR_' . $_REQUEST['SITE_ID'])?>" /></td>
		</tr>
		<tr>
			<td width="40%">
				<img src="/bitrix/js/main/core/images/hint.gif" style="margin-left: 5px;" onmouseover="BX.hint(this, '', '<?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_DKIM_PASSPHRASE_HELP')?>')">
				<?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_DKIM_PASSPHRASE_TITLE')?>
			</td>
			<td width="60%"><input type="text" name="SMTP_DKIM_PASSPHRASE" size="40" value="<?=COption::GetOptionString($MODULE_ID, 'SMTP_DKIM_PASSPHRASE_' . $_REQUEST['SITE_ID'])?>" /></td>
		</tr>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_DKIM_PRIVATE_TITLE')?></td>
			<td width="60%"><textarea name="SMTP_DKIM_PRIVATE" cols="70" rows="10"><?=$privateKey?></textarea></td>
		</tr>
	<?$tabControl->BeginNextTab()?>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_STANDART_GOOGLE_TITLE')?></td>
			<td width="60%"><a href="javascript:void(0)" onclick="PCSSmtpMail.getSetting('GOOGLE')"><?=GetMessage($MODULE_ID . '_SETTINGS_ADD_TITLE')?></a></td>
		</tr>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_STANDART_YANDEX_TITLE')?></td>
			<td width="60%"><a href="javascript:void(0)" onclick="PCSSmtpMail.getSetting('YANDEX')"><?=GetMessage($MODULE_ID . '_SETTINGS_ADD_TITLE')?></a></td>
		</tr>
		<tr>
			<td width="40%"><?=GetMessage($MODULE_ID . '_SETTINGS_SMTP_STANDART_MAIL_TITLE')?></td>
			<td width="60%"><a href="javascript:void(0)" onclick="PCSSmtpMail.getSetting('MAIL')"><?=GetMessage($MODULE_ID . '_SETTINGS_ADD_TITLE')?></a></td>
		</tr>
	<?
		$tabControl->Buttons(array(
			'disabled' => $POST_RIGHT < 'W',
			'back_url' => $MODULE_ID . '_settings.php?lang=' . LANG,
		));
	
	$tabControl->End();
	?>
	<?if (isset($_REQUEST['CHECK_CONNECT']) && $_REQUEST['CHECK_CONNECT'] == 'Y'):?>
		<script type="text/javascript">tabControl.SelectTab('check_connect');</script>
	<?endif?>
</form>
<?
require_once $_SERVER['DOCUMENT_ROOT'] . BX_ROOT . '/modules/main/include/epilog_admin.php';
?>