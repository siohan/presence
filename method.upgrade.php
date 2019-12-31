<?php
#-------------------------------------------------------------------------
# Module: Presence
# Version: 0.3
# Method: Upgrade
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

$db = $this->GetDb();			/* @var $db ADOConnection */
$dict = NewDataDictionary($db); 	/* @var $dict ADODB_DataDict */
/**
 * After this, the code is identical to the code that would otherwise be
 * wrapped in the Upgrade() method in the module body.
 */

$current_version = $oldversion;
switch($current_version)
{
  // we are now 1.0 and want to upgrade to latest
 
	
	case "0.1" : 
	case "0.2" :	
	
	{
		//$this->SetPreference('LastSendMessage', time());
		$fn = cms_join_path(dirname(__FILE__),'templates','orig_presencemailtemplate.tpl');
		if( file_exists( $fn ) )
		{
			$template = file_get_contents( $fn );
			$this->SetTemplate('presencemail_Sample',$template);
		}
		
		$fn = cms_join_path(dirname(__FILE__),'templates','orig_smstemplate.tpl');
		if( file_exists( $fn ) )
		{
			$template = file_get_contents( $fn );
			$this->SetTemplate('sms_relance',$template);
		}
	}
	
	case "0.3" : 
	{
		
		
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_presence_presence", "reponse1 C(150), reponse2 C(150)");
		$dict->ExecuteSQLArray($sqlarray);
				
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_presence_belongs", "timbre I(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		$now = time() - 3600*24;
		$query = "UPDATE ".cms_db_prefix()."module_presence_belongs SET timbre = ?";
		$db->Execute($query, array($now));
		$this->SetPreference('LastSendNotification', time());
	}
	case "0.3.1":
	{
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_presence_belongs", "timbre I(11)");
		$dict->ExecuteSQLArray( $sqlarray );
		
		$sqlarray = $dict->AddColumnSQL( cms_db_prefix()."module_presence_presence", "group_notif I(3)");
		$dict->ExecuteSQLArray($sqlarray);
		
		$sqlarray = $dict->CreateIndexSQL('unicite', cms_db_prefix().'module_presence_belongs', 'id_presence, genid');//, array('UNIQUE'));
		$dict->ExecuteSQLArray($sqlarray);
		$this->SetPreference('interval', '300');
	}
}
// put mention into the admin log
$this->Audit( 0, 
	      $this->Lang('friendlyname'), 
	      $this->Lang('upgraded', $this->GetVersion()));

//note: module api handles sending generic event of module upgraded here
?>