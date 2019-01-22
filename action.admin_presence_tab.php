<?php

if( !isset($gCms) ) exit;
if (!$this->CheckPermission('Presence use'))
{
	echo $this->ShowErrors($this->Lang('needpermission'));
	return;
}
$db =& $this->GetDb();
global $themeObject;
$img_sms = '<img src="../modules/Presence/images/sms2.png"/>';
$img_email = '<img src="../modules/Presence/images/email-16.png"/>';
$smarty->assign('add_edit', 
		$this->CreateLink($id, 'add_edit_presence', $returnid,$themeObject->DisplayImage('icons/system/add.gif', 'Ajouter', '', '', 'systemicon')));

		
$dbresult= array ();
$query= "SELECT id,nom, description, date_debut, heure_debut,  date_limite, actif, groupe FROM ".cms_db_prefix()."module_presence_presence ORDER BY date_debut DESC";

$dbresult= $db->Execute($query);
$rowclass= 'row1';
$rowarray= array ();
$cont_ops = new contact;
if ($dbresult && $dbresult->RecordCount() > 0)
  {
	$insc_ops = new T2t_presence;
    while ($row= $dbresult->FetchRow())
      {
	
	$onerow= new StdClass();
	$onerow->rowclass= $rowclass;
	$actif = $row['actif'];
	$date_limite = $row['date_limite'];
	$nb_total = $cont_ops->CountUsersFromGroup($row['groupe']);
	$inscrits = $insc_ops->count_users_in_presence($row['id']);
	if($actif == 0)
	{
		$onerow->actif= $this->CreateLink($id, 'presence', $returnid, $themeObject->DisplayImage('icons/system/false.gif', $this->Lang('false'), '', '', 'systemicon'), array("obj"=>"activate_desactivate", "record_id"=>$row['id'], "act"=>"1"));
	}
	elseif($date_limite < date('Y-m-d') || $inscrits == $nb_total)
	{
		$onerow->actif= $this->CreateLink($id, 'presence', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("obj"=>"activate_desactivate", "record_id"=>$row['id'], "act"=>"0"));
	}
	else
	{
		$onerow->actif= $this->CreateLink($id, 'presence', $returnid, $themeObject->DisplayImage('icons/system/true.gif', $this->Lang('true'), '', '', 'systemicon'), array("obj"=>"activate_desactivate", "record_id"=>$row['id'], "act"=>"0"));
		$onerow->emailing = $this->Createlink($id, 'emailing', $returnid, $img_email, array("id_presence"=>$row['id']));
		$onerow->sms = $this->Createlink($id, 'admin_relance_sms', $returnid, $img_sms, array("id_presence"=>$row['id']));
	}
	
	
	$onerow->id= $row['id'];
	$onerow->nom= $row['nom'];
	$onerow->description= $row['description'];
	$onerow->date_debut= $row['date_debut'];
	$onerow->heure_debut= $row['heure_debut'];
	$onerow->date_limite= $row['date_limite'];
	$onerow->inscrits = $insc_ops->count_users_in_presence($row['id']);
	$onerow->taux = $nb_total;
	$onerow->view= $this->CreateLink($id, 'admin_reponses', $returnid, $themeObject->DisplayImage('icons/system/view.gif', $this->Lang('view'), '', '', 'systemicon'),array('record_id'=>$row['id']));
	$onerow->print = $this->CreateLink($id, 'admin_print', $returnid,$themeObject->DisplayImage('icons/system/document-list.png', $this->Lang('print'), '', '', 'systemicon'), array("id_inscription"=>$row['id']));
	$onerow->editlink= $this->CreateLink($id, 'add_edit_presence', $returnid, $themeObject->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'),array('record_id'=>$row['id']));
	($rowclass == "row1" ? $rowclass= "row2" : $rowclass= "row1");
	$rowarray[]= $onerow;
      }
  }

$smarty->assign('itemsfound', $this->Lang('resultsfoundtext'));
$smarty->assign('itemcount', count($rowarray));
$smarty->assign('items', $rowarray);

echo $this->ProcessTemplate('presence.tpl');


#
# EOF
#
?>