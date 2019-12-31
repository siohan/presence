<?php
#CMS - CMS Made Simple



class T2t_presence
{
  function __construct() {}

function details_presence($id_presence)
{
	$db = cmsms()->GetDb();
	$query = "SELECT id,nom, description, date_debut, heure_debut, date_limite, actif, groupe, group_notif FROM ".cms_db_prefix()."module_presence_presence WHERE id = ?";
	$dbresult = $db->Execute($query, array($id_presence));
	$details = array();
	if($dbresult)
	{
		while($row = $dbresult->FetchRow())
		{
			$details['id_presence'] = $row['id'];
			$details['nom'] = $row['nom'];
			$details['description'] = $row['description'];
			$details['date_debut'] = $row['date_debut'];
			$details['heure_debut'] = $row['heure_debut'];
			$details['date_limite'] = $row['date_limite'];
			$details['actif'] = $row['actif'];
			$details['groupe'] = $row['groupe'];
			$details['group_notif'] = $row['group_notif'];
		}
	}
		return $details;
	

}
//ajoute une inscription
function add_presence($nom, $description, $date_debut,  $heure_debut, $date_limite, $actif, $groupe, $group_notif)
{
	$db = cmsms()->GetDb();
	$pres_ops = new T2t_presence;
	$query = "INSERT INTO ".cms_db_prefix()."module_presence_presence (nom, description, date_debut, heure_debut, date_limite, actif, groupe, group_notif) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
	$dbresult = $db->Execute($query, array($nom, $description, $date_debut, $heure_debut,$date_limite, $actif, $groupe, $group_notif));
	if($dbresult)
	{
		return true;
		
	}
	else
	{
		return false;
	}
}
##
function edit_presence($record_id,$nom, $description, $date_debut, $heure_debut, $date_limite, $actif, $groupe, $group_notif)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_presence_presence SET nom = ?, description = ?, date_debut = ?, heure_debut = ?, date_limite = ?,  actif = ?, groupe = ?, group_notif = ? WHERE id = ?";
	$dbresult = $db->Execute($query, array($nom, $description, $date_debut, $heure_debut,$date_limite, $actif, $groupe, $group_notif, $record_id));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//supprime une présence entièrement
function delete_presence($id_presence)
{
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_presence_presence WHERE id = ?";
	$dbresult = $db->Execute($query, array($id_presence));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//active ou désactive une présence
function activate_desactivate_inscription($id_presence,$action)
{
	$db = cmsms()->GetDb();
	$query = "UPDATE ".cms_db_prefix()."module_presence_presence SET actif = ? WHERE id = ?";
	$dbresult = $db->Execute($query, array($action, $id_presence));
}
//renvoie le nb de joueurs dans une option donnée
function count_users_in_presence($id_presence)
{
	global $gCms;
	$db = cmsms()->GetDb();
	$query = "SELECT count(*) AS nb FROM ".cms_db_prefix()."module_presence_belongs WHERE id_presence = ?";
	$dbresult = $db->Execute($query, array($id_presence));
	if($dbresult)
	{
		$row = $dbresult->FetchRow();
		$nb = $row['nb'];
	}
	else
	{
		$nb = 0;
	}
	return $nb;
}
//supprime tous les joueurs d'une inscription !
function delete_users_in_presence($id_presence)
{
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_presence_belongs WHERE id_presence = ?";
	$dbresult = $db->Execute($query, array($id_presence));
	
}
//détermine si un utilisateur a répondu ou non
function has_expressed($id_presence, $genid)
{
	$db = cmsms()->GetDb();
	$query = "SELECT genid, id_option FROM ".cms_db_prefix()."module_presence_belongs WHERE id_presence = ? AND genid = ?";
	$dbresult = $db->Execute($query, array($id_presence, $genid));
	if($dbresult)
	{
		if($dbresult->recordCount()>0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}
//récupère la réponse d'un adhérent
function user_choice($id_presence, $genid)
{
	$db = cmsms()->GetDb();
	$query = "SELECT id_option FROM ".cms_db_prefix()."module_presence_belongs WHERE id_presence = ? AND genid = ?";
	$dbresult = $db->Execute($query, array($id_presence, $genid));
	if($dbresult && $dbresult->recordCount()>0)
	{
		$row = $dbresult->fetchRow();
		$id_option = $row['id_option'];
		return $id_option;
	}
	else
	{
		return false;
	}
}
//supprime une réponse d'un adhérent
function delete_reponse($id_presence, $genid)
{
	$db = cmsms()->GetDb();
	$query = "DELETE FROM ".cms_db_prefix()."module_presence_belongs WHERE id_presence = ? AND genid = ?";
	$dbresult = $db->Execute($query, array($id_presence, $genid));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//ajoute une réponse d'un adhérent à une présence donnée
function add_reponse($id_presence, $genid, $reponse)
{
	$db = cmsms()->GetDb();
	$query = "INSERT INTO ".cms_db_prefix()."module_presence_belongs (id_presence, genid, id_option, timbre) VALUES (?, ?, ?, ?)";
	$dbresult = $db->Execute($query, array($id_presence, $genid, $reponse, time()));
	if($dbresult)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//envoie un email pour les présences /absences
function send_email($sender, $recipient,$subject, $priority, $lienok, $lienko)
{
		$pres = new presence;
	
		$body = $pres->GetTemplate('presencemail_Sample');
		$body = $pres->ProcessTemplateFromData($body);
		$cmsmailer = new \cms_mailer();
		$cmsmailer->reset();
	//	$cmsmailer->SetFrom($sender);//$this->GetPreference('admin_email'));
		$cmsmailer->AddAddress($recipient,$name='');
		$cmsmailer->IsHTML(true);
		$cmsmailer->SetPriority($priority);
		
		$cmsmailer->SetBody($body);
		$cmsmailer->SetSubject($subject);
		$cmsmailer->Send();
                if( !$cmsmailer->Send() ) 
		{			
                    	return false;
                }
}
//envoie un email normal
function send_normal_email($sender, $recipient,$subject, $priority, $message)
{
		$pres = new presence;
	
		$body = $pres->GetTemplate('presencemail_Sample');
		$body = $pres->ProcessTemplateFromData($body);
		$cmsmailer = new \cms_mailer();
		$cmsmailer->reset();
	//	$cmsmailer->SetFrom($sender);//$this->GetPreference('admin_email'));
		$cmsmailer->AddAddress($recipient,$name='');
		$cmsmailer->IsHTML(true);
		$cmsmailer->SetPriority($priority);
		
		$cmsmailer->SetBody($message);
		$cmsmailer->SetSubject($subject);
		$cmsmailer->Send();
                if( !$cmsmailer->Send() ) 
		{			
                    	return false;
                }
}

//collecte les genid des personnes ayant déjà répondues à une présence donnée
function relance_email_licence($id_presence)
{
	$db = cmsms()->GetDb();
	$query = "SELECT genid FROM ".cms_db_prefix()."module_presence_belongs WHERE id_presence = ?";
	$dbresult = $db->Execute($query, array($id_presence));
	$liste_licences = array();
	if($dbresult && $dbresult->RecordCount()>0)
	{
		while($row = $dbresult->FetchRow())
		{
			$liste_licences[] = $row['genid'];
		}
		return $liste_licences;
	}
	else
	{
		return FALSE;
	}
}
##
#END OF CLASS
}
