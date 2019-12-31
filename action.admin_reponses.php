<?php

if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Presence use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db =& $this->GetDb();
global $themeObject;


if(isset($params['record_id']) && $params['record_id'] !='')
{
	$record_id = $params['record_id'];
	//details de la présence
	
	$pres_ops = new T2t_presence;
	$details_pres = $pres_ops->details_presence($record_id);
	$groupe = $details_pres['groupe'];
	$titre = $details_pres['nom'];
	$smarty->assign('titre', $titre);
}
else
{
	//redir
}
$smarty->assign('Revenir', $this->CreateLink($id, 'defaultadmin', $returnid, $contents='<= Revenir'));	
$dbresult= array();
$query= "SELECT genid FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";

$dbresult= $db->Execute($query, array($groupe));
$rowclass= 'row1';
$rowarray= array();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
	$insc_ops = new T2t_inscriptions;
	$assoadh = new Asso_adherents;
    	while ($row= $dbresult->FetchRow())
      	{
	
		//$id_envoi = (int) $row['id_envoi'];
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$genid = $row['genid'];
		$onerow->adherent = $assoadh->get_name($genid);
		$has_expressed = $pres_ops->has_expressed($record_id,$genid);
		if(FALSE === $has_expressed)
		{
			$onerow->present= $this->CreateLink($id, 'presence', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"reponse","genid"=>$row['genid'], "id_presence"=>$record_id, "reponse"=>"1"));
			$onerow->absent= $this->CreateLink($id, 'presence', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"reponse","genid"=>$row['genid'], "id_presence"=>$record_id, "reponse"=>"0"));
			$onerow->attente= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
		}
		else
		{
			$user_choice = $pres_ops->user_choice($record_id, $genid);
			if ($user_choice == 1)
			{
				$onerow->present= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
				$onerow->absent= $this->CreateLink($id, 'presence', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"reponse","genid"=>$row['genid'], "id_presence"=>$record_id, "reponse"=>"0"));
				$onerow->attente= '';
			} 
			else
			{
				$onerow->present= $this->CreateLink($id, 'presence', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"reponse","genid"=>$row['genid'], "id_presence"=>$record_id, "reponse"=>"1"));
				$onerow->absent= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
				$onerow->attente= '';
			}
			$onerow->delete = $this->CreateLink($id, 'presence', $returnid, $themeObject->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array("obj"=>"delete_reponse","genid"=>$row['genid'], "id_presence"=>$record_id, "reponse"=>"1"));
		}
		
		
		$rowarray[]= $onerow;
      }
  }

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

echo $this->ProcessTemplate('reponses.tpl');


#
# EOF
#
?>