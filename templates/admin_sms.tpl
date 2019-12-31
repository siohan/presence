{form_start action='admin_sms_tab'}
<div class="c_full cf">
  <input type="submit" name="submit" value="Envoyer"/>
  <input type="submit" name="cancel" value="Annuler" formnovalidate/>
</div>

<fieldset>
	<legend>Parametres SMS</legend>


	<div class="c_full cf">
		<label class="grid_3">Nom de l'expéditeur</label>
		<div class="pageinput"><input type="text" name="sms_sender" value="{$sms_sender}"/>{cms_help key='help_sms_sender' title='Nom de l\'expéditeur'}</div>
	</div>
	<div class="c_full cf">
		<label class="grid_3">Le corps du SMS</label>
		{*<div class="information grid_8">Un SMS contient 160 caractères. Attention à ce que les variables <var>{$titre}</var> et <code>{$description}</code> ne dépassent la limite. Les variables indispensables sont <code>{$titre}</code> et <code>{$oklien}</code>. Pour désactiver une balise : {$description}</div>
		<div class="grid_3">&nbsp;</div>*}
		<div class="grid_8">{cms_textarea name=sms_relance rows="3" cols="20" enablewysiwyg=0  value=$sms_relance}{cms_help key='help_corps_sms' title='Corps du sms'}</div>
	</div>
	</fieldset>
	<fieldset>
		<legend>Raccourcisseur d'URL (Bitly)</legend>
	<div class="information grid_14">Pour utiliser le raccourcisseur d'URL, vous aurez besoin d'un compte bitly (voir l'aide sur le module)</div>
		<div class="c_full cf">
			<label class="grid_3"> Client Id </label>
			<div class="pageinput"><input type="text" name="bitly_client_id" value="{$bitly_client_id}" size="50"/></div>
		</div>
		<div class="c_full cf">
			<label class="grid_3">Client secret</label>
			<div class="pageinput"><input type="text" name="bitly_client_secret" value="{$bitly_client_secret}" size="50"/></div>
		</div>
		<div class="c_full cf">
			<label class="grid_3">Access token</label>
			<div class="pageinput"><input type="text" name="bitly_access_token" value="{$bitly_access_token}" size="50"/></div>
		</div>
		<div class="c_full cf">
			<label class="grid_3">Page de retour de l'application</label>
			<div class="pageinput"><input type="text" name="bitly_redirect_uri" value="{$bitly_redirect_uri}" size="50"/></div>
		</div>
	</fieldset>

{form_end}