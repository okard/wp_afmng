CREATE TABLE wp_afmng_projects (
				project_id mediumint(9) NOT NULL AUTO_INCREMENT,
				anime_name tinytext NOT NULL,
				completed BOOLEAN default 0 NOT NULL,
				licensed BOOLEAN default 0 NOT NULL,
				PRIMARY KEY  (project_id)
				);
				CREATE TABLE wp_afmng_releases (
				release_id mediumint(9) NOT NULL AUTO_INCREMENT,
				project_id mediumint(9) NOT NULL,
				episode_no tinytext NOT NULL,
				episode_title text NULL,
				PRIMARY KEY  (release_id),
				FOREIGN KEY (project_id) REFERENCES wp_afmng_projects (project_id)
				);
				CREATE TABLE wp_afmng_release_steps (
				step_id mediumint(9) NOT NULL AUTO_INCREMENT,
				prev_step_id mediumint(9) NULL,
				name tinytext NOT NULL,
				description mediumtext NULL,
				PRIMARY KEY  (step_id)
				);
				CREATE TABLE wp_afmng_release_steps_map (
				release_id mediumint(9) NOT NULL,
				step_id mediumint(9) NOT NULL,
				user tinytext NULL,
				state_no tinyint(1) DEFAULT 0 NOT NULL,
				description mediumtext NULL,
				FOREIGN KEY (release_id) REFERENCES wp_afmng_releases (release_id),
				FOREIGN KEY (step_id) REFERENCES wp_afmng_release_steps (step_id)
				);
				