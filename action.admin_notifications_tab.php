<?php
if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Presence use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
if(isset($params['submit']))
{
	//on sauvegarde ! Ben ouais !
	$this->SetPreference('admin_email', $params['adminemail']);
	$this->SetPreference('email_presence_subject', $params['emailpresencesubject']);
	$this->SetTemplate('presencemail_Sample', $params['emailpresencebody']);
	
	$this->SetPreference('sms_sender', $params['sms_sender']);
	$this->SetPreference('bitly_client_id', $params['bitly_client_id']);
	$this->SetPreference('bitly_client_secret', $params['bitly_client_secret']);
	$this->SetPreference('bitly_access_token', $params['bitly_access_token']);
	$this->SetTemplate('sms_relance', $params['sms_relance']);
	$this->SetPreference('bitly_redirect_uri', $params['bitly_redirect_uri']);
	//on redirige !
	$this->RedirectToAdminTab('notifications');
}
$smarty->assign('start_form', 
		$this->CreateFormStart($id, 'admin_notifications_tab', $returnid));
$smarty->assign('end_form', $this->CreateFormEnd ());
$smarty->assign('pageid_presence', $this->CreateInputText($id, 'pageid_presence',$this->GetPreference('pageid_presence'), 50, 150));
$smarty->assign('input_emailpresencesubject', $this->CreateInputText($id, 'emailpresencesubject',$this->GetPreference('email_presence_subject'), 50, 150));
$smarty->assign('input_adminemail', $this->CreateInputText($id, 'adminemail',$this->GetPreference('admin_email'), 50, 150));
$smarty->assign('emailpresencebody', $this->CreateSyntaxArea($id, $this->GetTemplate('presencemail_Sample'), 'emailpresencebody', '', '', '', '', 80, 7));

$smarty->assign('sms_sender', $this->CreateInputText($id, 'sms_sender',$this->GetPreference('sms_sender'), 50, 150));
$smarty->assign('bitly_client_id', $this->CreateInputText($id, 'bitly_client_id',$this->GetPreference('bitly_client_id'), 50, 150));
$smarty->assign('bitly_client_secret', $this->CreateInputText($id, 'bitly_client_secret',$this->GetPreference('bitly_client_secret'), 50, 150));
$smarty->assign('bitly_access_token', $this->CreateInputText($id, 'bitly_access_token',$this->GetPreference('bitly_access_token'), 50, 150));
$smarty->assign('bitly_redirect_uri', $this->CreateInputText($id, 'bitly_redirect_uri',$this->GetPreference('bitly_redirect_uri'), 50, 150));
$smarty->assign('sms_relance', $this->CreateSyntaxArea($id, $this->GetTemplate('sms_relance'), 'sms_relance', '', '', '', '', 80, 7));
$smarty->assign('submit', $this->CreateInputSubmit ($id, 'submit', $this->Lang('submit')));
echo $this->ProcessTemplate('notifications.tpl');
#
# EOF
#
?>