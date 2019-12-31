<?php
set_time_limit(300);
if(!isset($gCms)) exit;
//on vérifie les permissions
if(!$this->CheckPermission('Presence use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db =& $this->GetDb();
global $themeObject;
$aujourdhui = date('Y-m-d');
$pres_ops = new T2t_presence;
if(isset($params['obj']) && $params['obj'] != '')
{
	$obj = $params['obj'];
}
else
{
	//redir
}
switch($obj)
{
	//Active ou désactive une présence
	case "activate_desactivate" :
		$db = cmsms()->GetDb();
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			$record_id = $params['record_id'];
		}
		if(isset($params['act']) && $params['act'] != '')
		{
			$act = $params['act'];
			
		}
		$query = "UPDATE ".cms_db_prefix()."module_presence_presence SET actif = ? WHERE id = ?";
		$dbresult = $db->Execute($query, array($act, $record_id));
		
		$this->RedirectToAdminTab('pres');
	break;
	//supprime la réponse d'un adhérent
	case "delete_reponse" :
		if(isset($params['id_presence']) && $params['id_presence'] != '')
		{
			$id_presence = $params['id_presence'];
		}
		if(isset($params['genid']) && $params['genid'] != '')
		{
			$genid = $params['genid'];
		}
			$del_rep = $pres_ops->delete_reponse($id_presence, $genid);
		
		$this->Redirect($id, 'admin_reponses', $returnid, array("record_id"=>$id_presence));
	break;
	
	//supprime la réponse d'un adhérent
	case "delete_presence" :
		if(isset($params['id_presence']) && $params['id_presence'] != '')
		{
			$id_presence = $params['id_presence'];
		}
		if(isset($params['genid']) && $params['genid'] != '')
		{
			$genid = $params['genid'];
		}
			$del_pres = $pres_ops->delete_presence($id_presence);
			if(true === $del_pres)
			{
				$del_rep = $pres_ops->delete_users_in_presence($id_presence);
			}
			
		
		$this->Redirect($id, 'defaultadmin', $returnid);
	break;
	//ajoute ou modifie une réponse
	case "reponse" :
	
		if(isset($params['id_presence']) && $params['id_presence'] != '')
		{
			$id_presence = $params['id_presence'];
		}
		if(isset($params['genid']) && $params['genid'] != '')
		{
			$genid = $params['genid'];			
		}
		if(isset($params['reponse']) && $params['reponse'] != '')
		{
			$reponse = $params['reponse'];			
		}
		$del_rep = $pres_ops->delete_reponse($id_presence, $genid);
		if(true === $del_rep)
		{
			$add_rep = $pres_ops->add_reponse($id_presence, $genid, $reponse);
		}
		$this->Redirect($id, 'admin_reponses', $returnid, array("record_id"=>$id_presence));
		
	
	break;
}