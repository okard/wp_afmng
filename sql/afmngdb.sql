CREATE TABLE afmng_projects (
	project_id mediumint(9) NOT NULL AUTO_INCREMENT,
	creation_date datetime NULL,
	anime_name tinytext NOT NULL,
	anime_description text NULL,
	url VARCHAR(100) DEFAULT '' NULL,
	visible BOOLEAN default 1 NOT NULL,
	PRIMARY KEY  (project_id)
);

CREATE TABLE afmng_releases (
release_id mediumint(9) NOT NULL AUTO_INCREMENT,
project_id mediumint(9) NOT NULL,
episode tinytext NOT NULL,
creation_date datetime NULL,
translation_status TINYINT UNSIGNED DEFAULT 0 NOT NULL,
PRIMARY KEY  (release_id),
FOREIGN KEY (project_id) REFERENCES afmng_projects (project_id)
);
			
