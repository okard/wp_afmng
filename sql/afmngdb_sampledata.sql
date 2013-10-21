


INSERT INTO afmng_projects(creation_date, anime_name, anime_description)
VALUES (NOW(), 'Anime 1', 'Anime Desc');
INSERT INTO afmng_projects(creation_date, anime_name, anime_description)
VALUES (NOW(), 'Anime 2', 'Anime Desc');
INSERT INTO afmng_projects(creation_date, anime_name, anime_description)
VALUES (NOW(), 'Anime 3', 'Anime Desc');
INSERT INTO afmng_projects(creation_date, anime_name, anime_description)
VALUES (NOW(), 'Anime 4', 'Anime Desc');



INSERT INTO afmng_releases(project_id, creation_date, translation_status)
SELECT p.project_id, NOW(), 100
FROM afmng_projects as p
WHERE p.anime_name = 'Anime 1';

INSERT INTO afmng_releases(project_id, creation_date, translation_status)
SELECT p.project_id, NOW(), 33
FROM afmng_projects as p
WHERE p.anime_name = 'Anime 1';
