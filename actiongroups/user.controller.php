<?php

	require_once('./models/userClass.model.php');
	$user = new Users();

	if ($action == 'register'){
		if (empty($_POST)){
			// verif error
		}
		elseif (empty($error)){
			if($elem == "login"){
				$nb=$user->checkAvailableLogin($post);
				if($nb == 0){
					$data['login']=true;
				}
			}
			elseif($elem == "email"){
				$nb=$user->checkAvailableEmail($post);
				if($nb == 0){
					$data['login']=true;
				}
			}
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