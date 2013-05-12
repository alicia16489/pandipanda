var login = false;
var email = false;
//-- NAMESPACE --//
var OE = {


	//PROPERTY
	version: 0.1,
	
	ajax : {
		// requete (template <-> serveur)
		launch : function (data) {
			var url = './index.ajax.php';
			var toExecute = data['action'];
			var elem = data['elem'];
			var param = data['param'];
			
			if(elem == undefined && param == undefined){
				$.post(url, data, function(data) { 
					OE.ajax.callback[toExecute](data);
				},'json');
			}
			else if (param == undefined){
				$.post(url, data, function(data) { 
					OE.ajax.callback[toExecute][elem](data);
				},'json');
			}
			else{
				$.post(url, data, function(data) { 
					OE.ajax.callback[toExecute][elem][param](data);
				},'json');
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
			
			form : function (data) {
				var post = new Array();
				
				for(var i=0; i<data.length; i++){
					var input = $("#register_wrap input:eq(" + i + ")");
					post[i] = input.val();
					
				}
				var postObj = {
					requete : 'action',
					action : 'register',
					elem : 'form',
					post : {
						login : post[0],
						password : post[1],
						vpassword : post[2],
						email : post[3]
					}
				};
				
				OE.ajax.launch(postObj);
			},
			
		},
		
		search : function () {
			var text = $('#search').val();
			var type = $('#type option:selected').val();
			var category = $('#category option:selected').val();
			var labels = $('#media_labels input:checked');
			var list_labels = new Array();
			
			
			for(var i=0; i<labels.length; i++){
				list_labels[i] = labels[i].value;
			}
			console.log(list_labels);
			
			var postObj = {
				requete : 'action',
				action : 'media_search',
				post : {
					search : text,
					type : type,
					category : category,
					labels : list_labels
				}
			};
			OE.ajax.launch(postObj);
			
			
		},
		
		admin_panel : {
			users : {
				getAll : function (order,sens){
				var postObj = {
					requete : 'action',
					action : 'admin_panel',
					elem : 'users',
					param : 'getAll',
					order : 'login',
					sens : 'ASC',
					post : {
						empty : 'empty'
					}
				};
				OE.ajax.launch(postObj);
				}
			},
		},
		
		callback : {
			register : {
				login : function (data) {
					var span = $('#log_span');
					
					if(data['login']){
						span.text("available");
						span.css("color", "#39EA25");
						login = true;
					}
					else{
						span.text("unavailable");
						span.css("color", "red");
						login = false;
					}
				},
			
				email : function (data) {
					var span = $('#email_span');
					
					if(data['email']){
						span.text("available");
						span.css("color", "#39EA25");
						email = true;
					}
					else{
						span.text("unavailable");
						span.css("color", "red");
						email = false;
					}
				},
				
				form : function (data) {
					if(data['register'])
						OE.display.animation.form;
				},
			},
			
			media_search : function (data) {
				$("#search_list_result").empty();
				$("#search_list_result").append('<table></table>');
				if(data.length != 0){
					if(typeof data[0] == "object"){
						for(var i=0; i<data.length; i++){
							$("#search_list_result table").append('<tr id='+data[i]['id']+'><td>'+data[i]['type']+'</td><td>'+data[i]['title']+'</td></tr>');
							$("#"+data[i]['id']).hide();
							$("#"+data[i]['id']).fadeIn();
						}
					}
					else{
						$("#search_list_result table").append('<tr id='+data['id']+'><td>'+data['type']+'</td><td>'+data['title']+'</td></tr>');
						$("#"+data['id']).hide();
						$("#"+data['id']).fadeIn();
					}
				}
				else{
					// no result
				}
			},
			
			admin_panel : {
				users : {
					getAll : function (data){
						OE.display.animation.admin_panel.list_users(data);
					}
				}
			}
		},
	},
	
	display : {
		
		animation : {
			register : {
				form : function (){
					$("#register_wrap").fadeOut('slow');
				}
			},

			search_col_size : function(){
					$('#side_search').height($(window).height()-140)
			},
			
			admin_panel : {
				display : function() {
					
				},
				list_users : function (data) {
					$("#list_membre table").empty();
					$("#list_membre table").append('<tr><td>login</td><td>email</td><td>Rank</td><td>Ban</td></tr>');
					for(var i=0; i<data.length; i++){
						$("#list_membre table").append('<tr id=user_'+data[i]['id']+'><td>'+data[i]['login']+'</td></tr>');
						$("#user_"+data[i]['id']).hide();
						$("#user_"+data[i]['id']).fadeIn();
					}
				}
			},
			
			
		},
		
		text : {
			register : function (data,id,tab) {
				var row = data.parents("tr");
				var span = row.children(".error").children();
				
				if(tab[id]['state'] == true){
					span.text("ok");
					span.css("color", "#39EA25");
				}
				else if(tab[id]['state'] == false){
					span.text(tab[id]['text']);
					span.css("color", "#FF5656");
				}
				else{
					span.text("Can't be empty!");
					span.css("color", "#FF5656");
				}
			},
			
			login : {
			
			},
		
		},
	},
	
	
	check : {
		
		register : function (data) {
			var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i 
			var ck_password =  /^[A-Za-z0-9!@#$%^&*()_]{6,20}$/;
			
			// variables d'environnements
			var id = data.attr('id');
			var tab = new Array();
			tab[id]= new Array();
			tab[id]['state']=true;
			
			//on contrôle l'id de l'element rempli par l'utilisateur pour choisir le bon traitement d'affichage
			switch(id){
				case 'login':
					if(data.val().length < 6){ // si text non vide et inférieur à 6 alors..
						tab[id]['state']=false;
						tab[id]['text']=new Array("Your login must have 6 letters minimum");
					}
					else{ // default
						return true;
					}
				break;
				case 'password':
					if (!ck_password.test(data.val())) {
						tab[id]['state']=false;
						tab[id]['text']=new Array("You must enter a valid Password");
					}
				break;
				case 'vpassword':
					if(data.val().length > 0){
						if($("#password").val() != data.val()){
							tab[id]['state']=false;
							tab[id]['text']=new Array("Your password confirmation isn't good");
						}
					}
				break;
				case 'email':
					if (!ck_email.test(data.val())) {
						tab[id]['state']=false;
						tab[id]['text']=new Array("You must enter a valid email address");
					}
					else{
						return true;
					}
				break;
			}
			
			if(data.val().length == 0){ // on fait disparaitre l'element si le text est vide
				tab[id]['state']=null;
			}
			
			OE.display.text.register(data,id,tab);
			return tab[id]['state'];
		},
	},
};

//-- EVENT LISTENER --//
(function($){
	// login
	
	
	// register
	$('#register_wrap input').blur(function(){
		if(OE.check.register($(this))){
			OE.ajax.register[$(this).attr('id')]($(this).val());
		}
	});
	
	$('#register_wrap input').keyup(function(){
		if(OE.check.register($(this))){
			OE.ajax.register[$(this).attr('id')]($(this).val());
		}
	});
	
	$('#register_button').click(function(){
		var inputs = $("#register_wrap input");
		var valid = true;
		var form = $('#register_wrap form');
		for(var i=0; i<inputs.length; i++){
			var input = $("#register_wrap input:eq(" + i + ")");
			var id = input.attr('id');
			
			if(!OE.check.register(input)){
				valid = false;
			}
		}
		
		if(valid && login && email){
			OE.ajax.register.form(inputs);
		}
	});
	
	$('#search_button').click(function(){
		OE.ajax.search();
	});

	OE.display.animation.search_col_size();

	$(window).resize(function(){
		OE.display.animation.search_col_size();
	});
	
	$("#admin_panel").click(function(){
		OE.ajax.admin_panel.users.getAll();
	});

})(jQuery);