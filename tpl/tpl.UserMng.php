<div id="afmng_body">
<h1>User Manager</h1>

<form id="update_user_caps" method="post" action="">
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
					<td>
						<input type="checkbox" name="<?php echo $cap; ?>:<?php echo $user->ID; ?>" <?php echo afmng_user_cap($cap, $user->ID) ? 'checked' : ''; ?>>
					</td>
				<?php endforeach; ?>
			</tr>
		<?php endforeach; ?>
		
	</table>
	
	<input type="hidden" name="action" value="update_user" />
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Speichern') ?>" />
	
</form>

</div>
