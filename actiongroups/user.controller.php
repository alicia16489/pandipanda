<?php

	require_once('./models/userClass.model.php');
	$user = new Users();
	
	if ($action == 'register'){
		if(!empty($_POST)){
			if(isset($elem)){
				if($elem == "login"){
					$nb=$user->checkAvailableLogin($post);
					if($nb == 0){
						$data['login']=true;
					}
					else{
						$data['login']=false;
					}
				}
				elseif($elem == "email"){
					if(($nb=$user->checkAvailableEmail($post)) > 0){
						$data['email']=true;
					}
					else{
						$data['email']=false;
					}
				}
			}
			else{
				// verif serveur
				$ready=true;
				if(!stringCheck($_POST['login'],'alphanum',6,20)){
					$ready=false;
				}
				elseif(($nb=$user->checkAvailableLogin($_POST)) > 0){
					$ready=false;
				}
				elseif(!stringCheck($_POST['password'],'alphanum',8,20)){
					$ready=false;
				}
				elseif($_POST['password'] != $_POST['vpassword']){
					$ready=false;
				}
				elseif(filter_var($_POST, FILTER_VALIDATE_EMAIL)){
					$ready=false;
				}
				elseif(($nb=$user->checkAvailableEmail($_POST)) > 0){
					$ready=false;
				}
				
				
				if($ready){
					if($user->register($_POST)){
						header("Location: index.php");
					}
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