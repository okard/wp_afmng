<div id="afmng_content">
<div id="afmng_header">
<?php echo $this->episode->anime_name; ?> #<?php echo $this->episode->release_id; ?>
</div>

<div id="afmng_body">

<div id="afmng_episode_edit">
<form id="dummyForm" method="post" action="">
	<input name="view" type="hidden" value="episode" />
	<input name="release_id" type="hidden" value="<?php echo $this->episode->release_id; ?>"/>
</form>
</div>

<?php if($this->is_admin): ?>
	<form id="updateEpisode" method="post" action="">
		<input name="view" type="hidden" value="episode" />
		<input name="action" type="hidden" value="episode_update" />
		<input name="release_id" type="hidden" value="<?php echo $this->episode->release_id; ?>"/>
		<input name="episode_no" type="text" value="<?php echo $this->episode->episode_no; ?>" />
		<input name="episode_title" type="text" value="<?php echo $this->episode->episode_title; ?>" />

		<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Speichern') ?>" />
	</form>
<?php else: ?>
	<table>
		<tr>
			<td>Episode Nr</td><td><?php echo $this->episode->episode_no; ?></td>
		</tr>
		<tr>
			<td>Episode Titel</td><td><?php echo $this->episode->episode_title; ?></td>
		</tr>
	</table>
<?php endif; ?>

<h2>Tasks</h2>
<?php if($this->is_admin): ?>
	<a href="#" title="Alle Tasks löschen" onclick="afmng_episode_delete_tasks(<?php echo $this->episode->release_id; ?>); return false;" >Alle Tasks löschen</a>
<?php endif; ?>

<table class="afmng_table">
	<thead>
		<tr>
			<th>Task</th>
			<th>User</th>
			<th>Status</th>
			<th>Notizen</th>
			<th></th>
		</tr>
	</thead>

	<?php foreach($this->tasks as $task): ?>
	<tr>
		<td><?php echo $task->step_name; ?></td>
		<td><?php echo $task->user; ?></td>
		<td>
			<?php if($this->is_admin): ?>
				<form>
				<select id="state_no:<?php echo $task->task_id; ?>" name="state_no">
					<?php foreach(afmngdb::$step_state as $key => $value): ?>
						<option value="<?php echo $key; ?>" <?php echo $key == $task->state_no ? 'selected' : '' ?>><?php echo $value; ?></option>
					<?php endforeach; ?>
				</select>
				</form>
			<?php else: ?>
				<?php echo afmng_db_steps_state($task->state_no); ?><
			<?php endif; ?>
		</td>
		<td>
			<?php if($this->is_admin): ?>
				<input id="description:<?php echo $task->task_id; ?>" type="text" name="description" value="<?php echo $task->description; ?>" /></td>
			<?php else: ?>
				<?php echo $task->description; ?>
			<?php endif; ?>
		<td>
			<?php if($this->is_admin): ?>
				<a href="#" title="Speichern" onclick="afmng_tasks_update(<?php echo $task->task_id; ?>);return false;"><div class="button_save"></div></a>
				<a href="#" title="Löschen" onclick="afmng_tasks_delete(<?php echo $task->task_id; ?>); return false;"><div class="button_delete"></div></a>

				<?php if($task->user): ?>
					<a href="#" title="Freigeben" onclick="afmng_tasks_free(<?php echo $task->task_id; ?>); return false;"><div class="button_free"><div></a>
				<?php endif; ?>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>

</table>

</div>
</div>