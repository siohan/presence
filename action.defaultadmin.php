<?php
if ( !isset($gCms) ) exit; 
	if (!$this->CheckPermission('Presence use'))
	{
		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
	}
	
//debug_display($params, 'Parameters');
echo $this->StartTabheaders();

if(isset($params['__activetab']) && !empty($params['__activetab']))
  {
    $tab = $params['__activetab'];
  } else {
  $tab = 'pres';
 }	
	
	echo $this->SetTabHeader('pres', 'Présences', ('pres' == $tab)?true:false);
	echo $this->SetTabHeader('emails', 'Emails', ('emails' == $tab)?true:false);
	echo $this->SetTabHeader('sms', 'SMS', ('sms' == $tab)?true:false);
	echo $this->SetTabHeader('notif', 'Notifications', ('notif' == $tab)?true:false);
	
	echo $this->EndTabHeaders();

	echo $this->StartTabContent();
	
	
	echo $this->StartTab('pres', $params);
	include(dirname(__FILE__).'/action.admin_presence_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('emails', $params);
	include(dirname(__FILE__).'/action.admin_emails_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('sms', $params);
	include(dirname(__FILE__).'/action.admin_sms_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('notif', $params);
	include(dirname(__FILE__).'/action.admin_notifications_tab.php');
   	echo $this->EndTab();


echo $this->EndTabContent();

?>


