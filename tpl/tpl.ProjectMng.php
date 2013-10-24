
<h1>Project Manager</h1>


<pre>
<?php //print_r($this->project_list); ?>
</pre>

<?php foreach($this->project_list as $project): ?>
	<h1><?php echo $project['anime_name']; ?></h1>
	
	<p>Releases:</p>
	
	<table>
	<?php foreach($project['__data'] as $releases): ?>
		<tr>
			<td><?php echo $releases['episode_no']; ?></td>
			<td><?php echo $releases['episode_title']; ?></td>
			
			<td>
				<table>
				<?php foreach($releases['__data'] as $step): ?>
					<tr>
						<td><?php echo $step['step_name'];  ?></td>
					</tr>
				<?php endforeach; ?>
				</table>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>

<?php endforeach; ?>


