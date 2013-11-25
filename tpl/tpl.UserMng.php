<div id="afmng_body">
<h1>User Manager</h1>

<table class="afmng_table">
	<thead>
		<tr>
			<th>User</th>
			<?php foreach($this->caps as $cap): ?>
				<th><?php echo $cap; ?></th>
			<?php endforeach; ?>
		</tr>
	</thead>
	
	<?php foreach($this->users as $user): ?>
		<tr>
			<td><?php echo $user->user_login; ?></td>
			<?php foreach($this->caps as $cap): ?>
				<td><?php echo afmng_user_cap($cap) ? 'y' : 'n'; ?></td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
	
</table>

</div>
