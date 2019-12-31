<h2>Liste des présences</h2>
<div class="pageoptions"><p class="pageoptions">{$itemcount}&nbsp;{$itemsfound}</p><p><a href="{module_action_url action=add_edit_presence}">{admin_icon icon='newobject.gif'} Ajouter une présence</a></div>
{if $itemcount > 0}
{*$form2start*}
<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>
		<th>Id</th>
		<th>Nom</th>
		<th>Description </th>
		<th>Début</th>
		<th>Limite</th>
		<th>actif ?</th>
		<th>Prévenir/Relancer</th>
		<th>Réponses (taux)</th>
		<th colspan="4">Action(s)</th>
		<!--<th><input type="checkbox" id="selectall" name="selectall"></th>-->
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->id}</td>
	<td>{$entry->nom}</td>
	<td>{$entry->description}</td>
	<td>{$entry->date_debut|date_format:"%d-%m-%Y"} - {$entry->heure_debut}</td>
	<td>{$entry->date_limite|date_format:"%d-%m-%Y"}</td>
	<td>{$entry->actif}</td>
	<td>{$entry->emailing} - {$entry->sms}</td>
	<td>{$entry->inscrits}/{$entry->taux}</td>
	<td>{$entry->editlink}</td> 
	<td>{$entry->duplicate}</td>
	<td>{$entry->view}</td> 
	<td>{$entry->delete}</td> 
<!--	<td><input type="checkbox" name="{$actionid}sel[]" value="{$entry->id}" class="select"></td>-->
  </tr>
{/foreach}
 </tbody>
</table>
<!-- SELECT DROPDOWN -->
<div class="pageoptions" style="float: right;">
<br/>{$actiondemasse}{$submit_massaction}
  </div>
{*$form2end*}
{/if}
