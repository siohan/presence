<?php
#-------------------------------------------------------------------------
# Module: Presence
# Version: 0.2, Claude SIOHAN
# Method: Install
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------

/**
 * For separated methods, you'll always want to start with the following
 * line which check to make sure that method was called from the module
 * API, and that everything's safe to continue:
 */ 
if (!isset($gCms)) exit;


/** 
 * After this, the code is identical to the code that would otherwise be
 * wrapped in the Install() method in the module body.
 */

$db = $gCms->GetDb();

// mysql-specific, but ignored by other database
$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	nom C(255),
	description C(255),
	reponse1 C(150),
	reponse2 C(150),
	date_debut D,
	date_limite D,
	heure_debut T,
	actif I(1) DEFAULT 0,
	groupe I(2) DEFAULT 0,
	group_notif I(3) DEFAULT 0";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_presence_presence", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//

$dict = NewDataDictionary( $db );

// table schema description
$flds = "
	id I(11) AUTO KEY,
	timbre I(11),
	id_presence I(11),
	id_option I(1),
	genid I(11),
	timbre I(11)";
	$sqlarray = $dict->CreateTableSQL( cms_db_prefix()."module_presence_belongs", $flds, $taboptarray);
	$dict->ExecuteSQLArray($sqlarray);			
//
	$sqlarray = $dict->CreateIndexSQL('unicite', cms_db_prefix().'module_presence_belongs', 'id_presence, genid');//, array('UNIQUE'));
	$dict->ExecuteSQLArray($sqlarray);
//Permissions
$this->CreatePermission('Presence use', 'Utiliser le module Présence');
$this->CreatePermission('Presence Set Prefs', 'Modifier les données du compte');


//mails templates
# Mails templates

$fn = cms_join_path(dirname(__FILE__),'templates','orig_presencemailtemplate.tpl');
if( file_exists( $fn ) )
{
	$template = file_get_contents( $fn );
	$this->SetTemplate('presencemail_Sample',$template);
}
$fn = cms_join_path(dirname(__FILE__),'templates','orig_relanceemailtemplate.tpl');
if( file_exists( $fn ) )
{
	$template = file_get_contents( $fn );
	$this->SetTemplate('relanceemail_Sample',$template);
}
$fn = cms_join_path(dirname(__FILE__),'templates','orig_smstemplate.tpl');
if( file_exists( $fn ) )
{
	$template = file_get_contents( $fn );
	$this->SetTemplate('sms_template',$template);
}


# Les préférences 
$this->SetPreference('admin_email', 'root@localhost.com');
$this->SetPreference('email_presence_subject','Présence/Absence');
$this->SetPreference('email_relance_subject', 'Relance Présence/Absence !');
$this->SetPreference('pageid_presence', '');
$this->SetPreference('bitly_client_id', '');
$this->SetPreference('bitly_client_secret', '');
$this->SetPreference('bitly_access_token', '');
$this->SetPreference('bitly_redirect_uri', '');
$this->SetPreference('LastSendNotification', time());
$this->SetPreference('interval', '300');
// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('installed', $this->GetVersion()) );

	
	      
?>