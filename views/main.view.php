<!DOCTYPE html>
<html lang="fr">
	<head>

	</head>

	<body>

		<?php

			// VERIFIE L'EXISTENCE DES VUES

			$template_path = 'templates/'.$template.'.template.php';

			if (is_readable($template_path) && file_exists($template_path))
				include($template_path);
			else
				die ('Page '.$template_path.' inexistant ou innaccessible <br /> <a href="index.php">retour &agrave; l\'accueil</a>');

		?>

	</body>
</html>