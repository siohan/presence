<?php
if (!isset($gCms)) exit;
debug_display($params, 'Parameters');

	if (!$this->CheckPermission('Presence use'))
	{
		$designation .=$this->Lang('needpermission');
		$this->SetMessage("$designation");
		$this->RedirectToAdminTab('pres');
	}

//on récupère les valeurs
//pour l'instant pas d'erreur
$aujourdhui = date('Y-m-d ');
$error = 0;
$edit = 0;//pour savoir si on fait un update ou un insert; 0 = insert
$insc_ops = new T2t_presence;	
		
		
		if (isset($params['record_id']) && $params['record_id'] !='')
		{
			$record_id = $params['record_id'];
			$edit = 1;
						
		}
				
		if (isset($params['nom']) && $params['nom'] !='')
		{
			$nom = $params['nom'];
		}
		else
		{
			$error++;
		}
		if (isset($params['description']) && $params['description'] !='')
		{
			$description = $params['description'];
		}
		if (isset($params['date_debut']) && $params['date_debut'] !='')
		{
			$date_debut = $params['date_debut'];
		}
		
		if (isset($params['heure_debut']) && $params['heure_debut'] !='')
		{
			$heure_debut = $params['heure_debut'];
		}
		else
		{
			$heure_debut = '1970-01-01';
		}
		if (isset($params['date_limite']) && $params['date_limite'] !='')
		{
			$date_limite = $params['date_limite'];
		}
		if (isset($params['actif']) && $params['actif'] !='')
		{
			$actif = $params['actif'];
		}
		if (isset($params['groupe']) && $params['groupe'] !='')
		{
			$groupe = $params['groupe'];
		}
		
		
		if($error < 1)
		{
			
			$pres_ops = new T2t_presence;
			if($edit == 0)
			{
				$add = $insc_ops->add_presence($nom, $description, $date_debut, $heure_debut, $date_limite, $actif, $groupe);
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
				$edit = $insc_ops->edit_presence($record_id,$nom, $description, $date_debut, $heure_debut,$date_limite, $actif,$groupe);
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

?>