-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2018-03-08 16:25:06.287

-- tables
-- Table: Calendar_Share_Access
CREATE TABLE Calendar_Share_Access (
    id int NOT NULL,
    Users_username varchar(50) NOT NULL,
    share_with varchar(50) NOT NULL,
    CONSTRAINT Calendar_Share_Access_pk PRIMARY KEY (id)
);

-- Table: Events
CREATE TABLE Events (
    id int NOT NULL AUTO_INCREMENT,
    Title varchar(50) NOT NULL,
    time time NOT NULL,
    category enum('work','study','entertainment','others') NOT NULL,
    Users_username varchar(50) NULL,
    Groups_id int NOT NULL,
    CONSTRAINT Events_pk PRIMARY KEY (id)
);

-- Table: Group_users
CREATE TABLE Group_users (
    id int NOT NULL AUTO_INCREMENT,
    Users_username varchar(50) NOT NULL,
    Groups_id int NOT NULL,
    CONSTRAINT Group_users_pk PRIMARY KEY (id)
);

-- Table: Groups
CREATE TABLE Groups (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL,
    CONSTRAINT Groups_pk PRIMARY KEY (id)
);

-- Table: Users
CREATE TABLE Users (
    username varchar(50) NOT NULL,
    email varchar(50) NOT NULL,
    password varchar(255) NOT NULL,
    CONSTRAINT username PRIMARY KEY (username)
);

-- foreign keys
-- Reference: Events_Groups (table: Events)
ALTER TABLE Events ADD CONSTRAINT Events_Groups FOREIGN KEY Events_Groups (Groups_id)
    REFERENCES Groups (id);

-- Reference: Events_Users (table: Events)
ALTER TABLE Events ADD CONSTRAINT Events_Users FOREIGN KEY Events_Users (Users_username)
    REFERENCES Users (username);

-- Reference: Group_users_Groups (table: Group_users)
ALTER TABLE Group_users ADD CONSTRAINT Group_users_Groups FOREIGN KEY Group_users_Groups (Groups_id)
    REFERENCES Groups (id);

-- Reference: Group_users_Users (table: Group_users)
ALTER TABLE Group_users ADD CONSTRAINT Group_users_Users FOREIGN KEY Group_users_Users (Users_username)
    REFERENCES Users (username);

-- Reference: Primary_user (table: Calendar_Share_Access)
ALTER TABLE Calendar_Share_Access ADD CONSTRAINT Primary_user FOREIGN KEY Primary_user (Users_username)
    REFERENCES Users (username);

-- Reference: shares_with (table: Calendar_Share_Access)
ALTER TABLE Calendar_Share_Access ADD CONSTRAINT shares_with FOREIGN KEY shares_with (share_with)
    REFERENCES Users (username);

-- End of file.

