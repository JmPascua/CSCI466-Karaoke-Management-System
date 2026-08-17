DROP TABLE Queue;
DROP TABLE Feature;
DROP TABLE Singer;
DROP TABLE Song;
DROP TABLE Contributor;

CREATE TABLE Singer
(
	Singer_id INT NOT NULL,
	SingerName CHAR(255) NOT NULL,
	PRIMARY KEY (Singer_id)
);

CREATE TABLE Song 
(
	Song_id INT NOT NULL,
	Title  CHAR(255) NOT NULL,
	Version CHAR(255) NOT NULL,
	Artist CHAR(255) NOT NULL,
	File CHAR(255) NOT NULL,
	PRIMARY KEY (Song_id)
);

CREATE TABLE Contributor
(
	Contributor_id INT NOT NULL,
	ContributorName CHAR(255) NOT NULL,
	PRIMARY KEY (Contributor_id)
);

CREATE TABLE Queue
(
	Singer_id INT NOT NULL,
	Song_id INT NOT NULL,
	Money INT DEFAULT NULL,

	PRIMARY KEY(Singer_id, Song_id),
    FOREIGN KEY(Singer_id) REFERENCES Singer(Singer_id),
    FOREIGN KEY(Song_id) REFERENCES Song(Song_id)
);

CREATE TABLE Feature
(
	Song_id INT NOT NULL,
	Contributor_id INT NOT NULL,
	Role CHAR(255) NOT NULL,

	PRIMARY KEY(Song_id, Contributor_id),
    FOREIGN KEY(Song_id) REFERENCES Song(Song_id),
	FOREIGN KEY(Contributor_id) REFERENCES Contributor(Contributor_id)
);
