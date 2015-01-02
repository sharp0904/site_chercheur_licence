<?php
use yii\helpers\Html;

$this->title = 'Logo';
?>
<div class='site-index'>
  <h1><?= Html::encode($this->title) ?></h1>
</br>
</br>
<div id="form-logo">
<form enctype="multipart/form-data" action="index.php?r=site/logo" method="post">
  <input name="logo" type="file" />
  <input type="hidden" name="_csrf" value="V1hnRV9sY1EdDQQuZjUgKxs5VxxuFFRiEjpVPA1bFxgFAjIKDwIJYQ==">
  <br />
  <input type="submit" value="Submit" />
</form>
</div>
</div>