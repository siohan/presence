<?php

if( !isset($gCms) ) exit;

$db =& $this->GetDb();
global $themeObject;

$error = 0;
if(isset($params['id_presence']) && $params['id_presence'] !='')
{
	$id_presence = $params['id_presence'];
	//details de la présence
	
	$pres_ops = new T2t_presence;
	$details_pres = $pres_ops->details_presence($id_presence);
	$group_notif = $details_pres['group_notif'];
	$titre = $details_pres['nom'];
	$smarty->assign('titre', $titre);
}
else
{
	//redir
	$error++;
}
if(isset($params['genid']) && $params['genid'] !='')
{
	//on va vérifier que le genid appartient bien au groupe de notif
	/*
	$gp_ops = new groups;
	$is_membre = $gp_ops->is_member($params['genid'],$group_notif);
	if(false == $is_membre)
	{
		$error++;
	}
	*/
}
else
{
	$error++;
}
if($error < 1)
{
	$dbresult= array();
	$query= "SELECT genid, timbre, id_option FROM ".cms_db_prefix()."module_presence_belongs WHERE id_presence = ?";

	$dbresult= $db->Execute($query, array($id_presence));
	$rowclass= 'row1';
	$rowarray= array();
	if ($dbresult && $dbresult->RecordCount() > 0)
	  {
		//$insc_ops = new T2t_inscriptions;
		$assoadh = new Asso_adherents;
	    	while ($row= $dbresult->FetchRow())
	      	{

			//$id_envoi = (int) $row['id_envoi'];
			$onerow= new StdClass();
			$onerow->rowclass= $rowclass;
			$genid = $row['genid'];
			$onerow->adherent = $assoadh->get_name($genid);
			
			
				$user_choice = $pres_ops->user_choice($id_presence, $genid);
				if ($user_choice == 1)
				{
					$onerow->reponse= 'Présent';					
				} 
				else
				{
					$onerow->reponse= 'Absent';
				}
			$rowarray[]= $onerow;
	      	}
	  }

	$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
	$smarty->assign('itemcount', count($rowarray));
	$smarty->assign('items', $rowarray);

	echo $this->ProcessTemplate('recap.tpl');
}
else
{
	echo "Une ou plusieurs erreurs sont apparues";
}



#
# EOF
#
?>