<div id="afmng_body">

<h1>Project Manager</h1>

<?php foreach($this->project_list as $project): ?>
	<div class="project_box">
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
		<?php $steps = afmng_db_release_steps($release->release_id) ?>
		<tr>
			<td><?php echo $release->episode_no; ?></td>
			<td><?php echo $release->episode_title; ?></td>
			<td>
				<table>
					<thead>
						<tr>
						<?php foreach($steps as $step): ?>
							<th><?php echo $step->step_name; ?></th>
						<?php endforeach; ?>
						</tr>
					</thead>
					<tr>
					<?php foreach($steps as $step): ?>
						<td><span class="status_<?php echo afmng_db_steps_state($step->state_no); ?>"><?php echo empty($step->user) ? '(Offen)' : $step->user; ?></span></td>
					<?php endforeach; ?>
					</tr>
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

<div id="project_add">
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
</div>
</div>
