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
	
	//on redirige !
	$this->RedirectToAdminTab('notifications');
}
$smarty->assign('start_form', 
		$this->CreateFormStart($id, 'admin_emails_tab', $returnid));
$smarty->assign('end_form', $this->CreateFormEnd ());
$smarty->assign('input_emailpresencesubject', $this->CreateInputText($id, 'emailpresencesubject',$this->GetPreference('email_presence_subject'), 50, 150));
$smarty->assign('input_adminemail', $this->CreateInputText($id, 'adminemail',$this->GetPreference('admin_email'), 50, 150));
$smarty->assign('emailpresencebody', $this->CreateSyntaxArea($id, $this->GetTemplate('presencemail_Sample'), 'emailpresencebody', '', '', '', '', 80, 7));
$smarty->assign('submit', $this->CreateInputSubmit ($id, 'submit', $this->Lang('submit')));
echo $this->ProcessTemplate('notifications.tpl');
#
# EOF
#
?>