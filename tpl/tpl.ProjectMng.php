<div id="afmng_content">

<div id="afmng_header">
Projekt Manager
</div>

<div id="afmng_body">
<form id="dummyForm" method="post" action="">
</form>

<?php foreach($this->project_list as $project): ?>
	<div class="project_box">
	<div class="project_box_title"><?php echo $project->anime_name; ?>
	
	<?php if($this->is_admin): ?>
	<a href="#" title="Einstellungen" onclick="jQuery('#frmMngProject\\:<?php echo $project->project_id; ?>').toggle('slow'); return false;"><div class="button_settings"></div></a>
	<a href="#" title="Release Hinzufügen" onclick="jQuery('#frmAddRelease\\:<?php echo $project->project_id; ?>').toggle('slow'); return false;"><div class="button_add"></div></a>
	<?php endif; ?>
	</div>

	<?php if($this->is_admin): ?>
	
	<form id="frmMngProject:<?php echo $project->project_id; ?>" method="post" action="" style="display:none">
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
				<td><input name="completed" type="checkbox" /></td>
				<td><input name="licensed" type="checkbox" /></td>
				<td><input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Speichern') ?>" /></td>
				<td><input type="button" name="Delete" class="button-primary" value="Löschen" onclick="afmng_project_delete(<?php echo $project->project_id; ?>);" /></td>
			</tr>
		</table>
	</form>
	<?php endif; ?>



	<table class="afmng_table">
		<thead>
			<tr>
			<th>#</th>
			<th>Titel</th>
			<th>Status</th>
			</tr>
		</thead>
	<?php foreach(afmng_db_project_releases( $project->project_id) as $release): ?>
		<?php $steps = afmng_db_release_steps($release->release_id) ?>
		<tr>
			<td>
				<a href="#" title="Episode anzeigen" onclick="afmng_episode_show(<?php echo $release->release_id; ?>); return false;">
				<?php echo $release->episode_no; ?>
				</a>
			</td>
			<td>
				<?php echo $release->episode_title; ?>
				<?php if($this->is_admin): ?>
				<a href="#" title="Löschen incl. Tasks" onclick="afmng_release_delete(<?php echo $release->release_id; ?>, true);return false;"><div class="button_delete"></div></a>
				<?php endif; ?>
			</td>
			<td style="margin:0; padding:0;">
				<table class="afmng_subtable">
					<thead>
						<tr>
						<?php foreach($steps as $step): ?>
							<th class="step_<?php echo $step->step_id; ?>"><?php echo $step->step_name; ?></th>
						<?php endforeach; ?>
						</tr>
					</thead>
					<tr>
					<?php foreach($steps as $step): ?>
						<td class="status_<?php echo $step->state_no; ?>">
							<?php if($step->step_name == 'Raw'): ?>
								<?php echo $step->description; ?>
							<?php else: ?>
								<?php echo empty($step->user) ? '(Offen)' : $step->user; ?>
								<?php if(!empty($step->description)): ?>
								<a href="#" onclick='return false;' title="<?php echo $step->description; ?>"><div class="button_notes"></div></a>
								<?php endif; ?>
							<?php endif; ?>
						</td>
					<?php endforeach; ?>
					</tr>
				</table>
			</td>
		</tr>

	<?php endforeach; ?>
	</table>

<br>
	<?php if($this->is_admin): ?>

	<form id="frmAddRelease:<?php echo $project->project_id; ?>" method="post" action="" style="display:none">
		<input type="hidden" name="action" value="add_release" />
		<input type="hidden" name="project_id" value="<?php echo $project->project_id; ?>" />

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
	<?php endif; ?>

	</div>
<?php endforeach; ?>

<?php if($this->is_admin): ?>
<div id="project_add">
<div id="project_add_header">Projekt Hinzufügen</div>
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
<?php endif; ?>

<?php if($this->is_admin): ?>
	<div id="project_done_header">Abgeschlossene Animes</div>
	<table class="afmng_table">
		<thead>
			<tr>
				<th>Anime</th>
				<th>Lizensiert</th>
				<th>Komplett</th>
				<th></th>
			</tr>
		</thead>
		<?php foreach($this->projects_closed as $project): ?>
			<tr>
				<td><?php echo $project->anime_name; ?></td>
				<td><?php echo $project->licensed; ?></td>
				<td><?php echo $project->completed; ?></td>
				<td>
					<a href="#" title="Status zurücksetzen" onclick="afmng_project_clear_status(<?php echo $project->project_id; ?>); return false;">Status zurücksetzen</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
<?php endif; ?>


</div>
</div>