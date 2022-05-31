DROP DATABASE IF EXISTS weatherapp;

CREATE DATABASE weatherapp;

USE weatherapp;

CREATE TABLE location (
    id INTEGER NOT NULL AUTO_INCREMENT,
    city_name VARCHAR(255) NOT NULL,
    state_abbreviation CHAR(2) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE (city_name, state_abbreviation)
);

INSERT INTO location (city_name, state_abbreviation) VALUES ('Gainesville', 'FL');
