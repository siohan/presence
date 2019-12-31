<h2>Liste des Présences</h2>
<div class="pageoptions"><p class="pageoptions"></p></div>
{if $itemcount > 0}

<table border="0" cellspacing="0" cellpadding="0" class="pagetable">
 <thead>
	<tr>	
		<th>Evenement</th>
		<th>Nom</th>	
		<th>Réponse</th>
	</tr>
 </thead>
 <tbody>
{foreach from=$items item=entry}
  <tr class="{$entry->rowclass}">
	<td>{$entry->nom}</td>
	<td>{$entry->nom_genid}</td>
	<td>{$entry->reponse}</td>
  </tr>
{/foreach}
 </tbody>
</table>
{/if}
<p>Ci-dessous le lien vers la liste actualisée et exhaustive des réponses<br /><a href="{$lien_recap}">{$lien_recap}</a>