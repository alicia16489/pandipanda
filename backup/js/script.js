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
			var type = $('#post_type option:selected').val();
			var category = $('#post_category option:selected').val();
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
					var span = $('#login_reg_span');
					
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
					
					if(data['register']){
						OE.display.animation.register.form();
					}
				},
			},
			
			media_search : function (data) {
				console.log(data);
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
			center_overlay : function(id,idPop){				
					var overlay = document.getElementById(id);
					var popup = document.getElementById(idPop);
					$("#"+id).fadeIn();
					var height = window.innerHeight;
					var width = window.innerWidth;
					
					width=width-popup.offsetWidth;
					height=height-popup.offsetHeight;
					
					var miHeight = height/2;
					var miWidth = width/2;
					overlay.style.padding=miHeight+"px "+miWidth+"px";
			},
				
			login : {
				
				pop : function (){
					OE.display.animation.center_overlay('login_wrap','login_content');
				},
				
				unpop : function (){
					$("#login_wrap").fadeOut();
				}
				
			},
			
			register : {
				form : function (){
					console.log("here");
					$("#register_wrap").fadeOut('slow');
				},
				
				pop : function (){
					OE.display.animation.center_overlay('register_wrap','register_content');
				},

				unpop : function (){
				
					$("#register_wrap").fadeOut();
				}
			},

			col_size : function(){
					$('#side_search').height($(window).height()-140);
					$('#right_bar').height($(window).height()-140);
			},

			content_size : function(){
					$('.content_main').height($(window).height()-160);
					$('.content_main').width($(window).width()-355);
			},

			show_subtitle : function(data){
					data.prev().show();
			},

			hide_subtitle : function(data){
					data.prev().hide();
			},
			
			admin_panel : {
				display : function() {
					
				},
				list_users : function (data) {
					console.log(data['users']);
					$("#list_membre table").empty();
					$("#list_membre table").append('<tr><td>login</td><td>email</td><td>Rank</td><td>Ban</td></tr>');
					for(var i=0; i<data['users'].length; i++){
						$("#list_membre table").append('<tr id=user_'+data['users'][i]['id']+'><td>'+data['users'][i]['login']+'</td><td>'+data['users'][i]['email']+'</td><td><select class="select_rank_user" id="user_'+data['users'][i]['id']+'_rank"></select></td><td><input type="checkbox" name="ban[]" class="check_ban" id="ban_'+data['users'][i]['id']+'" ></td></tr>');
						$("#user_"+data['users'][i]['id']).hide();
						$("#user_"+data['users'][i]['id']).fadeIn();
						
						for(var j=0; j<data['ranks'].length; j++){
							var pick = "";
							if(data['users'][i]['id'] == data['ranks'][j]['id']){
								pick = "selected";
							}
							$('#user_'+data['users'][i]['id']+'_rank').append('<option '+pick+' value="'+data['ranks'][j]['id']+'">'+data['ranks'][j]['name']+'</option>');
						}
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
					console.log(tab[id]['text']);
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
var login_overlay = false;
var register_overlay = false;
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

	OE.display.animation.col_size();

	$(window).resize(function(){
		OE.display.animation.col_size();
	});
	
	$("#admin_panel").click(function(){
		OE.ajax.admin_panel.users.getAll();
	});
	
	$("#pop_login").click(function(){
		login_overlay = true;
		OE.display.animation.login.pop();
	});
	
	$("#login_cancel").click(function(){
		login_overlay = false;
		OE.display.animation.login.unpop();
	});
	
	$("#pop_register").click(function(){
		register_overlay = true;
		OE.display.animation.register.pop();
	});
	
	$("#register_cancel").click(function(){
		register_overlay = false;
		OE.display.animation.register.unpop();
	})

	$(window).resize(function(){
		if(login_overlay){
		OE.display.animation.center_overlay('login_wrap','login_content');
		}
	});

	// OVER MENU DROITE

	$(".menu").mouseover(function(){
		OE.display.animation.show_subtitle($(this));
	});

	$(".menu").mouseout(function(){
		OE.display.animation.hide_subtitle($(this));
	});


	// REDIMENSIONNEMENT CONTENT

	OE.display.animation.content_size();

	$(window).resize(function(){
		OE.display.animation.content_size();
	});

})(jQuery);

/* -- SCRIPT FORMULAIRE DE POST DE MEDIA -- */

// $(document).ready(function() // A ACTIVER POUR LE REDACTOR JS !! CHECK COMMENT LE CONFIG
// {
// 	$('#content_text').redactor();
// });

var i = 1;
var ibis = 1;

$('#input_file0').change(function(e)
{
 	var files = $(this).prop("files");
  	var names = $.map(files, function(val)
  	{
  		if (val.name != "")
		{
			$("#cop_content").html('<span id="filename_p0" class="filename_p0">'+val.name+'</span>');
		}
		else
		{
			$("#filename_p0").html("");
		}
  	});
});

$("#filename0").live('keyup', function(e)
{
	console.log($(this));
	if ($(this).val() != "")
	{
		$("#cop_content").html('<span id="filename_p0" class="filename_p0">'+$(this).val()+'</span>');
	}
	else
	{
		$("#filename_p0").html("");
	}
});

$("#add_file").click(function(e)
{
	$("#input_file").append('<div id="div_file'+i+'" class="div_file"><input type="file" name="files[]" id="input_file'+i+'" class="input_file" /><br /><input type="text" name="filename[]" id="filename'+i+'" class="filename" placeholder="Nom du fichier" size="45" /><a href="#remove" onclick="removeFile(div_file'+i+', '+i+');" id="a_file'+i+'">x</a><br /></div>');
	$("#cop_content").append('<br id="filename_br'+i+'" class="filename_br" /><span id="filename_p'+i+'" class="filename_p"></span>');

	$('#input_file'+i).change(function(e)
	{
	 	var files = $(this).prop("files");
	  	var names = $.map(files, function(val)
	  	{
	  			console.log($("#filename_p"+$(this).attr('id')));
				$("#filename_p"+$('#input_file'+i).attr('id').substr(8)).html(val.name);


				// $("#filename_p"+$(this).attr('id').substr(8)).html("");

	  	});
	});

	$("#filename"+i).live('keyup', function(e)
	{
		if ($(this).val() != "")
		{
			$("#filename_p"+$(this).attr('id').substr(8)).html($(this).val());
		}
		else
		{
			$("#filename_p"+$(this).attr('id').substr(8)).html("");
		}
	});

	i++;
});

$("#filename_link0").live('keyup', function(e)
{
	if ($(this).val() != "")
	{
		$("#cop_content").html('<span id="filename_link_p0" class="filename_link_p0">'+$(this).val()+'</span>');
	}
	else
	{
		$("#filename_link_p0").html("");
	}
});

$("#add_link_file").click(function(e)
{
	$("#input_file_link").append('<div id="div_file_link'+ibis+'" class="div_file_link"><input type="text" name="file_link[]" id="input_file_link'+ibis+'" size="45" class="input_file_link" placeholder="Lien complet de votre artwork" /><br /><input type="text" name="filename_link[]" id="filename_link'+ibis+'" class="filename_link" size="45" placeholder="Nom de l\'artwork" /><a href="#remove" onclick="removeFile(div_file_link'+ibis+', '+ibis+');" id="a_file_link'+ibis+'">x</a><br /></div>');
	$("#cop_content").append('<br id="filename_link_br'+ibis+'" class="filename_link_br" /><span id="filename_link_p'+ibis+'" class="filename_link_p"></span>');

	$("#filename_link"+ibis).live('keyup', function(e)
	{
		if ($(this).val() != "")
		{
			$("#filename_link_p"+$(this).attr('id').substr(13)).html($(this).val());
		}
		else
		{
			$("#filename_link_p"+$(this).attr('id').substr(13)).html("");
		}
	});

	ibis++;
});

function removeFile(name, id_num)
{
	$(name).fadeOut('slow', function()
	{
		$(this).remove();
		$('#filename_p'+id_num).remove();
		$('#filename_link_p'+id_num).remove();
		$('#filename_br'+id_num).remove();
		$('#filename_link_br'+id_num).remove();
	});
}

$("#title").live("keyup", function(e)
{
	$("#cop_title").text($(this).val());
});

$("#title").change(function(e)
{
	$("#cop_title").text($(this).val());
});

$("#chapter").change(function(e)
{
	$("#cop_chapter").text($(this).val());
});

$("#chap_title").live('keyup', function(e)
{
	if ($("#chap_title").val() == "")
		$("#cop_chap_title").text("chapitre "+$("#chapter").val());
	else
		$("#cop_chap_title").text($(this).val());
});

$("#chapter").live('keyup', function(e)
{
	if ($("#chapter").val() == "")
		$("#cop_chap_title").text("");
	else
		$("#cop_chap_title").text("chapitre "+$(this).val());
});

$("#cop_post_type").change(function()
{
	var optionType = $(this).val();

	if (optionType != "")
	{
		var strType = "";
	  	$("#cop_post_type option:selected").each(function()
	  	{
	        strType += $(this).text() + " ";
	  	});
	  	$("#cop_type").html(strType);
  	}
  	else
		$("#cop_type").html("");
}).change();

$("#sous_type").change(function()
{
	var optionSousType = $(this).val();

	if (optionSousType != "")
	{
	  	var strSousType = "";
	  	$("#sous_type option:selected").each(function()
	  	{
	        strSousType += $(this).text() + " ";
	  	});
	  	$("#cop_sous_type").html(strSousType);
	}
	else
		$("#cop_sous_type").html("");
}).change();

$("#cop_post_category").change(function()
{
	var optionCat = $(this).val();

	if (optionCat != "")
	{
		var strCategory = "";
	  	$("#cop_post_category option:selected").each(function()
	  	{
	        strCategory += $(this).text() + " ";
	  	});
	  	$("#cop_category").html(strCategory);
  	}
  	else
		$("#cop_category").html("");
}).change();

$("#resum").live('keyup', function(e)
{
	if ($(this).val() != "")
		$("#cop_resum").html($(this).val());
	else
		$("#cop_resum").html("");
});

$("#keywords").live('keyup', function(e)
{
	if ($(this).val() != "")
		$("#cop_keywords").html($(this).val());
	else
		$("#cop_keywords").html("");
});

$("#reset").click(function()
{
	$("#cop_chapter").text("");
	$("#cop_title").text("");
	$("#cop_resum").text("");
	$("#cop_keywords").text("");
	$("#cop_content").text("");
	$("#cop_filename").text("");
});

    var option = "0";

    if (option == "0")
	{
		$(".cat").css('display', 'table-row');
		$("#link_tr").css('display', 'none');
		$(".file_link_tr").css('display', 'none');
		$(".media_type_tr").css('display', 'none');
		$("#text_tr").css('display', 'none');
		$(".file_tr").css('display', 'none');
		$("#select_input_tr").css('display', 'none');
	}

$("#cop_post_type").on('change', function(e)
{
    option = $(this).val();

 	if (option == "1")
	{
		$("#sous_type").val("0");
		$(".content").val("");
		$("#cop_content").html("");
		$("#select_input").val("1");


		$("#content_link").live('keyup', function(e)
		{
			var link = $(this).val();

			if ($(this).val() != "")
			{
				$("#cop_content").html('<iframe id="link_content" width="300" height="200" src="" frameborder="0" allowfullscreen></iframe>');
				$("#link_content").attr("src", link);
			}
			else
				$("#cop_content").html("");
		});

		$("#text_tr").fadeOut("fast", function()
		{
			$("#link_tr").fadeIn();
		});
		$(".cat").css('display', 'table-row');
		$(".media_type_tr").css('display', 'none');
		$(".file_tr").css('display', 'none');
		$(".file_link_tr").css('display', 'none');
		$("#select_input_tr").css('display', 'none');

		$('.div_file_link').remove();
		$('.filename_link0').val("");
		$('.input_file_link0').val("");
		$('.div_file').remove();
		$('.filename0').val("");
		$('.input_file0').val("");
	}
	else if (option == "2")
	{
		$("#sous_type").val("0");
		$(".content").val("");
		$("#cop_content").html("");
		$("#select_input").val("1");

		$(".content").live('keyup', function(e)
		{
			var link = $(this).val();

			if ($(this).val() != "")
			{
				$("#cop_content").html('<iframe id="link_content" width="300" height="200" src="" frameborder="0" allowfullscreen></iframe>');
				$("#link_content").attr("src", link);
			}
			else
				$("#cop_content").html("");
		});

		$("#text_tr").fadeOut("fast", function()
		{
			$("#link_tr").fadeIn();
		});
		$(".cat").css('display', 'table-row');
		$(".media_type_tr").css('display', 'none');
		$(".file_tr").css('display', 'none');
		$(".file_link_tr").css('display', 'none');
		$("#select_input_tr").css('display', 'none');

		$('.div_file_link').remove();
		$('.filename_link0').val("");
		$('.input_file_link0').val("");
		$('.div_file').remove();
		$('.filename0').val("");
		$('.input_file0').val("");
	}
	else if (option == "3")
	{
		$("#sous_type").val("0");
		$(".content").val("");
		$("#cop_content").html("");
		$("#select_input").val("1");

		$("#content_text").on('keyup', function(e)
		{
			console.log($(this).val());
			if ($(this).val() != "")
				$("#cop_content").html($(this).val());
			else
				$("#cop_content").html("");
		});

		$("#link_tr").fadeOut('fast', function()
		{
			$("#text_tr").fadeIn();
		});
		$(".cat").css('display', 'table-row');
		$(".media_type_tr").css('display', 'none');
		$(".file_tr").css('display', 'none');
		$(".file_link_tr").css('display', 'none');
		$("#select_input_tr").css('display', 'none');

		$('.div_file_link').remove();
		$('.filename_link0').val("");
		$('.input_file_link0').val("");
		$('.div_file').remove();
		$('.filename0').val("");
		$('.input_file0').val("");
	}
	else if (option == "4")
	{
		var sousOption = "0";

		$(".content").val("");
		$("#cop_content").html("");
		$(".media_type_tr").css('display', 'table-row');
		$(".cat").css('display', 'none');
		$("#select_input").val("1");

		if (sousOption == "0")
		{
			$("#link_tr").css('display', 'none');
			$("#text_tr").css('display', 'none');
			$(".file_tr").css('display', 'none');
			$(".file_link_tr").css('display', 'none');
			$("#select_input_tr").css('display', 'none');
		}

		$("#sous_type").on('change', function(e)
		{
			sousOption = $(this).val();

			if (sousOption == "1")
			{
				$(".content").val("");
				$("#cop_content").html("");
				$("#select_input").val("1");

				$(".content").live('keyup', function(e)
				{
					var link = $(this).val();

					if ($(this).val() != "")
					{
						$("#cop_content").html('<strong>Mutation m&eacute;diatique</strong> <iframe id="link_content" width="300" height="200" src="" frameborder="0" allowfullscreen></iframe>');
						$("#link_content").attr("src", link);
					}
					else
						$("#cop_content").html("");
				});

				$("#text_tr").fadeOut('fast', function()
				{
					$("#link_tr").fadeIn();
				});
				$(".file_tr").css('display', 'none');
				$(".file_link_tr").css('display', 'none');
				$("#select_input_tr").css('display', 'none');

				$('.div_file_link').remove();
				$('.filename_link0').val("");
				$('.input_file_link0').val("");
				$('.div_file').remove();
				$('.filename0').val("");
				$('.input_file0').val("");
			}
			else if (sousOption == "2")
			{
				$(".content").val("");
				$("#cop_content").html("");
				$("#select_input").val("1");

				$(".content").live('keyup', function(e)
				{
					var link = $(this).val();

					if ($(this).val() != "")
					{
						$("#cop_content").html('<strong>Mutation m&eacute;diatique</strong> <iframe id="link_content" width="300" height="200" src="" frameborder="0" allowfullscreen></iframe>');
						$("#link_content").attr("src", link);
					}
					else
						$("#cop_content").html("");
				
				});

				$("#text_tr").fadeOut('fast', function()
				{
					$("#link_tr").fadeIn();
				});
				$(".file_tr").css('display', 'none');
				$(".file_link_tr").css('display', 'none');
				$("#select_input_tr").css('display', 'none');

				$('.div_file_link').remove();
				$('.filename_link0').val("");
				$('.input_file_link0').val("");
				$('.div_file').remove();
				$('.filename0').val("");
				$('.input_file0').val("");
			}
			else if (sousOption == "3")
			{
				$(".content").val("");
				$("#cop_content").html("");
				$("#select_input").val("1");

				$("#content_text").live('keyup', function(e)
				{
					if ($(this).val() != "")
						$("#cop_content").html($(this).val());
					else
						$("#cop_content").html("");
				});

				$("#link_tr").fadeOut('fast', function()
				{
					$("#text_tr").fadeIn();
				});
				$(".file_tr").css('display', 'none');
				$(".file_link_tr").css('display', 'none');
				$("#select_input_tr").css('display', 'none');

				$('.div_file_link').remove();
				$('.filename_link0').val("");
				$('.input_file_link0').val("");
				$('.div_file').remove();
				$('.filename0').val("");
				$('.input_file0').val("");

			}
			else if (sousOption == "4")
			{
				var optionInput = "1";

				$("#select_input_tr").show();
				$("#select_input").val("1");
				$(".file_tr").fadeIn();
				$(".content").val("");
				$("#cop_content").html("");

				$("#select_input").on('change', function(e)
				{
					optionInput = $(this).val();

					if (optionInput == "1")
					{
						$(".file_link_tr").fadeOut('fast', function()
						{
							$('.file_tr').fadeIn();
							$('.div_file_link').remove();
							$('.filename_link0').val("");
							$('.input_file_link0').val("");
							$('.filename_link_p').remove();
							$('.filename_link_br').remove();
							$('.filename_link_p0').remove();
						});
					}
					else if (optionInput == "2")
					{
						$(".file_tr").fadeOut('fast', function()
						{
							$('.file_link_tr').fadeIn();
							$('.div_file').remove();
							$('.filename0').val("");
							$('.input_file0').val("");
							$('.filename_p').remove();
							$('.filename_br').remove();
							$('#filename_p0').remove();
						});
					}
				});

				$("#link_tr").css('display', 'none');
				$("#text_tr").css('display', 'none');

				$('.div_file_link').remove();
				$('.filename_link0').val("");
				$('.input_file_link0').val("");
				$('.div_file').remove();
				$('.filename0').val("");
				$('.input_file0').val("");
			}
			else if (sousOption == "")
			{
				$("#text_tr").fadeOut();
				$("#link_tr").fadeOut();
				$(".file_tr").fadeOut();
				$(".file_link_tr").fadeOut();
				$("#select_input_tr").fadeOut();
				$("#select_input").val("1");
				$(".content").val("");
				$("#cop_content").html("");

				$('.div_file_link').remove();
				$('.filename_link0').val("");
				$('.input_file_link0').val("");
				$('.div_file').remove();
				$('.filename0').val("");
				$('.input_file0').val("");
			}
		});

		$('.div_file_link').remove();
		$('.filename_link0').val("");
		$('.input_file_link0').val("");
		$('.div_file').remove();
		$('.filename0').val("");
		$('.input_file0').val("");
	}
	else if (option == "5")
	{
		$("#sous_type").val("0");
		$("#select_input").val("1");
		$(".cat").css('display', 'table-row');
		$(".media_type_tr").css('display', 'none');
		$(".content").val("");

		$("#link_tr").fadeOut('fast', function()
		{
			var optionInput = "1";
			$("#select_input_tr").show();

			$("#select_input_tr").on('change', function(e)
			{
				optionInput = $(this).val();

				if (optionInput == "1")
					$(".file_tr").fadeIn();
				else if (optionInput == "2")
					$(".file_link_tr").fadeIn();
			});
		});

		$("#text_tr").fadeOut('fast', function()
		{
			var optionInput = "1";
			$("#select_input_tr").show();
			$(".file_tr").fadeIn();

			$("#select_input").on('change', function(e)
			{
				optionInput = $(this).val();

				if (optionInput == "1")
				{
					$(".file_link_tr").fadeOut('fast', function()
					{
						$('.file_tr').fadeIn();
						$('.div_file_link').remove();
						$('.filename_link0').val("");
						$('.input_file_link0').val("");
					});
				}
				else if (optionInput == "2")
				{
					$(".file_tr").fadeOut('fast', function()
					{
						$('.file_link_tr').fadeIn();
						$('.div_file').remove();
						$('.filename0').val("");
						$('.input_file0').val("");
					});
				}
			});
		});
	}
	else if (option == "")
	{
		$("#sous_type").val("0");
		$("#text_tr").fadeOut();
		$("#link_tr").fadeOut();
		$(".file_tr").fadeOut();
		$(".file_link_tr").fadeOut();
		$("#select_input_tr").fadeOut();
		$("#select_input").val("1");
		$(".media_type_tr").css('display', 'none');
		$(".cat").css('display', 'table-row');
		$(".content").val("");
		$("#cop_content").html("");

		$('.div_file_link').remove();
		$('.filename_link0').val("");
		$('.input_file_link0').val("");
		$('.div_file').remove();
		$('.filename0').val("");
		$('.input_file0').val("");
	}
});

/* -- FIN DU SCRIPT FORMULAIRE DE POST DE MEDIA -- */