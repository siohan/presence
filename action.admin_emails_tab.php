<?php
if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Presence use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
if(!empty($_POST))
{
	if( isset($_POST['cancel']) ) {
            $this->RedirectToAdminTab();
        }
	//on sauvegarde ! Ben ouais !
	$this->SetPreference('pageid_presence', $_POST['pageid_presence']);
	//$this->SetPreference('admin_email', $_POST['adminemail']);
	$this->SetPreference('email_presence_subject', $_POST['emailpresencesubject']);
	$this->SetTemplate('presencemail_Sample', $_POST['emailpresencebody']);
	
	//on redirige !
	$this->RedirectToAdminTab('emails');
	
}
else
{
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('admin_emails.tpl'), null, null, $smarty);
	$tpl->assign('pageid_presence', $this->GetPreference('pageid_presence'));
	$tpl->assign('email_presence_subject', $this->GetPreference('email_presence_subject'));
	$tpl->assign('presencemail_Sample', $this->GetTemplate('presencemail_Sample'));
	$tpl->display();
}

#
# EOF
#
?>