<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<title>Photo For You</title>
	<?php include "includes/head.php"; ?>
</head>
	<body>
		<?php 
		include "includes/bdd.php";
		include "includes/nav.php";
		//! ajouter les dernieres img mise en vente qui non pas encore d'acheter (a limier en nombre)
		?>
		

		<?php include "includes/footer.php"; ?>
	</body>
</html>