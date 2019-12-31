<?php
if(!isset($gCms)) exit;
$db = cmsms()->GetDb();
//debug_display($params, 'Parameters');
$error = 0; //on instancie un compteur d'erreur
$pres_ops = new T2t_presence;
if(isset($params['id_presence']) && $params['id_presence'] !='')
{
	$id_presence = $params['id_presence'];
	
	$details = $pres_ops->details_presence($id_presence);	
	$date_limite = $details['date_limite'];
	$actif = $details['actif'];
	$groupe = $details['groupe'];
	$group_notif = $details['group_notif'];
	$nom = $details['nom'];
	$description = $details['description'];
	
	if($actif == 0 || $date_limite < date('Y-m-d'))
	{
		echo '<h1>Le sondage est fermé ou la date limite de réponse dépassée !</h1>';
	}
}
else
{
	//echo 'id_presence';
	$error++;
}
if(isset($params['genid']) && $params['genid'] !='')
{
	$genid = $params['genid'];
	$gp_ops = new groups;
	$member = $gp_ops->is_member($genid, $group_notif);
	/*
	if(false == $member)
	{
		$error++;
		echo "Vous n'êtes pas autorisé à accéder à ce contenu";
	}
	*/
}
else
{
	//echo 'Genid !';
	$error++;
}
if(isset($params['recap']))
{
	//on détermine si la personne est abilité à voir cette page
	$gp_ops = new groups;
	$member = $gp_ops->is_member($genid, $group_notif);
	if(true == $member)
	{
		$this->Redirect($id, 'recap', $returnid, array("id_presence"=>$id_presence, "genid"=>$genid));
	}
	else
	{
		echo "Vous n'avez pas les droits pour accéder à cette page !";
	}
	
}
$reponse = '';
if(isset($params['reponse']))
{
	$reponse = $params['reponse'];
}
if(isset($params['sms']))
{
	$sms = $params['sms'];
	
	$this->Redirect($id, 'assign_single_user', $returnid, array("id_presence"=>$id_presence, "genid"=>$genid));
	//echo $this->ProcessTemplate('assign_single_user.tpl');
}


//echo "le nb erreurs est : ".$error;
if($error < 1 && $reponse !='')
{
	//on détruit un éventuel précédent enregistrement ?
	$del_rep = $pres_ops->delete_reponse($id_presence, $genid);
	if(true == $del_rep)
	{
		$pres_ops->add_reponse($id_presence, $genid, $reponse);
		echo "<h1>Merci d'avoir répondu !!</h1>";
	}
	//on affiche le nom de ceux qui n'ont pas encore répondu !!
	

}
else
{ 
	//on redirige car le membre n'a pas répondu
	
}
?>
