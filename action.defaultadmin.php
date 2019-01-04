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
	echo $this->SetTabHeader('emails', 'Emails', ('emails' == $tab)?true:false);
	echo $this->SetTabHeader('config', 'Config', ('config' == $tab)?true:false);	
	echo $this->EndTabHeaders();

	echo $this->StartTabContent();
	
	
	echo $this->StartTab('pres', $params);
	include(dirname(__FILE__).'/action.admin_presence_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('emails', $params);
	include(dirname(__FILE__).'/action.admin_emails_tab.php');
   	echo $this->EndTab();

	echo $this->StartTab('config', $params);
	include(dirname(__FILE__).'/action.admin_config_tab.php');
   	echo $this->EndTab();


echo $this->EndTabContent();

?>


