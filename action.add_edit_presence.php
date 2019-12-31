<?php

if( !isset($gCms) ) exit;

	if (!$this->CheckPermission('Inscriptions use'))
  	{
    		echo $this->ShowErrors($this->Lang('needpermission'));
		return;
   
  	}

	if( isset($params['cancel']) )
  	{
    		$this->RedirectToAdminTab('insc');
    		return;
  	}
//debug_display($_POST, 'Parameters');
$db =& $this->GetDb();

//on instancie qqs lib
$insc_ops = new T2t_presence;
$gp_ops = new groups;
$liste_groupes = $gp_ops->liste_groupes_dropdown();
$error = 0;
$edit = 0;
if( !empty($_POST))
{
	if(isset($_POST['cancel']))
	{
		$this->RedirectToAdminTab();
	}
		if (isset($_POST['record_id']) && $_POST['record_id'] !='')
		{
			$record_id = $_POST['record_id'];
			$edit = 1;
						
		}
		if(isset($_POST['submitasnew']))
		{
			$edit= 0;
		}
				
		if (isset($_POST['nom']) && $_POST['nom'] !='')
		{
			$nom = $_POST['nom'];
		}
		else
		{
			$error++;
		}
		if (isset($_POST['description']) )
		{
			$description = $_POST['description'];
		}
		if (isset($_POST['date_debut']) && $_POST['date_debut'] !='')
		{
			$date_debut = $_POST['date_debut'];
		}
		
		if (isset($_POST['heure_debut']) && $_POST['heure_debut'] !='')
		{
			$heure_debut = $_POST['heure_debut'];
		}
		else
		{
			$heure_debut = '00:00:00';
		}
		if (isset($_POST['date_limite']) && $_POST['date_limite'] !='')
		{
			$date_limite = $_POST['date_limite'];
		}
		if (isset($_POST['actif']) && $_POST['actif'] !='')
		{
			$actif = $_POST['actif'];
		}
		if (isset($_POST['groupe']) && $_POST['groupe'] !='')
		{
			$groupe = $_POST['groupe'];
		}
		if (isset($_POST['group_notif']) && $_POST['group_notif'] !='')
		{
			$group_notif = $_POST['group_notif'];
		}
		if($error < 1)
		{
			
			$pres_ops = new T2t_presence;
			if($edit == 0)
			{
				$add = $insc_ops->add_presence($nom, $description, $date_debut, $heure_debut, $date_limite, $actif, $groupe, $group_notif);
				if(true === $add)
				{
					$this->SetMessage('Présence ajoutée');
				}
				else
				{
					$this->SetMessage('Présence non ajoutée !!');
				}
			}
			else
			{
				$edit = $insc_ops->edit_presence($record_id,$nom, $description, $date_debut, $heure_debut,$date_limite, $actif,$groupe, $group_notif);
				if(true === $edit)
				{
					$this->SetMessage('Présence modifiée');
				}
				else
				{
					$this->SetMessage('Présence non modifiée !!');
				}
			}
		}
		else
		{
			$this->SetMessage('Il manque le nom !');
		}
			
			
		$this->RedirectToAdminTab('pres');//($id,'add_types_cotis_categ',$returnid, array('record_id'=>$record_id));
	
}
else
{
	//debug_display($params, 'Parameters');
	$record_id = '';
	$index = 0;
	$libelle = '';
	$actif = 0;
	$edit = 0;
	$nom = '';
	$description = '';
	$groupe = '1';
	$group_notif = 0;
	$date_debut = date('Y-m-d');
	$date_limite = date('Y-m-d');
	//s'agit-il d'une modif ou d'une créa ?
	if(isset($params['record_id']) && $params['record_id'] !="")
	{
			$record_id = $params['record_id'];
			$edit = 1;//on est bien en train d'éditer un enregistrement
			//ON VA CHERCHER l'enregistrement en question
			$details = $insc_ops->details_presence($record_id);
			$nom = $details['nom'];
			$description = $details['description'];
			$date_debut = $details['date_debut'];
			$heure_debut = $details['heure_debut'];
			$date_limite = $details['date_limite'];
			$actif = $details['actif'];
			$groupe = $details['groupe'];
			$group_notif = $details['group_notif'];
	}
	
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('add_edit_presence.tpl'), null, null, $smarty);
	$tpl->assign('edit', $edit);
	$tpl->assign('nom', $nom);
	$tpl->assign('record_id', $record_id);
	$tpl->assign('description', $description);
	$tpl->assign('actif', $actif);
	$tpl->assign('date_debut', $date_debut);
	$tpl->assign('date_limite', $date_limite);
	$tpl->assign('groupe', $groupe);
	$tpl->assign('group_notif', $group_notif);
	$tpl->assign('liste_groupes', $liste_groupes);
	$tpl->display();
}

#
# EOF
#
?>
