<?php
class RecupPresenceTask implements CmsRegularTask
{

   public function get_name()
   {
      return get_class();
   }

   public function get_description()
   {
      return 'Récuperation des présences.';
   }

   
	public function test($time = '')
   {

      // Instantiation du module
      $pres = \cms_utils::get_module('Presence');

      // Récupération de la dernière date d'exécution de la tâche
      if (!$time)
      {
         $time = time();
      }

      $last_execute = (int) $pres->GetPreference('LastSendNotification');
      $interval = (int) $pres->GetPreference('interval');
     	

      // Définition de la périodicité de la tâche 
      	if( $time - $last_execute >= $interval )
	{
		return TRUE; 
	}
	else
	{
		 return FALSE;
	}
     
     
      
      
   }


   public function execute($time = '')
   {

      $db = \CmsApp::get_instance()->GetDb();
      if (!$time)
      {
         $time = time();
      }

      $insc = \cms_utils::get_module('Presence');
     //var_dump($insc);
	// Ce qu'il y a à exécuter ici

	$last_updated = $insc->GetPreference('LastSendNotification');
	//$admin_email = $insc->GetPreference('admin_email');
	$aujourdhui = date('Y-m-d');

	$query = "SELECT id, group_notif FROM ".cms_db_prefix()."module_presence_presence WHERE actif = 1 AND date_limite > ?";
//	$query = "SELECT be.id_inscription, be.id_option, be.genid, be.timbre FROM ".cms_db_prefix()."module_inscriptions_belongs AS be, ".cms_db_prefix()."module_inscriptions_inscriptions AS ins WHERE ins.id_inscription = be.id_inscription AND be.timbre > ? ORDER BY be.id_inscription ASC, be.id_option ASC";
	$dbresult = $db->Execute($query, array($aujourdhui));
	if($dbresult)
	{
		if($dbresult->RecordCount()>0)
		{

			while($row = $dbresult->FetchRow())
			{
				$id_presence = $row['id'];
				$group = $row['group_notif'];
				$query2 = "SELECT id_presence, id_option, genid, timbre FROM ".cms_db_prefix()."module_presence_belongs WHERE timbre > ? AND id_presence = ?";
				$dbresult2 = $db->Execute($query2, array($last_updated, $id_presence));
				if($dbresult2 && $dbresult2->RecordCount()>0)
				{
					$destinataires = array();
					if($group != 0)
					{
						//on récupére les genid du group
						$gp_ops = new groups;
						$genids = $gp_ops->liste_licences_from_group($group);
						if(false !== $genids)
						{
							//maintenant on récupère les adresses emails
							foreach($genids as $sels)
							{
								//avant on envoie dans le module emails pour tous les utilisateurs et sans traitement

								$query3 = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ? AND type_contact = 1 LIMIT 1";
								$dbresult3 = $db->Execute($query3, array($sels));
								$row3 = $dbresult3->FetchRow();

								$email_contact = $row3['contact'];

								if(!is_null($email_contact))
								{
									$destinataires[] = $email_contact;
								}

							}
						}
					}
					$cg_ops = new CGExtensions;
					//on créé une url pour voir le résultat des inscriptions
					$retourid = $insc->GetPreference('pageid_presence');
					$page = $cg_ops->resolve_alias_or_id($retourid);
					$lien_recap = $insc->create_url($id,'default',$page, array("id_presence"=>$id_presence, "genid"=>$sels,"recap"=>"1"));

					$tt_ops = new T2t_presence;
					$adh_ops = new Asso_adherents;

					$rowarray= array();
					while ($row2= $dbresult2->FetchRow())
					{
						$onerow= new StdClass();
						$presence = $tt_ops->details_presence($row2['id_presence']);
						$onerow->nom = $presence['nom'];
						//$option = $tt_ops->$row['id_option'];
						$onerow->reponse = $row2['id_option'];//$option['nom'];
						$details_adh = $adh_ops->details_adherent_by_genid($row2['genid']);
						$onerow->nom_genid = $details_adh['nom'].' '.$details_adh['prenom'];
						$onerow->timbre = date('d-m-Y H:i:s',$row2['timbre']);
						$rowarray[]= $onerow;
					}
					$subject = "Présences ajoutées ou modifiées";
					$montpl = $insc->GetTemplateResource('orig_recap_reponses.tpl');						
					$smarty = cmsms()->GetSmarty();
					// do not assign data to the global smarty
					$tpl = $smarty->createTemplate($montpl);
					$tpl->assign('items',$rowarray);
					$tpl->assign('itemcount',count($rowarray));
					$tpl->assign('lien_recap',$lien_recap);
					$output = $tpl->fetch();

					//et on envoie
					$cmsmailer = new \cms_mailer();
					$cmsmailer->reset();
					foreach($destinataires as $value)
					{

						
						$cmsmailer->SetFrom('webmaster@agi-webconseil.fr');
						$cmsmailer->AddAddress($value,$name='');
						$cmsmailer->IsHTML(true);
						$cmsmailer->SetPriority('1');
						$cmsmailer->SetBody($output);
						$cmsmailer->SetSubject($subject);
						$cmsmailer->Send();
				                if( !$cmsmailer->Send() ) 
						{			
				                    	//$mess_ops->not_sent_emails($message_id, $recipients);
							$this->Audit('',$this->GetName(),'Problem sending email to '.$item);

				                }
						unset($value);
					}
					unset($destinataires);



				}
			}//maintenant on va chercher s'il y a des nouvelles réponses

			return true;





		}
		else
		{
			return false;//echo 'Pas de results';
		}

	}  
	else
	{
		return false;//echo $db->ErrorMsg();//return FALSE;
	}




   }

   public function on_success($time = '')
   {

      if (!$time)
      {
         $time = time();
      }
      
      $pres = cms_utils::get_module('Presence');
      $pres->SetPreference('LastSendNotification', $time);
      $pres->Audit('','Presence','Nouvelles présences envoyées');
      //$pong = cms_utils::get_module
      
   }

   public function on_failure($time = '')
   {
      $pres = \cms_utils::get_module('Presence');
$pres->Audit('','Presence','Pas de nouvelles présences');
   }

}
?>