<div id="afmng_body">

<form id="dummyForm" method="post" action="">
	<input name="view" type="hidden" value="view" />
	<input name="release_id" type="hidden" value="<?php echo $this->episode->release_id; ?>"/>
</form>


<h1><?php echo $this->episode->anime_name; ?></h1>

<?php if($this->is_admin): ?>
	<form id="updateEpisode" method="post" action="">
		<input name="view" type="hidden" value="view" />
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
		<td><?php echo afmng_db_steps_state($task->state_no); ?></td>
		<td><?php echo $task->description; ?></td>
		<td>
			<?php if($this->is_admin): ?>
				<a href="#" title="Speichern" onclick="return false;">Speichern</a>
				<a href="#" title="Löschen" onclick="return false;">Löschen</a>
				<a href="#" title="Freigeben" onclick="return false;">Freigeben</a>
			<?php endif; ?>
		</td>
	</tr>
	<?php endforeach; ?>

</table>

</div>
