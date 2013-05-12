<div id="side_search">
	<form id="search_form" action="" method="post">
		<input type="text" name="search" id="search" placeholder="rechercher..">
		<div id="media_type">
			type : 
			<select id="type">
				<option value="0"></option>
				<?php
				foreach($list_type as $key => $option){
					echo "<option value=\"".$key."\">".str_replace("_"," ",$option)."</option>";
				}
				?>
			</select>
		</div>
		<div id="media_category">
			cat&eacute;gories : 
			<select id="category">
				<option value="0"></option>
				<?php
				foreach($list_category as $key => $option){
					echo "<option value=\"".$key."\">".str_replace("_"," ",$option)."</option>";
				}
				?>
			</select>
		</div>
		<div id="keywords">
			<div id="kw_selection"></div>
			<div id="kw_list"></div>
		</div>
		<div id="media_labels">
			<table id="table_labels">
			<?php
				foreach($list_label as $key => $value){
					echo "<tr><td><input type=\"checkbox\" name=\"labels[]\" value=\"".$key."\">".$value."</td></tr>";
				}
			?>
			</table>
		</div>
		<input id="search_button" type="button" value="go">
	</form>
	<div id="search_list_result">
		
	</div>
</div>