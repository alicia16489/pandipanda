<div id="login_wrap">
	<div id="login_content">
		<img id="login_cancel" src="img/ico_close.png" width="26" height="26" alt="close">
		<span id="login_header">
			CONNEXION
		</span>
		<div id="login_form">
			<form action="index.php?action=login" method="post">
				<table>
					<tr><td><input value="<?php if(isset($_POST['login'])){echo $_POST['login'];} ?>" class="log" type="text" id="login" name="login" placeholder="Nom de compte ou adresse mail"></td><td class="error"><span id="login_span"></span></td></tr>
					<tr><td><input value="<?php if(isset($_POST['password'])){echo $_POST['password'];} ?>" class="log" type="password" id="login_password" name="password" placeholder="Mot de passe"></td><td class="error"><span></span></td></tr>
					<tr><td colspan="2"><input id="log_submit" type="submit" id="login_button" value="SE CONNECTER"><a href="#" id="forgot_pass">Mot de passe oubli&eacute;</a></td></tr>
					<?php if(isset($login_error)){ ?>
					<tr><td colspan="2" id="login_error" class="errors">Connexion impossible, vérifié vos informations</td></tr>
					<?php } ?>
				</table>
			</form>
		</div>
	</div>
</div>