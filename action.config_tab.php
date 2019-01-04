<?php
if( !isset($gCms) ) exit;
//on vérifie les droits de cet utilisateur
if(!$this->CheckPermission('Presence use') && !$this->CheckPermission('Presence Set Prefs')){
	$message = "Vous n\'avez pas les autorisations pour accéder aux préférences";
	$this->SetMessage("$message");
	$this->RedirectToAdminTab('pres');
}

$smarty->assign('startform', $this->CreateFormStart ($id, 'updateoptions', $returnid));

$smarty->assign('endform', $this->CreateFormEnd ());

$smarty->assign('pageid_presence',$this->CreateInputText($id, 'pageid_presence',$this->GetPreference('pageid_presence'),50,255));
$smarty->assign('bitly_client_id',$this->CreateInputText($id,'bitly_client_id',$this->GetPreference('bitly_client_id','1'),50,255));
$smarty->assign('bitly_client_secret',$this->CreateInputText($id,'bitly_client_secret',$this->GetPreference('bitly_client_secret','1'),50,255));
$smarty->assign('bitly_access_token',$this->CreateInputText($id,'bitly_access_token',$this->GetPreference('bitly_access_token','1'),50,255));
$smarty->assign('bitly_redirect_uri',$this->CreateInputText($id,'saison_en_cours',$this->GetPreference('bitly_redirect_uri'),50,255));
$smarty->assign('submit', $this->CreateInputSubmit ($id, 'optionssubmitbutton', $this->Lang('submit')));

// Display the populated template
echo $this->ProcessTemplate ('config.tpl');

?>