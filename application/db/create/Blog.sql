CREATE TABLE BlogPost (
  id INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INTEGER UNSIGNED NOT NULL,
  postType INTEGER UNSIGNED NOT NULL DEFAULT 0,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  createdAt DATETIME NOT NULL,
  publishedAt DATETIME NULL,
  tags VARCHAR(255) NULL,
  url VARCHAR(255) NULL,
  text LONGTEXT,
  PRIMARY KEY(id),
  INDEX BlogPost_FKIndex1(userId, publishedAt)
)
TYPE=InnoDB;

CREATE TABLE BlogAttachment (
  id INTEGER(11) NOT NULL AUTO_INCREMENT,
  postId INTEGER(11) UNSIGNED NOT NULL,
  fileId INTEGER(11) UNSIGNED NOT NULL,
  PRIMARY KEY(id),
  INDEX BlogAttachment_FKIndex1(postId),
  FOREIGN KEY(postId)
    REFERENCES BlogPost(id)
      ON DELETE CASCADE
      ON UPDATE NO ACTION
)
TYPE=InnoDB;

CREATE TABLE BlogTags (
  id INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  tag VARCHAR(64) NOT NULL,
  tagType INTEGER UNSIGNED NOT NULL DEFAULT 0,
  parentTag INTEGER(11) UNSIGNED NULL,
  PRIMARY KEY(id),
  INDEX BlogPost_FKIndex1(tag)
)
TYPE=InnoDB;

CREATE TABLE BlogPostTag (
  postId INTEGER(11) UNSIGNED NOT NULL,
  tagId INTEGER(11) UNSIGNED NOT NULL,
  PRIMARY KEY(postId, tagId)
)
TYPE=InnoDB;
