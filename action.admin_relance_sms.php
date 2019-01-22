<?php
if(!isset($gCms)) exit;
if (!$this->CheckPermission('Presence use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
if(isset($params['id_presence']) && $params['id_presence'] !='')
{
	$id_presence = $params['id_presence'];
	
	//les paramètres bitly
	$client_id = $this->GetPreference('bitly_client_id');//'e31dbde6e9564e3d863b1158a554c69288af511e';
	$client_secret = $this->GetPreference('bitly_client_secret');//'1d116534042003a97b1f79f9210e51b83ff88922';
	$user_access_token = $this->GetPreference('bitly_access_token');//'fde1c684f32722c3abab9e82fdabf9b36e5803ac';
	
	//Les paramètres SMS
	$sender = $this->GetPreference('sms_sender');
	$message = $this->GetTemplate('sms_relance');
	$message_reference = $this->random_string(15);
	$subtype = 'PREMIUM';
	$senddate = date('Y-m-d');
	$sendtime = date('H:i:s');
	$richsms_option = 0;
	$richsms_url = '';

	$insc_ops = new T2t_presence;
	$cg_ops = new CGExtensions;
	$details = $insc_ops->details_presence($id_presence);
	$titre = $details['nom'];
	$description = $details['description'];
	$smarty->assign('titre', $titre);
	$smarty->assign('description', $description);
	$error = 0;
	
	$group_id = $details['groupe'];
	$aujourdhui = time();
	
	//on construit les liens à déployer
	
	$debut_url = 'http://ping.agi-webconseil.fr';//$config['root_url'];
	
	$retourid = $this->GetPreference('pageid_presence');//44;
//	var_dump($retourid);
	$page = $cg_ops->resolve_alias_or_id($retourid);//'presence';
	$action_module = 'cntnt01';
	
	


		$gp_ops = new groups;
		$recipients_number = $gp_ops->count_users_in_group($group_id);
		$mess_ops = new T2t_messages;
		$pres_ops = new T2t_presence;
		$sms_ops = new sms_ops;
	//	$mess = $mess_ops->add_message($sender, $senddate, $sendtime, $replyto, $group_id,$recipients_number, $subject, $titre, $sent);
	//	$message_id =$db->Insert_ID();
		
		
		
	
			//on extrait les utilisateurs (genid) du groupe sélectionné
			//attention, on élimine les utilisateurs ayant déjà répondu
			$licences = $pres_ops->relance_email_licence($id_presence);
			//var_dump($licences);
			if(is_array($licences) && count($licences) > 0 )
			{
				$tab = implode(', ',$licences);	
			}
			$contacts_ops = new contact;
			$adherents = $contacts_ops->UsersFromGroup($group_id);
			$cg_ops = new CGExtensions;
			require_once('bitly.php');
			foreach($adherents as $sels)
			{
				//avant on envoie dans le module emails pour tous les utilisateurs et sans traitement
				if(FALSE === $licences || FALSE === in_array($sels, $licences))
				{
					$query = "SELECT contact FROM ".cms_db_prefix()."module_adherents_contacts WHERE genid = ? AND type_contact = 2 LIMIT 1";
					$dbresult = $db->Execute($query, array($sels));
					if($dbresult && $dbresult->RecordCount()>0)
					{
						$row = $dbresult->FetchRow();

						$sms_contact = $row['contact'];
						$destinataires = array();
					
						
						if(!is_null($sms_contact))
						{
							
						
							$lienok = $debut_url.'/index.php?page='.$retourid.'%26mact=Presence,'.$action_module.',default,0%26'.$action_module.'id_presence='.$id_presence.'%26'.$action_module.'genid='.$sels.'%26'.$action_module.'reponse=1';
							$lienko = $debut_url.'/index.php?page='.$retourid.'%26mact=Presence,'.$action_module.',default,0%26'.$action_module.'id_presence='.$id_presence.'%26'.$action_module.'genid='.$sels.'%26'.$action_module.'reponse=0';//$this->CreateLink($id, 'default', $returnid, 'Absent', array("id_presence"=>$id_presence,"reponse"=>"0", "licence"=>$sels));
						
							$params1 = array();
							$params1['access_token'] = $user_access_token;
							$params1['longUrl'] = $lienok;
							$resultsok = bitly_get('shorten', $params1, $complex=true);
							$oklien = $resultsok['data']['url'];
							$smarty->assign('oklien', $oklien);
							$params2 = array();
							$params2['access_token'] = $user_access_token;
							$params2['longUrl'] = $lienko;
							$resultsko = bitly_get('shorten', $params2, $complex=true);
							$kolien = $resultsko['data']['url'];
							$smarty->assign('kolien', $kolien);
							$content = $this->ProcessTemplateFromData($message);
							$sent = 0;
							$add_message = $sms_ops->add_message($message_reference,$subtype, $senddate, $sendtime,$sender, $content, $richsms_option,$richsms_url);
							if(true === $add_message)
							{
								$message_id = $db->Insert_ID();
								$add_to_recipients = $sms_ops->add_recipients($message_id, $id_envoi='0', $sels,$sent,$sms_contact);
							}
							
							//on construit le sms
							//on appelle la biblio smsenvoi
							$smsenv = new smsenvoi;
							
							if($smsenv->sendSMS($sms_contact,$content,'PREMIUM',$sender))
							{
									//ENVOI REUSSI
									$success=true;

									//Id de l'envoi effectué
									//Idéalement, cet id devrait être stocké en base de données
									$id_envoi=$smsenv->id;
									//on met la bdd à jour
									$maj_message = $sms_ops->maj_envoi($message_reference,$id_envoi);
									$maj_recipients = $sms_ops->maj_recipients($message_id, $id_envoi);									

							}
						
						
						}
						unset($oklien);
						unset($kolien);
						
					
					}
				}
			}
				
				
			
		
		
		$this->SetMessage('Message(s) envoyé(s) ! (Voir Asso SMS)');
		$this->RedirectToAdminTab('pres');
	
	
}
else
{
	$this->SetMessage('Il manque un paramètre !');
	$this->RedirectToAdminTab('pres');
}

?>