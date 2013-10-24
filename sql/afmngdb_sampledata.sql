

DELETE FROM wp_afmng_release_steps_map;
DELETE FROM wp_afmng_releases;
DELETE FROM wp_afmng_projects;

-- Projects
INSERT INTO wp_afmng_projects(anime_name, completed, licensed)
VALUES ( "Anime 1", 0, 0);
INSERT INTO wp_afmng_projects(anime_name, completed, licensed)
VALUES ( "Anime 2", 0, 0);


-- Releases
INSERT INTO wp_afmng_releases(project_id, episode_no, episode_title)
SELECT p.project_id, '1', 'Episode 1'
FROM wp_afmng_projects as p WHERE p.anime_name='Anime 1';

INSERT INTO wp_afmng_releases(project_id, episode_no, episode_title)
SELECT p.project_id, '2', 'Episode 2'
FROM wp_afmng_projects as p WHERE p.anime_name='Anime 1';

-- Release Steps
INSERT INTO wp_afmng_release_steps_map(release_id, step_id, user, state_no, description)
SELECT r.release_id, 1, 'admin', 3, 'Test'
FROM wp_afmng_releases as r
INNER JOIN wp_afmng_projects as p
	ON r.project_id = p.project_id
WHERE p.anime_name = 'Anime 1'
  AND r.episode_no = '1';

INSERT INTO wp_afmng_release_steps_map(release_id, step_id, user, state_no, description)
SELECT r.release_id, 2, 'admin', 3, 'Test'
FROM wp_afmng_releases as r
INNER JOIN wp_afmng_projects as p
	ON r.project_id = p.project_id
WHERE p.anime_name = 'Anime 1'
  AND r.episode_no = '1';
