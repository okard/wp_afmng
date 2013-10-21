
<h1>Main Menu</h1>

<?php echo get_edit_post_link(); ?> 


<form name="form1" method="post" action="">
	
	<table>
		<thead>
			<th>id</th>
			<th>Anime Name</th>
			<th>Beschreibung</th>
		</thead>
		<?php foreach($this->projects as $p): ?>
		<tr>
			<td><?php echo $p->project_id; ?></td>
			<td><?php echo $p->anime_name; ?></td>
			<td><?php echo $p->anime_description; ?></td>
			<td><?php echo $p->creation_date; ?></td>
			<td><?php echo afmng_editlink_bypagetitle($p->anime_name) ?></td>
		</tr>
		<?php endforeach; ?>
	</table>

	<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
	</p>
</form>


<?php if($this->is_admin): ?>

<div>
	<h2>Admin Panel</h2>
	Add Releases
</div>
		
<h3>Add Anime</h3>
<form name="form1" method="post" action="">
	<input type="hidden" name="action" value="create_anime">
	
	<label for="anime_name">Anime Name:</label>
	<input type="text" name="anime_name">
	
	<label for="anime_description">Beschreibung:</label>
	<input type="text" name="anime_description">
	
	<p class="submit">
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Add') ?>" />
	</p>
</form>
<?php endif; ?>

