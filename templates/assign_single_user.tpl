<div class="pageoverflow">
<h3>{$nom} - {$description}</h3>
{form_start action=assign_single_user}
<input type="hidden" name="id_presence" value="{$id_presence}">
<input type="hidden" name="genid" value="{$genid}">
<div class="pageoverflow">
    <p class="pagetext">Réponse :</p>
<input type="radio" name="id_option" value="1" checked>Présent
    <input type="radio" name="id_option" value="0">Absent
  </div>

    <input type="submit" name="submit" value="Envoyer" /><input type="submit" name="cancel" value="Annuler"/></p>
  </div>
{form_end}
</div>