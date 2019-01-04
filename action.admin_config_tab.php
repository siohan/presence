<?php
if( !isset($gCms) ) exit;
//on vérifie les droits de cet utilisateur
if(!$this->CheckPermission('Presence use') && !$this->CheckPermission('Presence Set Prefs')){
	$message = "Vous n\'avez pas les autorisations pour accéder aux préférences";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('pres');
}
if(isset($params['submit']))
{
	$this->SetPreference('pageid_presence', $params['pageid_presence']);
	$this->SetPreference('bitly_client_id', $params['bitly_client_id']);
	$this->SetPreference('bitly_client_secret', $params['bitly_client_secret']);
	$this->SetPreference('bitly_access_token', $params['bitly_access_token']);
	$this->SetPreference('bitly_redirect_uri', $params['bitly_redirect_uri']);
}
else
{
	$smarty->assign('startform', $this->CreateFormStart ($id, 'admin_config_tab', $returnid));

	$smarty->assign('endform', $this->CreateFormEnd ());

	$smarty->assign('pageid_presence',$this->CreateInputText($id, 'pageid_presence',$this->GetPreference('pageid_presence'),50,255));
	$smarty->assign('bitly_client_id',$this->CreateInputText($id,'bitly_client_id',$this->GetPreference('bitly_client_id',''),50,255));
	$smarty->assign('bitly_client_secret',$this->CreateInputText($id,'bitly_client_secret',$this->GetPreference('bitly_client_secret',''),50,255));
	$smarty->assign('bitly_access_token',$this->CreateInputText($id,'bitly_access_token',$this->GetPreference('bitly_access_token',''),50,255));
	$smarty->assign('bitly_redirect_uri',$this->CreateInputText($id,'bitly_redirect_uri',$this->GetPreference('bitly_redirect_uri'),50,255));
	$smarty->assign('submit', $this->CreateInputSubmit ($id, 'submit', $this->Lang('submit')));

	// Display the populated template
	echo $this->ProcessTemplate ('config.tpl');
}


?>