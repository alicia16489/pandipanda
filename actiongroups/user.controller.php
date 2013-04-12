<?php

	require_once('models/userClass.model.php');
	$users = new Users();

	if ($action == 'register')
	{
		if (empty($_POST))
		{
			// verif error
		}
		elseif (empty($error))
		{
			newUser($_POST);

			if ($_POST['statut'] == 'creatif')
				create_dir($_POST['pseudo']);

			header('location: ?action=activate_profil');
		}
	}
	elseif ($action == 'login')
	{
		if (empty($_POST))
		{
			// verif error
		}
		elseif (empty($error) && $data = checkUserLogin($_POST) == TRUE)
		{
			$_SESSION['id_user'] = $data['id'];
			session_write_close();

			header('location: ?action=home');
		}
	}
	elseif ($action == 'disconnect')
	{
		unset($_SESSION['id_user']);
		session_destroy();

		header('location: index.php');
	}
	elseif ($action == 'activate_profil')
	{
		if (!empty($_GET['email_key']))
		{
			activateAccount($_GET['email_key']);

			header('location: ?action=home');
		}
		else
		{

		}
	}
	elseif ($action == 'edit_profil')
	{
		echo ('You can\'t BITCH !');
	}

?>