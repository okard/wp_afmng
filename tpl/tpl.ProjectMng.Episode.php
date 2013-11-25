<div id="afmng_body">


<h1><?php echo $this->episode->anime_name; ?></h1>


<form id="updateEpisode" method="post" action="">
	<input name="view" type="hidden" value="view" />
	<input name="action" type="hidden" value="episode_update" />
	<input name="release_id" type="hidden" value="<?php echo $this->episode->release_id; ?>"/>
	<input name="episode_no" type="text" value="<?php echo $this->episode->episode_no; ?>" />
	<input name="episode_title" type="text" value="<?php echo $this->episode->episode_title; ?>" />
	
	<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Speichern') ?>" />
</form>

<h2>Tasks</h2>

</div>
