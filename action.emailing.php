<?php
if(!isset($gCms)) exit;
if (!$this->CheckPermission('Presence use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
debug_display($params, 'Parameters');
if(isset($params['id_presence']) && $params['id_presence'] !='')
{
	$id_presence = $params['id_presence'];
	$insc_ops = new T2t_presence;
	$details = $insc_ops->details_presence($id_presence);
	$titre = $details['nom'];
	$description = $details['description'];
	$smarty->assign('titre', $titre);
	$error = 0;
	
	$group_id = $details['groupe'];
	$sender = $this->GetPreference('admin_email');	
	$priority = $params['priority'] = '1';
	$subject = $this->GetPreference('email_presence_subject');
//	$message = $this->GetTemplate('presencemail_Sample');
//	$body = $this->ProcessTemplateFromData($body);
	$aujourdhui = time();
	

	if(isset($params['senddate']) && $params['senddate'])
	{
		$senddate = $params['senddate'];
	}
	else
	{
		$senddate = date('Y-m-d');
	}
	if(isset($params['sendtime']) && $params['sendtime'])
	{
		$sendtime = $params['sendtime'];
	}
	else
	{
		$sendtime = date("H:i:s");
	}
	$mess_ops = new T2t_messages;
	$timbre = $mess_ops->datetotimeunix($senddate, $sendtime);

	$sent = 1;
	if($timbre > $aujourdhui)
	{
		$sent = 0;
	}
	$priority = 1;
	if($error >0)
	{
		//pas glop, des erreurs !
		echo "trop d\'erreurs !";
	}
	else
	{
		// on commence le traitement
		//if($aujourdhui <= $senddate = date('Y-m-d');

		$replyto = $sender;
		$gp_ops = new groups;
		$recipients_number = $gp_ops->count_users_in_group($group_id);
		$mess_ops = new T2t_messages;
		$pres_ops = new T2t_presence;
	//	$mess = $mess_ops->add_message($sender, $senddate, $sendtime, $replyto, $group_id,$recipients_number, $subject, $titre, $sent,$priority,$timbre);
	//	$message_id =$db->Insert_ID();
		
		
		
		if ($sent == 1)
		{
			//on extrait les utilisateurs (genid) du groupe sélectionné
			//attention, on élimine les utilisateurs ayant déjà répondu
			$licences = $pres_ops->relance_email_licence($id_presence);
			if(is_array($licences) && count($licences) > 0 )
			{
				$tab = implode(', ',$licences);	
			}
		//	$tab = implode(', ',$licences);
			$contacts_ops = new contact;
			$adherents = $contacts_ops->UsersFromGroup($group_id);
			$cg_ops = new CGExtensions;
	
			foreach($adherents as $sels)
			{
				//avant on envoie dans le module emails pour tous les utilisateurs et sans traitement
				if(FALSE === $licences || FALSE === in_array($sels, $licences))
				{
					$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ? AND type_contact = 1 LIMIT 1";
					$dbresult = $db->Execute($query, array($sels));
					if($dbresult && $dbresult->RecordCount()>0)
					{
						$row = $dbresult->FetchRow();

						$email_contact = $row['contact'];
						$destinataires = array();

						if(!is_null($email_contact))
						{
							$destinataires['emails'] = $email_contact;
							$destinataires['genid'] = $sels;
							$senttouser = 1;
							$status = "Email Ok";
							$ar = 0;
							$debut_url = $config['root_url'];

							$retourid = $this->GetPreference('pageid_presence');//44;
							$page = $cg_ops->resolve_alias_or_id($retourid);//'presence';
							$lienok = $this->create_url($id,'default',$page, array("id_presence"=>$id_presence, "reponse"=>"1","genid"=>$sels));
							$lienko = $this->create_url($id,'default',$page, array("id_presence"=>$id_presence, "reponse"=>"0","genid"=>$sels));
						//	$lien_recap = $this->create_url($id,'default',$page, array("id_presence"=>$id_presence, "recap"=>"1","genid"=>$sels));
							$montpl = $this->GetTemplateResource('orig_presencemailtemplate.tpl');						
							$smarty = cmsms()->GetSmarty();
							
							// do not assign data to the global smarty
							$tpl = $smarty->createTemplate($montpl);
							$tpl->assign('lienok',$lienok);
							$tpl->assign('lienko',$lienko);
						//	$tpl->assign('lien_recap',$lien_recap);
							$tpl->assign('titre',$titre);
							$tpl->assign('description',$description);
						 	$output = $tpl->fetch();
						
							$cmsmailer = new \cms_mailer();
							$cmsmailer->reset();
							$cmsmailer->SetSMTPDebug($flag = TRUE);
							$cmsmailer->AddAddress($email_contact);
							$cmsmailer->IsHTML(true);
							$cmsmailer->SetPriority($priority);
							$cmsmailer->SetBody($output);
							$cmsmailer->SetSubject($subject);
							$cmsmailer->Send();
					                if( !$cmsmailer->Send() ) 
							{			
					                    	return false;
								//$mess_ops->not_sent_emails($message_id, $recipients);
					                }

							
						}
						else
						{
							//on indique l'erreur : pas d'email disponible !
							$senttouser = 0;
							$status = "Email absent";
							$ar = 0;
							$email_contact = "rien";
						}

					//	$add_to_recipients = $mess_ops->add_messages_to_recipients($message_id, $sels, $email_contact,$senttouser,$status, $ar);
					}
					else
					{
						//une erreur sur l'email, on fait quoi ?
						//on indique l'erreur : pas d'email disponible !
						$senttouser = 0;
						$status = "Email absent";
						$ar = 0;
						$email_contact = "rien";
					//	$add_to_recipients = $mess_ops->add_messages_to_recipients($message_id, $sels, $email_contact,$senttouser,$status, $ar);
						
					}
				}
			}
				
				
			
		
		}
		$this->SetMessage('Résultats des envois dans le module Asso Messages');
		$this->RedirectToAdminTab('pres');
	}
	
}
else
{
	$this->SetMessage('Il manque un paramètre !');
	$this->RedirectToAdminTab('pres');
}

?>