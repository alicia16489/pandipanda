<div id="wrap_admin_panel" style="position:absolute; bottom:70px; left:500px;">
	<div id="list_membre">
		<table>
		<tr><td>email</td><td>rank</td><td>ban</td><td>update</td></tr>
		<?php
			foreach($users['users'] as $user){
				$select = "<select name=\"rank\">";
				foreach($users['ranks'] as $row){
					if($user['users_rank_id'] == $row['id']){
						$rank = "selected";
					}
				}
				echo "<tr><form method=\"post\" action=\"index.php?action=admin_panel&amp;sub=update&amp;uid=".$user['id']."\"><td>".$user['email']."</td><td>".$rank."</td><td><input type=\"checkbox\"></td><td></td></form></tr>";
			}
		?>
		</table>
	</div>
	
</div>