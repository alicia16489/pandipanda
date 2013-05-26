<div class="content_main">
	<span class="content_main_title">PUBLIER UN CONTENU</span>
	<div id="form_post">
		<form method="post" action="?action=post_content" enctype="multipart/form-data">
			<table>
				<tr>
					<td>
						<label for="title">Titre</label>
					</td>
					<td>
						<input type="text" name="title" id="title" size="45" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="chapter">Chapitre n°</label>
					</td>
					<td>
						<input type="text" name="chapter" id="chapter" size="1" />
						<label for="chap_title">Titre du chapitre</label>
						<input type="text" name="chap_title" id="chap_title" />
					</td>
				</tr>
				<tr>
					<td>
						<label for="cop_post_type">Type</label>
					</td>
					<td>
						<select name="media_type_id" id="cop_post_type">
							<option></option>
							<option value="1">Vid&eacute;o</option>
							<option value="2">Musique</option>
							<option value="3">Fan fiction</option>
							<option value="4">Mutation m&eacute;diatique</option>
							<option value="5">Artwork</option>
						</select>
					</td>
				</tr>
				<tr class="media_type_tr">
					<td>
						<label for="sous_type">Sous-type</label>
					</td>
					<td>
						<select name="media_sous_type_id" id="sous_type">
							<option></option>
							<option value="1">Vid&eacute;o</option>
							<option value="2">Musique</option>
							<option value="3">Fan fiction</option>
							<option value="4">Artwork</option>
						</select>
					</td>
				</tr>
				<tr class="cat">
					<td>
						<label for="cop_post_category">Cat&eacute;gorie</label>
					</td>
					<td>
						<select name="categorie_id" id="cop_post_category">
							<option selected></option>
							<option value="1">Horreur</option>
							<option value="2">Drame</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						<label for="resum">R&eacute;sum&eacute;</label>
					</td>
					<td>
						<textarea name="resum" id="resum" style="resize:none" cols="33"></textarea>
					</td>
				</tr>
				<tr>
					<td>
						<label for="keywords">Mots cl&eacute;s</label>
					</td>
					<td>
						<input type="text" name="keywords" id="keywords" placeholder="Ex: eric magoni,wilnhem,henry bosco" size="45" />
					</td>
				</tr>
				<tr id="text_tr">
					<td>
						<label for="content_text">Histoire</label>
					</td>
					<td>
						<textarea name="fan_fiction" class="content" id="content_text" cols="33" rows="15"></textarea>
					</td>
				</tr>
				<tr id="link_tr">
					<td>
						<label for="content_link">Lien (youtube uniquement)</label>
					</td>
					<td>
						<input type="text" name="link" class="content" id="content_link" size="45" placeholder="Ex: http://youtube.com/embed/Z5Cw12ylMd8" />
					</td>
				</tr>
				<tr id="select_input_tr">
				<td>

				</td>
				<td>
					<select name="select_input_file" id="select_input">
						<option value="1">Fichiers</option>
						<option value="2">Liens</option>
					</select>
				</td>
				</tr>
				<tr class="file_link_tr">
					<td>
						<label for="file_link0">Lien</label>
					</td>
					<td id="input_file_link">
						<input type="text" name="file_link[]" id="input_file_link0" class="input_file_link0"  size="45" placeholder="Lien complet de votre artwork" />
						<input type="text" name="filename_link[]" id="filename_link0" class="filename_link0" size="45" placeholder="Nom de l'artwork" />
						<a href="javascript:void(0)" id="add_link_file">Ajouter fichiers</a>
					</td>
				</tr>
				<tr class="file_tr">
					<td>
						<label for="file0">Fichier</label>
					</td>
					<td id="input_file">
						<input type="file" name="file[]" id="input_file0" class="input_file0" />
						<input type="text" name="filename[]" id="filename0" class="filename0" placeholder="Nom du fichier" size="45" />
						<a href="javascript:void(0)" id="add_file">Ajouter fichiers</a>
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" value="POSTER" name="final" />
					</td>
					<td>
						<input type="reset" value="EFFACER" id="reset" />
					</td>
				</tr>
			</table>
		</form>
	</div>

	<div id="cop_form_post">
		<table>
			<tr>
				<td class="cop_title">
					Titre
				</td>
				<td class="cop_content_bold">
					<span id="cop_title"></span>
				</td>
			</tr>
			<tr>
				<td class="cop_title">
					Chapitre
				</td>
				<td class="cop_content">
					<span id="cop_chap_title"></span>
				</td>
			</tr>
			<tr>
				<td class="cop_title">
					Type
				</td>
				<td class="cop_content">
					<span id="cop_type"></span>
				</td>
			</tr>
			<tr class="media_type_tr">
				<td class="cop_title">
					Sous-type
				</td>
				<td class="cop_content">
					<span id="cop_sous_type"></span>
				</td>
			</tr>
			<tr class="cat">
				<td class="cop_title">
					Catégorie
				</td>
				<td class="cop_content">
					<span id="cop_category"></span>
				</td>
			</tr>
			<tr>
				<td class="cop_title">
					R&eacute;sum&eacute;
				</td>
				<td class="cop_content">
					<span id="cop_resum"></span>
				</td>
			</tr>
			<tr>
				<td class="cop_title">
					Mots-cl&eacute;s
				</td>
				<td class="cop_content">
					<span id="cop_keywords"></span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<span id="cop_content"></span>
				</td>
			</tr>
		</table>
	</div>

	<link rel="stylesheet" href="styles/redactor.css" />
	<script src="js/redactor.min.js"></script>

</div>