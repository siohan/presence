<?php

#-------------------------------------------------------------------------
# Module : Presence - 
# Version : 0.4, Sc
# Auteur : AssoSimple, Claude SIOHAN
#-------------------------------------------------------------------------
/**
 *
 * @author Claude SIOHAN
 * @since 0.1
 * @version $Revision: 1 $
 * @license GPL
 **/

class Presence extends CMSModule
{
  
  function GetName() { return 'Presence'; }   
  function GetFriendlyName() { return $this->Lang('friendlyname'); }   
  function GetVersion() { return '0.4'; }  
  function GetHelp() { return $this->Lang('help'); }   
  function GetAuthor() { return 'Claude SIOHAN'; } 
  function GetAuthorEmail() { return 'claude.siohan@gmail.com'; }
  function GetChangeLog() { return $this->Lang('changelog'); }
    
  function IsPluginModule() { return true; }
  function HasAdmin() { return true; }   
  function GetAdminSection() { return 'content'; }
  function GetAdminDescription() { return $this->Lang('moddescription'); }
 
  function VisibleToAdminUser()
  {
    	return 
		$this->CheckPermission('Presence use');
	
  }
  
  
  function GetDependencies()
  {
	return array('Adherents'=>'0.3.4.5', 'Messages'=>'0.3.1', 'Sms'=>'0.3.1');
  }

  

  function MinimumCMSVersion()
  {
    return "2.0";
  }

  
  function SetParameters()
  { 
  	$this->RegisterModulePlugin();
	$this->RestrictUnknownParams();
	$this->SetParameterType('display',CLEAN_STRING);
	$this->SetParameterType('action',CLEAN_STRING);
	$this->SetParameterType('record_id', CLEAN_INT);
	$this->SetParameterType('id_presence', CLEAN_INT);
	$this->SetParameterType('licence', CLEAN_STRING);
	$this->SetParameterType('genid', CLEAN_INT);
	$this->SetParameterType('reponse', CLEAN_INT);
	$this->SetParameterType('recap', CLEAN_INT);
	$this->SetParameterType('sms', CLEAN_STRING);
	
	//form parameters
	$this->SetParameterType('submit',CLEAN_STRING);
	//$this->SetParameterType('tourlist',CLEAN_INT);
	

}

function InitializeAdmin()
{
  	return parent::InitializeAdmin();
	$this->SetParameters();
	//$this->CreateParameter('pagelimit', 100000, $this->Lang('help_pagelimit'));
}

public function HasCapability($capability, $params = array())
{
   if( $capability == 'tasks' ) return TRUE;
   return FALSE;
}

public function get_tasks()
{
   $obj = array();
	$obj[0] = new RecupPresenceTask();
 //  	$obj[0] = new sendTask();  
	
return $obj; 
}

  function GetEventDescription ( $eventname )
  {
    return $this->Lang('event_info_'.$eventname );
  }
     
  function GetEventHelp ( $eventname )
  {
    return $this->Lang('event_help_'.$eventname );
  }

  function InstallPostMessage() { return $this->Lang('postinstall'); }
  function UninstallPostMessage() { return $this->Lang('postuninstall'); }
  function UninstallPreMessage() { return $this->Lang('really_uninstall'); }
  function random_string($car) {
	$string = "";
	$chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	srand((double)microtime()*1000000);
	for($i=0; $i<$car; $i++) {
		$string .= $chaine[rand()%strlen($chaine)];
	}
	return $string;
  }

  
  function _SetStatus($oid, $status) {
    //...
  }




} //end class
?>
