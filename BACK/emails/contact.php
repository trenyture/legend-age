<?php
	require_once(dirname(__FILE__) . '/_head.php');
?>
	<p></p>
	<p>
		Bonjour,
		<br><br>Vous avez reçu une nouvelle demande de contact de la part de <?php echo $datas['name'] ?> :
	</p>
	<p><?php echo nl2br($datas['message']); ?></p>
<?php
	require_once(dirname(__FILE__) . '/_foot.php');
?>