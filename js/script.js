
//-- NAMESPACE --//
var OE = {


	//PROPERTY
	version: 0.1,
	
	ajax : {
		// requete (template <-> serveur)
		launch : function (data) {
			var url = './index.ajax.php';
			var toExecute = data['action'];
			var param = data['elem'];
			
			if(param == "null"){
				var posting = $.post(url, data, function(data) { 
					OE.ajax.callback[toExecute](data);
				});
			}
			else{
				var posting = $.post(url, data, function(data) { 
					OE.ajax.callback[toExecute][param](data);
				});
			}
		},
		
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		// -- on prepare les informations provenant du template avant de les envoyer au serveur avec une requete ajax via l'objet XMLHttpRequest -- //
		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		register : {
			login : function (data) { 
				var postObj = {
					requete : 'action',
					action : 'register',
					elem : 'login',
					post : {
						login: data
					}
				};
				
				// on apel la fonction qui lance les requetes ajax
				OE.ajax.launch(postObj);
			},
			
			email : function (data) { 
				var postObj = {
					requete : 'action',
					action : 'register',
					elem : 'email',
					post : {
						email: data
					}
				};
				
				// on apel la fonction qui lance les requetes ajax
				OE.ajax.launch(postObj);
			},
			
		},
		
		callback : {
			register : {
				login : function (data) {
					var span = $('#log_span');
					
					span.text("available");
					span.css("color", "#39EA25");
				},
			
				email : function (data) {
					var span = $('#email_span');
					
					span.text("available");
					span.css("color", "#39EA25");
				},
			},
		},
	},
	
	display : {
	
		register : function (data) {
			var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i 
			var ck_password =  /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/;
			
			// variables d'environnements
			var id = data.attr('id');
			var row = data.parents("tr");
			var span = row.children(".error").children();
			//on control l'id de l'element remplis par l'utilisateur pour choisir le bon traitement d'affichage
			switch(id){
				case 'login':
					if(data.val().length == 0){ // on fait disparaitre l'element si le text est vide
						span.text("");
						span.css("color", "");
					}
					else if(data.val().length < 6){ // si text non vide et inférieur à 6 alors..
						span.text("no");
						span.css("color", "#FF5656");
					}
					else{ // default
						return true;
					}
				break;
				case 'password':
					if (!ck_password.test(data.val())) {
						span.text("You must enter a valid Password");
						span.css("color", "#FF5656");
					}
					else{
						span.text("ok");
						span.css("color", "#39EA25");
					}
				break;
				case 'vpassword':
					if(data.val().length > 0){
						if($("#password").val() != data.val()){
							span.text("Your password confirmation isn't good");
							span.css("color", "#FF5656");
						}
						else{
							span.text("ok");
							span.css("color", "#39EA25");
						}
					}
				break;
				case 'email':
					if (!ck_email.test(data.val())) {
						span.text("You must enter a valid email address");
						span.css("color", "#FF5656");
					}
					else{
						return true;
					}
				break;
			}
			
		},
		
		login : {
		
		}
	},
	
	
};

//-- EVENT LISTENER --//
(function($){

	$('#register_wrap input').keyup(function(){
		if(OE.display.register($(this))){
			OE.ajax.register[$(this).attr('id')]($(this).val());
		}
	});

})(jQuery);