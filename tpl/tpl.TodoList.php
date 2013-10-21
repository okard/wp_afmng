

<h1>Todo List</h1>


<table>
	<?php foreach($this->lastreleases as $r): ?>
	<tr>
		<td><?php echo $r->project_id; ?></td>
		<td><?php echo $r->anime_name; ?></td>
		<td><?php echo $r->release_id; ?></td>
		<td><?php echo $r->creation_date; ?></td>
		<td><?php echo $r->translation_status; ?></td>
		
	</tr>
	<?php endforeach; ?>
</table>
