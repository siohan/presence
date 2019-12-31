<?php
if( !isset($gCms) ) exit;
//debug_display($params, 'Parameters');
$pres_ops = new T2t_presence;
if( !empty($_POST) ) {
        if( isset($_POST['cancel']) ) {
            $this->RedirectToAdminTab();
        }
	$genid = $_POST['genid'];
	$id_presence = $_POST['id_presence'];
	$reponse = $_POST['id_option'];
	//on va supprimer le choix de l'adhérent s'il y en a un et on insère ensuite
	$pres_ops->delete_reponse($id_presence, $genid);
	$envoi = $pres_ops->add_reponse($id_presence, $genid, $reponse);
	if(true == $envoi)
	{
		echo "Ton choix est validé !";
	}
}
else
{
	
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
		$member = $gp_ops->is_member($genid, $groupe);
		if(false == $member)
		{
			$error++;
			echo "Vous n'êtes pas autorisé à accéder à ce contenu";
		}

	}
	else
	{
		//echo 'Genid !';
		$error++;
	}	
	if($error < 1)
	{
		$smarty->assign("id_presence", $id_presence);
		$smarty->assign("genid", $genid);
		$smarty->assign("nom", $nom);
		$smarty->assign("description", $description);
		echo $this->ProcessTemplate('assign_single_user.tpl');
	}
	
}




#
#EOF
#
?>