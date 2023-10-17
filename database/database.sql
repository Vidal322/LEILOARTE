SET client_min_messages TO WARNING;


-- Drop Tables

DROP TABLE IF EXISTS auction_ownership ;
DROP TABLE IF EXISTS auction_save ;
DROP TABLE IF EXISTS auction_category ;
DROP TABLE IF EXISTS rate ;
DROP TABLE IF EXISTS comment ;
DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS bid;
DROP TABLE IF EXISTS auction;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS users;


-- Drop Types
DROP TYPE IF EXISTS User_Type;
DROP TYPE IF EXISTS Comment_Type ;
DROP TYPE IF EXISTS Notification_Type;

DROP SCHEMA IF EXISTS lbaw23113 CASCADE;
CREATE SCHEMA lbaw23113;


SET SEARCH_PATH TO lbaw23113;

CREATE TYPE User_Type AS ENUM ('user','admin');
CREATE TYPE Comment_Type AS ENUM ('user','auction');
CREATE TYPE Notification_Type AS ENUM ('comment','auction', 'bid');


-- Create Tables --

CREATE TABLE users(
	id SERIAL PRIMARY KEY,
   username TEXT,       -- Serial?
   email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
   name TEXT NOT NULL,
   description TEXT,
   password TEXT NOT NULL,
   img TEXT,
   deleted BOOLEAN DEFAULT false NOT NULL,
   rate FLOAT CONSTRAINT user_rate_ck CHECK (rate >= 0 AND rate <= 5),
   type User_Type NOT NULL DEFAULT 'user'
);

CREATE TABLE category(
    id SERIAL PRIMARY KEY,
    description TEXT NOT NULL
);

CREATE TABLE auction(
    id SERIAL PRIMARY KEY,
    description TEXT NOT NULL,
    name TEXT NOT NULL,
    image TEXT NOT NULL,
    active BOOLEAN NOT NULL DEFAULT true,
    start_t TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    end_t TIMESTAMP WITH TIME ZONE NOT NULL,
    CONSTRAINT auction_date_ck CHECK (end_t > start_t)
);

CREATE TABLE bid(
    id SERIAL PRIMARY KEY,
    amount FLOAT NOT NULL,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    top_bid BOOLEAN DEFAULT true NOT NULL,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON UPDATE CASCADE  -- on UPDATE necessário?
);

CREATE TABLE notifications(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL,
    date  TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    type Notification_Type NOT NULL,
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    auction_id INTEGER REFERENCES auction(id) ON UPDATE CASCADE,  -- on UPDATE necessário?
    bid_id INTEGER REFERENCES bid(id) ON UPDATE CASCADE  -- on UPDATE necessário?
);

CREATE TABLE comment(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    type Comment_Type NOT NULL,
    source_user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    target_user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    target_auction_id INTEGER REFERENCES auction(id) ON UPDATE CASCADE    
);

CREATE TABLE rate(
    id SERIAL PRIMARY KEY,
    rate FLOAT NOT NULL CONSTRAINT rate_ck CHECK (rate >= 0 AND rate <= 5)
);

CREATE TABLE auction_ownership(
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    auction_id INTEGER REFERENCES auction(id) ON UPDATE CASCADE,  -- on UPDATE necessário?
    PRIMARY KEY(user_id, auction_id)
);

CREATE TABLE auction_save(
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    auction_id INTEGER REFERENCES auction(id) ON UPDATE CASCADE,  -- on UPDATE necessário?
    PRIMARY KEY(user_id, auction_id)
);

CREATE TABLE auction_category(
    category_id INTEGER REFERENCES category(id) ON UPDATE CASCADE,  -- on UPDATE necessário?
    auction_id INTEGER REFERENCES auction(id) ON UPDATE CASCADE,  -- on UPDATE necessário?
    PRIMARY KEY(category_id, auction_id)
);

