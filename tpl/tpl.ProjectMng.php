
<h1>Project Manager</h1>


<pre>
<?php //print_r($this->project_list); ?>
</pre>

<?php foreach($this->project_list as $project): ?>
	<h1><?php echo $project->anime_name; ?></h1>
	
	<p>Releases:</p>
	
	<table>
	<?php foreach(afmng_db_project_releases( $project->project_id) as $release): ?>
		<tr>
			<td><?php echo $release->episode_no; ?></td>
			<td><?php echo $release->episode_title; ?></td>
			<td>
				<table>
				<?php foreach(afmng_db_release_steps($release->release_id) as $step): ?>
					<tr>
						<td><?php echo $step->step_name; ?></td>
						<td><?php echo $step->user; ?></td>
						<td><?php echo afmng_db_steps_state($step->state_no); ?></td>
						<td><?php echo $step->description; ?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			</td>
		</tr>
	
	<?php endforeach; ?>
	</table>

<?php endforeach; ?>


