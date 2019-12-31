<h3>Ajout / Modification d'une présence</h3>
{form_start}
<div class="c_full cf">
  <input type="submit" name="submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>
{if $edit == 1}
	<input type="hidden" name="record_id" value="{$record_id}" />
{/if}
	<div class="c_full cf">
		<label class="grid_3">Actif</label>
		<div class="grid_8">
		<select class="grid_2" name="actif">{cms_yesno selected=$actif}</select>{cms_help key='help_actif_inactif' title='Actif/Inactif'}
		</div>
	</div>
	<div class="c_full cf">
		<label class="grid_3">Nom</label>
		<div class="grid_8">
		<input class="grid_8 required" type="text" name="nom" value="{$nom}"/>
		</div>
	</div>
	<div class="c_full cf">
		<label class="grid_3">Description</label>
		<div class="grid_8">
			<input class="grid_8 required" type="text" name="description" value="{$description}"/>{cms_help key='help_description' title='Description de la présence'}
		</div>
	</div>
	<div class="c_full cf">
		<label class="grid_3">Date de début</label>
		<div class="grid_8">
			<input  class="grid_8 required" type="date" name="date_debut" value="{$date_debut}"/>{cms_help key='help_date_debut' title='Date de début'}
		</div>
	</div>	
	<div class="c_full cf">
			<label class="grid_3">Date limite de réponse</label>
			<div class="grid_8">
			<input  class="grid_8 required" type="date" name="date_limite" value="{$date_limite}"/>{cms_help key='help_date_limite' title='Date limite'}
			</div>
	</div>
	<div class="c_full cf">
		<label class="grid_3">Groupe concerné</label>
		<div class="grid_8">
			<select class="grid_8" name="groupe">{html_options options=$liste_groupes selected=$groupe}</select>{cms_help key='help_groupe_concerne' title='Groupe concerné'}
		</div>
	</div>
	<div class="c_full cf">
		<label class="grid_3">Groupe à notifier</label>
		<div class="grid_8">
			<select class="grid_8" name="group_notif">{html_options options=$liste_groupes selected=$group_notif}</select>{cms_help key='help_groupe_notifie' title='Groupe à notifier'}
		</div>
	</div>



{form_end}
</div>
