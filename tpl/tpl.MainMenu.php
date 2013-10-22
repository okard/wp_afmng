
<h1>Anime Fansub Manager</h1>

<h2>Meine aktuellen Tasks</h2>
<form name="form1" method="post" action="">
	
	<table>
		<thead>
			<th>id</th>
			<th>Anime Name</th>
			<th>Beschreibung</th>
		</thead>
	</table>
</form>

<h2>Offene Tasks</h2>


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

