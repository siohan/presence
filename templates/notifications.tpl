<p class="warning">Les notifications vous permettent de connaitre les ajouts et/ou les modifications réalisées depuis la dernière date de collecte. Un email est envoyé au groupe à notifier si et seulement s'il y a eu un ajout ou une modification depuis cette dernière date qui est alors actualisée. Dans cet email figure également un lien pour récupérer la liste exhaustive des résultats. La date prévisionnelle de collecte est indicative.(Voir aide sur le module)</p>
{form_start action="admin_notifications_tab"}
<div class="c_full cf">
  <input type="submit" name="submit" value="Envoyer"/>
  <input type="submit" name="cancel" value="Annuler" formnovalidate/>
</div>
	<fieldset>
		<legend>Notifications</legend>
		<div class="c_full cf">
			<label class="grid_3">Date de la dernière notification</label>
			<div class="pageinput">{html_select_date start_year='2019' end_year='+10' time=$LastSendNotification}@ {html_select_time time=$LastSendNotification display_seconds=true}</div>
		</div>
		<div class="c_full cf">
			<label class="grid_3">Intervalle de collecte entre deux notifications</label>
			<div class="pageinput"><input type="text" name="result" value="{$result}"><select name="unite">{html_options options=$liste_unite selected=$unite}</select></div>
		</div>
		<div class="c_full cf">
			<label class="grid_3">Date prévisionnelle de la prochaine notification</label>
			<div class="pageinput">{html_select_date start_year='2019' prefix='collecte_' end_year='+10' time=$collecte}@ {html_select_time time=$collecte prefix='collecte_' display_seconds=true}</div>
		</div>

	</fieldset>

{form_end}