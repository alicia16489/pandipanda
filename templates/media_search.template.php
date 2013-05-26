<div id="side_search">
	<form id="search_form" action="" method="post">
		<input type="text" name="search" id="search" placeholder="Rechercher...">
		<div id="media_type"> 
			<select id="post_type" class="input_select">
				<option value="0">--Type--</option>
				<?php
					foreach($list_type as $key => $option)
						{
							echo "<option value=\"".$key."\">".str_replace("_"," ",$option)."</option>";
						}
				?>
			</select>
		</div>
		<div id="media_category">
			<select id="post_category" class="input_select">
				<option value="0">--Catégorie--</option>
				<?php
					foreach($list_category as $key => $option)
						{
							echo "<option value=\"".$key."\">".str_replace("_"," ",$option)."</option>";
						}
				?>
			</select>
		</div>
		<div id="media_labels">
			<span>Labels</span>
			<table id="table_labels">
			<?php
				foreach($list_label as $key => $value)
					{
						echo "<tr><td><input class=\"input_checkbox\" type=\"checkbox\" name=\"labels[]\" value=\"".$key."\">".ucfirst($value)."</td></tr>";
					}
			?>
			</table>
		</div>
		<input id="search_button" type="button" value="Rechercher">
	</form>
	<div id="search_list_result">
		
	</div>
</div>