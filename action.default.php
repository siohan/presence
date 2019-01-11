<?php
if(!isset($gCms)) exit;
$db = cmsms()->GetDb();

$error = 0; //on instancie un compteur d'erreur
if(isset($params['id_presence']) && $params['id_presence'] !='')
{
	$id_presence = $params['id_presence'];
	$pres_ops = new T2t_presence;
	$details = $pres_ops->details_presence($id_presence);	
	$date_limite = $details['date_limite'];
	$actif = $details['actif'];
	
	if($actif == 0 || $date_limite < date('Y-m-d'))
	{
		echo 'Le sondage est fermé ou la date limite de réponse dépassée !';
	//	$this->Redirect();
	}
}
else
{
	$error++;
}
if(isset($params['genid']) && $params['genid'] !='')
{
	$genid = $params['genid'];
}
else
{
	$error++;
}
if(isset($params['reponse']) && $params['reponse'] !='')
{
	$reponse = $params['reponse'];
	/*
	if($reponse == 0)
	{
		//on créé une alerte pour le responsable ?
		//on récupère le nom du joueur
		$sender = '';
		$adh_ops = new adherents_spid;
		$joueur = $adh_ops->get_name($licence);
		$message = 'Attention, '.$joueur.' est absent pour : '.$details['nom'];
		$send_message = $pres_ops->send_normal_email();
		
	}
	*/
}
if($error < 1)
{
	//on détruit un éventuel précédent enregistrement ?
	$query = "DELETE FROM ".cms_db_prefix()."module_presence_belongs WHERE id_presence = ? AND genid = ?";
	$dbresult = $db->Execute($query, array($id_presence, $genid));
	$query = "INSERT INTO  ".cms_db_prefix()."module_presence_belongs(id_presence, id_option, genid) VALUES( ?, ?, ?)";
	$dbresult = $db->Execute($query,array($id_presence, $reponse, $genid));
	//on affiche le nom de ceux qui n'ont pas encore répondu !!
	
	if($dbresult)
	{

	echo "Merci d'avoir répondu !!";

	}
}

?>
