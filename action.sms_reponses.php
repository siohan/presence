<?php
$db =& $this->GetDb();
$error = 0;
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
	$error++;
}
if(isset($params['genid']) && $params['genid'] !='')
{
	$genid = $params['genid'];
	//on vérifie que le genid correspond bien au groupe 
	$gp_ops = new groups;
	$est_membre = $gp_ops->is_member($$groupe, $genid);
	if(false == $est_membre)
	{
		$error++;
	}
}
if($error < 1)
{
	$smarty->assign('genid', $genid);
	$smarty->assign();
	echo $this->ProcessTemplate('sms_reponses.tpl');
}
#
# EOF
#
?>