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
	
$dbresult= array();
//SELECT * FROM ping_module_ping_recup_parties AS rec right JOIN ping_module_ping_joueurs AS j ON j.licence = rec.licence  ORDER BY j.id ASC
$query= "SELECT licence FROM ".cms_db_prefix()."module_adherents_groupes_belongs WHERE id_group = ?";//" ORDER BY date_debut DESC";

$dbresult= $db->Execute($query, array($groupe));
$rowclass= 'row1';
$rowarray= array();
if ($dbresult && $dbresult->RecordCount() > 0)
  {
	$insc_ops = new T2t_inscriptions;
    	while ($row= $dbresult->FetchRow())
      	{
	
		//$id_envoi = (int) $row['id_envoi'];
		$onerow= new StdClass();
		$onerow->rowclass= $rowclass;
		$licence = $row['licence'];
		$onerow->licence = $row['licence'];
		$has_expressed = $pres_ops->has_expressed($record_id,$licence);
		if(FALSE === $has_expressed)
		{
			$onerow->id_option= '';
			$onerow->relance = $this->CreateLink($id, 'relance', $returnid, 'Relancer', array("licence"=>$row['licence'], "id_presence"=>$record_id));
		}
		elseif($has_expressed == '1')
		{
			$onerow->id_option= $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon');
			$onerow->relance = $themeObject->DisplayImage('icons/extra/false.gif', $this->Lang('false'), '', '', 'systemicon');
		}
		elseif($has_expressed == '0')
		{
			$onerow->id_option= $themeObject->DisplayImage('icons/extra/false.gif', $this->Lang('false'), '', '', 'systemicon');
			$onerow->relance = $themeObject->DisplayImage('icons/extra/false.gif', $this->Lang('false'), '', '', 'systemicon');
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