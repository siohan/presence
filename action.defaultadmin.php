<?php
if ( !isset($gCms) ) exit; 
	if (!$this->CheckPermission('Presence use'))
	{
		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
	}
	
//debug_display($params, 'Parameters');
echo $this->StartTabheaders();

if(isset($params['activetab']) && !empty($params['activetab']))
  {
    $tab = $params['activetab'];
  } else {
  $tab = 'pres';
 }	
	
	echo $this->SetTabHeader('pres', 'Présences', ('pres' == $tab)?true:false);
	echo $this->SetTabHeader('emails', 'Notifications', ('emails' == $tab)?true:false);
	
	echo $this->EndTabHeaders();

	echo $this->StartTabContent();
	
	
	echo $this->StartTab('pres', $params);
	include(dirname(__FILE__).'/action.admin_presence_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('emails', $params);
	include(dirname(__FILE__).'/action.admin_notifications_tab.php');
   	echo $this->EndTab();


echo $this->EndTabContent();

?>


