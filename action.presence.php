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
	//modifie une présence
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
	
	case "delete" :
		if(isset($params['record_id']) && $params['record_id'] != '')
		{
			
		}
	break;
	
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