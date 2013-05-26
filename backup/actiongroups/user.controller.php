<?php
	require_once('./models/userClass.model.php');
	$user = new Users();
	
	if ($action == 'register'){
		if(!empty($_POST)){
			if(isset($elem)){
				if($elem == "login"){
					
					if(($nb=$user->checkAvailableLogin($post)) > 0){
						$data['login']=false;
					}
					else{
						$data['login']=true;
					}
					
				}
				elseif($elem == "email"){
					if(($nb=$user->checkAvailableEmail($post)) > 0){
						$data['email']=false;
					}
					else{
						$data['email']=true;
					}
				}
				elseif($elem == "form"){
					// verif serveur
					$ready=true;
					if(!stringCheck($post['login'],'alphanum',6,20)){
						$ready=false;
					}
					elseif(($nb=$user->checkAvailableLogin($post)) > 0){
						$ready=false;
					}
					elseif(!stringCheck($post['password'],'alphanum',8,20)){
						$ready=false;
					}
					elseif($post['password'] != $post['vpassword']){
						$ready=false;
					}
					elseif(filter_var($post, FILTER_VALIDATE_EMAIL)){
						$ready=false;
					}
					elseif(($nb=$user->checkAvailableEmail($post)) > 0){
						$ready=false;
					}
					
					
					if($ready){
						if($user->register($post)){
							$data['register']=true;
						}
					}
				}
			}
		}
	}
	elseif ($action == 'login'){
		if(!empty($_POST) && $user->checkUserLogin($_POST)){
			header("Location: index.php"); die();
		}
		else{
			
		}
	}
	elseif ($action == 'disconnect'){
		unset($_SESSION['id_user']);
		session_destroy();
		header('location: index.php');
	}
	elseif ($action == 'admin_panel'){
		$table = new Table($elem);
		$data['users']=$table->getAll($elem,$order,$sens);
		$ranks= new Table('users_rank');
		$data['ranks']=$ranks->getAll();
		if($elem == "users"){
			
		}
	}
	
	
	include($route=route('home'));

?>