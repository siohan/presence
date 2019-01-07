<?php

if( !isset($gCms) ) exit;

	if (!$this->CheckPermission('Inscriptions use'))
  	{
    		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
   
  	}

	if( isset($params['cancel']) )
  	{
    		$this->RedirectToAdminTab('cotisations');
    		return;
  	}
//debug_display($params, 'Parameters');
$db =& $this->GetDb();
//s'agit-il d'une modif ou d'une créa ?
$record_id = '';
$index = 0;
$libelle = '';
$actif = 0;
$edit = 0;
$insc_ops = new T2t_presence;

if(isset($params['record_id']) && $params['record_id'] !="")
{
		$record_id = $params['record_id'];
		$edit = 1;//on est bien en train d'éditer un enregistrement
		//ON VA CHERCHER l'enregistrement en question
		$details = $insc_ops->details_presence($record_id);
}
$gp_ops = new contact;
$liste_groupes = $gp_ops->liste_groupes();
$OuiNon = array('Oui'=>'1', 'Non'=>'0');	
	
	
	//on construit le formulaire
	$smarty->assign('formstart',
			    $this->CreateFormStart( $id, 'do_add_edit_presence', $returnid ) );
	if($edit==1)
	{
		$smarty->assign('record_id',
				$this->CreateInputHidden($id,'record_id',$record_id));
		
	}
	
	
	$smarty->assign('nom',
			$this->CreateInputText($id,'nom',(isset($details['nom'])?$details['nom']:""),50,200));
	$smarty->assign('description',
			$this->CreateInputText($id,'description',(isset($details['description'])?$details['description']:""),50,200));
	$smarty->assign('date_debut',
			$this->CreateInputDate($id,'date_debut',(isset($details['date_debut'])?$details['date_debut']:"")));
	$smarty->assign('heure_debut',
					$this->CreateInputDate($id,'heure_debut',(isset($details['heure_debut'])?$details['heure_debut']:"00:00")));
	$smarty->assign('date_limite',
			$this->CreateInputDate($id,'date_limite',(isset($details['date_limite'])?$details['date_limite']:"")));
	$smarty->assign('actif',
			$this->CreateInputDropdown($id,'actif',$OuiNon,$selectedindex = $index, $selectedvalue=(isset($details['actif'])?$details['actif']:"")));
	$smarty->assign('groupe',
			$this->CreateInputDropdown($id,'groupe',$liste_groupes,$selectedindex = $index, (isset($details['groupe'])?$details['groupe']:"")));
	
	$smarty->assign('submit',
			$this->CreateInputSubmit($id, 'submit', $this->Lang('submit'), 'class="button"'));
	$smarty->assign('cancel',
			$this->CreateInputSubmit($id,'cancel',
						$this->Lang('cancel')));


	$smarty->assign('formend',
			$this->CreateFormEnd());
	
	



echo $this->ProcessTemplate('add_edit_presence.tpl');

#
# EOF
#
?>
