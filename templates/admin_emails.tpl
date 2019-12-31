{form_start action='admin_emails_tab'}
<div class="c_full cf">
  <input type="submit" name="submit" value="Envoyer"/>
  <input type="submit" name="cancel" value="Annuler" formnovalidate/>
</div>
<fieldset>
	<legend>Configuration des emails</legend>
	<div class="c_full cf">
		<label class="grid_3">Alias de la page des réponses (Obligatoire)</label>
		<div class="pageinput"><input type="text" name="pageid_presence" value="{$pageid_presence}">{cms_help key='help_alias' title='alias de la page des réponses'}</div>
	</div>
<div class="c_full cf">
	<label class="grid_3">Le sujet de l'email</label>
	<div class="pageinput"><input type="text" name="emailpresencesubject" value="{$email_presence_subject}"/>{cms_help key='help_sujet_email' title='Sujet du mail'}</div>
</div>
<div class="c_full cf">
	<label class="grid_3">Le corps du mail</label>
	<div class="grid_8">{cms_textarea name=emailpresencebody rows="5" cols="20" enablewysiwyg=1  value=$presencemail_Sample placeholder="Votre message ici"}{cms_help key='help_corps_email' title='Corps du mail'}</div>
</div>
</fieldset>
{form_end}