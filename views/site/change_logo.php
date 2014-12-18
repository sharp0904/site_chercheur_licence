<?php
use yii\helpers\Html;

$this->title = 'Site enseignant chercheur';
?>
<div class='site-index'>
</br>
</br>
<div id="form-logo">
<form enctype="multipart/form-data" action="index.php?r=site/logo" method="post">
  Envoyez le fichier : <input name="logo" type="file" />
  <input type="hidden" name="_csrf" value="V1hnRV9sY1EdDQQuZjUgKxs5VxxuFFRiEjpVPA1bFxgFAjIKDwIJYQ==">
  <br />
  <input type="submit" value="Envoyer le fichier" />
</form>
</div>
</div>