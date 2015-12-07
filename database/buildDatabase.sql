.mode columns
.headers on
.nullvalue NULL
PRAGMA foreign_keys = ON;

drop table if exists Account;
drop table if exists Starred;
drop table if exists Playlist;
drop table if exists Song;
drop table if exists PlaylistContainsSong;
drop table if exists Tags;
drop table if exists PlaylistTags;
drop table if exists SongTags;

create table Account (
  username TEXT PRIMARY KEY,
  email TEXT NOT NULL,
  passwordHash TEXT NOT NULL,
  private BOOLEAN 
);


create table Song (
  title TEXT,
  artist TEXT,
  uploader TEXT,
  location TEXT NOT NULL,
  uploadTimeStamp TEXT NOT NULL,
  PRIMARY KEY(title, artist, uploader),
  FOREIGN KEY (uploader) REFERENCES Account(username)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

create table Playlist (
  playlistName TEXT,
  owner TEXT,
  PRIMARY KEY(playlistName, owner),
  FOREIGN KEY (owner) REFERENCES Account(username)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

create table PlaylistContainsSong (
  title TEXT,
  artist TEXT,
  songUploader TEXT,
  playlistName TEXT,
  playlistOwner TEXT,
  track_no INTEGER NOT NULL,
  PRIMARY KEY(title, artist, songUploader, playlistName, playlistOwner),
  FOREIGN KEY (title, artist, songUploader) REFERENCES Song(title, artist, uploader)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (playlistName, playlistOwner) REFERENCES Playlist(playlistName, owner)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

create table Tags (
  tagName TEXT PRIMARY KEY
);

create table PlaylistTags (
  playlistName TEXT,
  owner TEXT,
  tagName NOT NULL,
  PRIMARY KEY(playlistName, owner, tagName),
  FOREIGN KEY (playlistName, owner) REFERENCES Playlist(playlistName, owner)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (tagName) REFERENCES Tags(tagName)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

create table SongTags (
  title TEXT,
  artist TEXT,
  uploader TEXT,
  tagName TEXT,
  PRIMARY KEY(title, artist, uploader, tagName),
  FOREIGN KEY (title, artist, uploader) REFERENCES Song(title, artist, uploader)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY (tagName) REFERENCES Tags(tagName)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

create table Starred (
  title TEXT,
  artist TEXT,
  songUploader TEXT,
  starringUsername TEXT,
  PRIMARY KEY(title, artist, songUploader, starringUsername),
  FOREIGN KEY(title, artist, songUploader) REFERENCES Song(title, artist, uploader)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
  FOREIGN KEY(starringUsername) REFERENCES Account(username)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

insert into Account values("krokky", "krokky@krokky.com", "$2a$08$9gc/aJ7t.IdvAowL52903eyrpSaP9WToPP1yzyV5iZI0hz8uCvE7O", "true");
