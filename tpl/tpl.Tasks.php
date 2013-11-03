<div id="afmng_body">
<h1>Anime Fansub Manager</h1>

<div id="task_current">

<h2>Meine aktuellen Aufgaben (<?php echo $this->user; ?>)</h2>

<table>
	<thead>
		<tr>
		<th>Anime</th>
		<th>Episode</th>
		<th>Aufgabe</th>
		<th>Status</th>
		<th>Notizen</th>
		<th></th>
		</tr>
	</thead>
	
	
	<?php foreach($this->tasks as $task): ?>
	<tr>
		<td><?php echo $task->anime_name; ?></td>
		<td><?php echo $task->episode_no, ' / ', $task->episode_title; ?></td>
		<td><?php echo $task->name; ?></td>
		<td>
			<form>
			<select name="state_no">
				<?php foreach(afmngdb::$step_state as $key => $value): ?>
					<option value="<?php echo $key; ?>" <?php echo $key == $task->state_no ? 'selected' : '' ?>><?php echo $value; ?></option>
				<?php endforeach; ?>
			</select>
			</form>
		</td>
		<td><?php echo $task->description; ?></td>
		<td>Speichern</td>
	</tr>
	<?php endforeach; ?>
</table>
</div>

<!-- Hidden Form -->

<div id="task_available">
			
<h2>Verfügbare Aufgaben</h2>
<!-- available releases and follow releases when the step before is done -->

<!-- if admin add option to add any tasks -->

<table>
	<thead>
		<tr>
			<th>Anime</th>
			<th>Episode</th>
			<th>Step</th>
			<th><!--Actions--></th>
		</tr>
	</thead>
	
	<?php foreach($this->tasks_available as $task): ?>
		<tr>
			<td><?php echo $task->anime_name; ?></td>
			<td><?php echo $task->episode_no, ' / ', $task->episode_title; ?></td>
			<td><?php echo $task->name; ?></td>
			<td>Annehmen Löschen</td>
		</tr>
	<?php endforeach; ?>
	

</table>
</div>

<div id="task_done">

<h2>Abgeschlossene Aufgaben</h2>
</div>

<div id="task_random">
<?php if($this->is_admin): ?>
	<h2>Beliebige Aufgabe hinzufügen</h2>
	
	<form id="admin_task_add" method="post" action="">
	<input type="hidden" name="action" value="admin_task_add" />
	<table>
		<thead>
			<tr>
				<th>Anime</th>
				<th>Episode</th>
				<th>Step</th>
				<th>Benutzer</th>
			</tr>
		</thead>
		<tr>
			<td>
				<select id="cmb_anime" name="anime">
					<?php foreach(afmng_db_project_list() as $project): ?>
						<option value="<?php echo $project->project_id; ?>"><?php echo $project->anime_name; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td><select id="cmb_episode" name="episode"></select></td>
			<td>
				<select id="cmb_step" name="step">
					<?php foreach(afmng_db_steps() as $step): ?>
						<option value="<?php echo $step->step_id; ?>"><?php echo $step->name; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
			<td>
				<select id="cmb_user" name="user">
					<option></option>
					<?php foreach(get_users() as $user): ?>
						<option><?php echo $user->user_login; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
	</table>
	
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Hinzufügen') ?>" />
	
	</form>
<?php endif; ?>
</div>
</div>