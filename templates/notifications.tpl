{$start_form}
<fieldset>
<legend>Configuration principale</legend>
	<div class="pageoverflow">
		<p class="pagetext">Alias de la page des réponses (Obligatoire)</p>
		<p class="pageinput">{$pageid_presence}</p>
	</div>
</fieldset>

<fieldset>	
<legend>Paramètres Email</legend>
<div class="pageoverflow">
	<p class="pagetext">Email du gestionnaire de présence</p>
	<p class="pageinput">{$input_adminemail}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">Le sujet du mail</p>
	<p class="pageinput">{$input_emailpresencesubject}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">Le corps du mail</p>
	<p class="pageinput">{$emailpresencebody}</p>
</div>
</fieldset>
<fieldset>
	<legend>Paramètres SMS</legend>
	<div class="pageoverflow">
		<p class="pagetext">Nom de l'expéditeur</p>
		<p class="pageinput">{$sms_sender}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">Le corps du SMS</p>
		<p class="pageinput">{$sms_relance}</p>
	</div>
	</fieldset>
	<fieldset>
		<legend>Paramètres bitly (raccourci des urls)</legend>
		<div class="pageoverflow">
			<p class="pagetext"> Client Id </p>
			<p class="pageinput">{$bitly_client_id}</p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Client secret</p>
			<p class="pageinput">{$bitly_client_secret}</p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Access token</p>
			<p class="pageinput">{$bitly_access_token}</p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">Page de retour de l'application</p>
			<p class="pageinput">{$bitly_redirect_uri}</p>
		</div>
		</fieldset>
{$submit}
{$end_form}