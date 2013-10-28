
<h1>Anime Fansub Manager</h1>

<h2>Meine aktuellen Aufgaben (<?php echo $this->user; ?>)</h2>

<table>
	<thead>
		<tr>
		<th>Anime</th>
		<th>Episode</th>
		<th>Aufgabe</th>
		<th>Status</th>
		<th></th>
		</tr>
	</thead>
	
	
	<?php foreach($this->tasks as $task): ?>
	<tr>
		<td><?php echo $task->anime_name; ?></td>
		<td><?php echo $task->episode_no.' / '.$task->episode_title; ?></td>
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
		<td>Speichern</td>
	</tr>
	<?php endforeach; ?>
</table>

<!-- Hidden Form -->
			

<h2>Verfügbare Aufgaben</h2>


<h2>Abgeschlossene Aufgaben</h2>

