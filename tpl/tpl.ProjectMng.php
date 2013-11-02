
<h1>Project Manager</h1>


<?php foreach($this->project_list as $project): ?>
	<div class="project_box" style="border:1px solid black">
	<h1><?php echo $project->anime_name; ?></h1>
	
	<p>Releases:</p>
	
	<table>
		<thead>
			<tr>
			<th>Episode</th>
			<th>Titel</th>
			</tr>
		</thead>
	<?php foreach(afmng_db_project_releases( $project->project_id) as $release): ?>
		<tr>
			<td><?php echo $release->episode_no; ?></td>
			<td><?php echo $release->episode_title; ?></td>
			<td>
				<table>
					<thead>
						<tr>
						<th>Schritt</th>
						<th>Benutzer</th>
						<th>Status</th>
						<th>Beschreibung</th>
						</tr>
					</thead>
				<?php foreach(afmng_db_release_steps($release->release_id) as $step): ?>
					<tr>
						<td><?php echo $step->step_name; ?></td>
						<td><?php echo $step->user; ?></td>
						<td><?php echo afmng_db_steps_state($step->state_no); ?></td>
						<td><?php echo $step->description; ?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			</td>
		</tr>
	
	<?php endforeach; ?>
	</table>
	
	<form id="frmAddRelease" method="post" action="">
		<input type="hidden" name="action" value="add_release" />
		<input type="hidden" name="project_id" value="<?php echo $project->project_id; ?>" />
		
		<h3>Release hinzufügen</h3>
		
		<table>
			<thead>
				<tr>
				<th><label for="episode_no">Episoden Nr.</label></th>
				<th><label for="episode_title">Episoden Titel</label></th>
				</tr>
			</thead>
			<tr>
				<td><input name="episode_no" type="text" /></td>
				<td><input name="episode_title" type="text" /></td>
				<td><input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Hinzufügen') ?>" /></td>
			</tr>
		
		</table>
	</form>
	
	
	<h2>Projekt Management</h2>
	<form id="frmMngProject" method="post" action="">
		<input type="hidden" name="action" value="update_project" />
		<input type="hidden" name="project_id" value="<?php echo $project->project_id; ?>" />
		<table>
			<thead>
				<tr>
				<th><label for="anime_name">Anime-Name</label></th>
				<th><label for="completed">Abgeschlossen</label></th>
				<th><label for="licensed">Lizensiert</label></th>
				<th></th>
				</tr>
			</thead>
			<tr>
				<td><input name="anime_name" type="text" value="<?php echo $project->anime_name; ?>" /></td>
				<td><input type="checkbox" name="completed" /></td>
				<td><input type="checkbox" name="licensed" /></td>
				<td><input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Speichern') ?>" /></td>
			</tr>
		</table>
	</form>
	</div>
<?php endforeach; ?>

<h2>Projekt hinzufügen</h2>	
<form id="frmAddProject" method="post" action="">
	<input type="hidden" name="action" value="add_project" />

	<table>
		<thead>
			<td>Anime-Name</td>
		</thead>
		<tr>
			<td><input name="anime_name" type="text" /></td>
			<td><input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Anlegen') ?>" /></td>
		</tr>
	</table>
</form>


