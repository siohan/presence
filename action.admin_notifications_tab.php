<?php
if( !isset($gCms) ) exit;

if (!$this->CheckPermission('Presence use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
//debug_display($params, 'Parameters');
//debug_display($_POST, 'Parameters');
if(!empty($_POST))
{
	if( isset($_POST['cancel']) ) {
            $this->RedirectToAdminTab();
        }
	if(isset($_POST['Date_Month']) && $_POST['Date_Month'] !='')
	{
		$Date_Month = $_POST['Date_Month'];
	}
	if(isset($_POST['Date_Day']) && $_POST['Date_Day'] !='')
	{
		$Date_Day = $_POST['Date_Day'];
	}
	if(isset($_POST['Date_Year']) && $_POST['Date_Year'] !='')
	{
		$Date_Year = $_POST['Date_Year'];
	}
	if(isset($_POST['Time_Hour']) && $_POST['Time_Hour'] !='')
	{
		$Time_Hour = $_POST['Time_Hour'];
	}
	if(isset($_POST['Time_Minute']) && $_POST['Time_Minute'] !='')
	{
		$Time_Minute = $_POST['Time_Minute'];
	}
	if(isset($_POST['Time_Second']) && $_POST['Time_Second'] !='')
	{
		$Time_Second = $_POST['Time_Second'];
	}
	else
	{
		$Time_Second = "00";
	}
	$LastSendNotification  = mktime($Time_Hour,$Time_Minute, $Time_Second,$Date_Month, $Date_Day,$Date_Year);
	$result = $_POST['result'];
	$unite = $_POST['unite'];
	if($unite == 'Heures')
	{
		$coeff = 3600;
	}
	if($unite == 'Minutes')
	{
		$coeff = 60;
	}
	else
	{
		$coeff = 3600*24;
	}
	$dupli = $coeff*$result;
	$this->SetPreference('LastSendNotification', $LastSendNotification);
	$this->SetPreference('interval', $dupli);
	
	//on redirige !
	$this->RedirectToAdminTab('notifications');
	
}
else
{
	
	//on recalcule la duplication pour le formulaire
	$interval = (int) $this->GetPreference('interval');
	$LastSendNotification = (int) $this->GetPreference('LastSendNotification');
	//on calcule la date prévisionnelle de la prochaine collecte
	$collecte = $LastSendNotification + $interval;
	
	$liste_unite = array('Minutes'=>'Minutes','Heures'=>'Heures', 'Jours'=>'Jours');
	//on cherche à déterminer l'unité de l'interval (jours, heures ou minutes)
	if(true == is_float($interval/86400))
	{
		//on met le résultat en heures
		if(true == is_float($interval/3600))
		{
			$result = $interval/60;
			$unite = 'Minutes';
		}
		else
		{
			$result = $interval/3600;
			$unite = 'Heures';
		}
		
	}
	else
	{
		//on met le résultat en jours
		$result = $interval/86400;
		$unite = 'Jours';
		
	}
	//on calcule la date prévisionnelle de la prochaine collecte
	$collecte = $LastSendNotification + $interval;
	$tpl = $smarty->CreateTemplate($this->GetTemplateResource('notifications.tpl'), null, null, $smarty);
	$tpl->assign('LastSendNotification', $LastSendNotification);
	$tpl->assign('liste_unite', $liste_unite);
	$tpl->assign('result', $result);
	$tpl->assign('unite', $unite);
	$tpl->assign('interval', $this->GetPreference('interval'));
	$tpl->assign('collecte', $collecte);
	$tpl->display();
}


#
# EOF
#
?>