SET client_min_messages TO WARNING;

-- DROP and Create Schema
DROP SCHEMA IF EXISTS lbaw23113 CASCADE;
CREATE SCHEMA lbaw23113;
SET SEARCH_PATH TO lbaw23113;

--Create Types
CREATE TYPE User_Type AS ENUM ('user','admin');

-- Create Tables --
CREATE TABLE users(
    id SERIAL PRIMARY KEY,
    username TEXT NOT NULL CONSTRAINT username_uk UNIQUE,
    email TEXT NOT NULL CONSTRAINT user_email_uk UNIQUE,
    name TEXT NOT NULL,
    description TEXT,
    password TEXT NOT NULL,
    img TEXT DEFAULT 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAPFBMVEXk5ueutLepsLPo6uursbXJzc/p6+zj5ea2u76orrKvtbi0ubzZ3N3O0dPAxcfg4uPMz9HU19i8wcPDx8qKXtGiAAAFTElEQVR4nO2d3XqzIAyAhUD916L3f6+f1m7tVvtNINFg8x5tZ32fQAIoMcsEQRAEQRAEQRAEQRAEQRAEQRAEQRAEQRAEQRAEQTghAJD1jWtnXJPP/54IgNzZQulSmxvTH6oYXX4WS+ivhTbqBa1r26cvCdCu6i0YXbdZ0o4A1rzV+5IcE3YE+z58T45lqo7g1Aa/JY5tgoqQF3qb382x7lNzBLcxft+O17QUYfQI4IIeklKsPSN4i6LKj/7Zm8n99RbHJpEw9gEBXNBpKIYLJqKYRwjOikf//r+J8ZsVuacbqCMNleI9TqGLGqMzhnVdBOdd6F/RlrFijiCoVMk320CBIahUxTWI0KKEcJqKbMdpdJb5QvdHq6wCI5qhKlgGMS/RBHkubWDAE+QZxB4xhCyDiDkLZxgGEVdQldzSKbTIhmZkFkSEPcVvmBn2SMuZB9od7fQDsMiDdKJjFUSCQarM5WirZ3C2TT/htYnyPcPfgrFHWz0BI74gr6J/IZiGUxAZGQLqmvQLTrtE/Go4YxhVRIpEw+sww1IIcqr5NKmUUzLF3d4/qPkYIp2T/obPuemlojFUR4t9Q2Vojhb7BmgElWHzLPH8hucfpefPNFTVgs9h1AdU/Pin96vwWbWdf+X9Absn3OdO34aMdsDnP8WgKYisTqI6CkNGqZQo1XA6Ef6AU32SJzOcBukHPF07/xNSgmHKa5BOhtezv6mA/rYJpwXNAnbRZ1XuF3BzDcO3vpA3+ny2909gbqE4hhD3LIPhLLyBNhPZvbZ3B+3tPYa18A7auSlXQayKwTPNLKDcuOB0xPYKDPFTkWsevQPRZ1J8Hji9I1KQ34r7hZhrwNwOZ97QxNx0drwn4QI0wQk1DcEsfKCWKdxVvxPSNUIp/knmAXT+nT+Ko3+0H96rcNb3m1fx7MBTJdeBJ7uFcWsc0wvgAsC4pROW0l2inbAmIBv/7GZmuhQH6API2rr8T0e6yuZJ+80A9LZeG62T3tik31XwxtwZcizKuTHkMjB1WdZde4Kmic/A5ZI3rr1ae21d08PlVHYfAaxw9G9CYRbJ+8ZdbTcMRV1XM3VdF0M32vtoTdZ0+u29s0OttJ5bz64UwinjaFMVY9vkqc3KKSxN21Xl+0L4Q3Vuv1tYl0pqnX6ms4XetFz7gdZVAgUEoJntfOUe4ZwsHd9FzqQ3Vv6xe41l0XJcqcKl6TZvlv7ClAW3BsqQW4X7ypApB8dmTgK4IX5wvqIVj33HtD2qSG4BqznxdIefL27Y4sahi0MdIdvUsDva8agGGbCtITmCY31MHD2O0uIdh/0rJDQ1VX5Zdxz3rR2QDbv6qXl9vudzqQtGm1Jv9LDXOsfvvB7VcZ8PDKD0mQ1VHPYQ9O+Yj4hR1IUD8rBnn3ho2m8oQMxbCFiKlL2ioSW5heeJqegED52CzxCtcGD3Kv8Wms9EYLyUhwaFIhSMBClevWEmiK/Iaogu4H7sg6ppQhQG8RUqivuTGOAJOg6FfgW0q0M0PQMRMEgXaeNf3SYDZ8PIMI0+wHgr/MgN7wYwpiLjCCqM6ydUDZLQiB6nDdNC8SDyig3jPPpFXGcC9O8BUBDVmgBY59E7Md/35Loe/UVEECEJwYggJjELZ4J71SaQSBeC02n4Da29CayJNA28SAhd2CQyC1Xw6pSmGSINQVuMhAZp4DClan9MgmkDDNmezqwS8sgtlXK/EPBhoaSmYVC/F7IO1jQEdHOlabpKh3+jzLQSTUiq4X2I+Ip/zU8rlaqAvkS21ElR+gqu3zbjjL+hIAiCIAiCIAiCIAiCsCf/AKrfVhSbvA+DAAAAAElFTkSuQmCC',
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
    image TEXT,
    owner_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    active BOOLEAN NOT NULL DEFAULT true,
    starting_price FLOAT DEFAULT 0 NOT NULL CONSTRAINT auction_starting_price_ck CHECK (starting_price >= 0),
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
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON UPDATE CASCADE
);

CREATE TABLE comment(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL,
    date TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    source_user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE
);

CREATE TABLE comment_user(
    comment_id INTEGER PRIMARY KEY REFERENCES comment(id) ON UPDATE CASCADE,
    user_id INTEGER NOT NULL REFERENCES users(id) ON UPDATE CASCADE,
    rating FLOAT CONSTRAINT check_rating_comment CHECK (rating >= 0 AND rating <= 5)
);

CREATE TABLE comment_auction(
    comment_id INTEGER PRIMARY KEY REFERENCES comment(id) ON UPDATE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON UPDATE CASCADE
);

CREATE TABLE notifications(
    id SERIAL PRIMARY KEY,
    message TEXT NOT NULL,
    date  TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    is_seen BOOLEAN DEFAULT FALSE NOT NULL
);

CREATE TABLE notification_bid(
    notification_id INTEGER PRIMARY KEY REFERENCES notifications(id) ON UPDATE CASCADE,
    bid_id INTEGER NOT NULL REFERENCES bid(id) ON UPDATE CASCADE
);

CREATE TABLE notification_auction(
    notification_id INTEGER PRIMARY KEY REFERENCES notifications(id) ON UPDATE CASCADE,
    auction_id INTEGER NOT NULL REFERENCES auction(id) ON UPDATE CASCADE
);

CREATE TABLE notification_comment(
    notification_id INTEGER PRIMARY KEY REFERENCES notifications(id) ON UPDATE CASCADE,
    comment_id INTEGER NOT NULL REFERENCES comment(id) ON UPDATE CASCADE
);

CREATE TABLE auction_save(
    user_id INTEGER REFERENCES users(id) ON UPDATE CASCADE,
    auction_id INTEGER REFERENCES auction(id) ON UPDATE CASCADE, 
    PRIMARY KEY(user_id, auction_id)
);

CREATE TABLE auction_category(
    category_id INTEGER REFERENCES category(id) ON UPDATE CASCADE, 
    auction_id INTEGER REFERENCES auction(id) ON UPDATE CASCADE,  
    PRIMARY KEY(category_id, auction_id)
);



-- #################################        PERFORMANCE INDEXES        #################################

-- ** INDEX 01 - idx_notification **
CREATE INDEX idx_notification ON notifications USING hash(user_id);

-- ** INDEX 02 - idx_comment **
CREATE INDEX idx_comment ON comment USING hash(source_user_id);

-- ** INDEX 03 - idx_bid_auction **
CREATE INDEX idx_bid_auction ON bid USING hash(auction_id);


-- #################################      FULL TEXT SEARCH INDEXES        #################################


-- ** INDEX 04 - idx_auction_search **

Alter Table auction
ADD COLUMN tsvectors TSVECTOR;

-- Function to get the description of the categories associated to an auction_id

CREATE FUNCTION get_categories_from_auction(a_id INT) RETURNS TEXT AS $$
BEGIN
RETURN COALESCE((SELECT category.description
    FROM category, auction_category, auction
    WHERE auction.id = auction_category.auction_id AND auction_category.category_id = category.id AND auction.id = a_id), '');
END;
$$ LANGUAGE plpgsql;


-- Function to change the tsvectors of the table auction on INSERT AND UPDATE


CREATE FUNCTION func_auction_search_update() RETURNS TRIGGER AS $$
BEGIN
IF TG_OP = 'INSERT' THEN 
    NEW.tsvectors = (
        setweight(to_tsvector('english', NEW.description), 'B') ||
        setweight(to_tsvector('english', NEW.name), 'A') ||
        setweight(to_tsvector('english', get_categories_from_auction(NEW.id)), 'C')
    );
    END IF;
IF TG_OP = 'UPDATE' THEN
    IF (NEW.description <> OLD.description OR NEW.name <> OLD.name) THEN
        NEW.tsvectors= (
        setweight(to_tsvector('english', NEW.description), 'B') ||
        setweight(to_tsvector('english', NEW.name), 'A') ||
        setweight(to_tsvector('english', get_categories_from_auction(NEW.id)), 'C')
    );
    END IF;
END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;


-- Create a trigger before insert or update on auction to change the tsvectors column.
CREATE TRIGGER trig_auction_search_update
BEFORE INSERT OR UPDATE ON auction
FOR EACH ROW
EXECUTE PROCEDURE func_auction_search_update();
 
 -- CREATE SEARCH INDEX FOR Table Auction
CREATE INDEX idx_auction_search ON auction USING GIST (tsvectors);



-- ** INDEX 05 - idx_category_search **

ALTER TABLE category
ADD COLUMN tsvectors TSVECTOR;

-- Function to add/edit the tsvector column on INSERT/UPDATE on the category table

CREATE FUNCTION func_category_search_update() RETURNS TRIGGER AS $$
BEGIN
IF TG_OP = 'INSERT' THEN 
	NEW.tsvectors = (
		setweight(to_tsvector('english', NEW.description), 'A')
	);
	END IF;
IF TG_OP = 'UPDATE' THEN
	IF (NEW.description <> OLD.description) THEN
		NEW.tsvectors= (
		setweight(to_tsvector('english', NEW.description), 'A') 
	);
	END IF;
END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;

-- Create a trigger before insert or update on the category table to run the update/insert function.
CREATE TRIGGER trig_category_search_update
BEFORE INSERT OR UPDATE ON category
FOR EACH ROW
EXECUTE PROCEDURE func_category_search_update();

-- Create search index for table category
CREATE INDEX idx_category_search ON category USING GIN (tsvectors);
 


-- ** INDEX 06 - idx_users_search **

ALTER TABLE users
ADD COLUMN tsvectors TSVECTOR;

-- function to add/edit the tsvector column on INSERT/UPDATE on the users table
CREATE FUNCTION func_users_search_update() RETURNS TRIGGER AS $$
BEGIN
IF TG_OP = 'INSERT' THEN 
	NEW.tsvectors = (
		setweight(to_tsvector('english', NEW.username), 'A') ||
        setweight(to_tsvector('english', NEW.name), 'B')
	);
	END IF;
IF TG_OP = 'UPDATE' THEN
	IF (NEW.username <> OLD.username OR NEW.name <> OLD.name) THEN
		NEW.tsvectors= (
		setweight(to_tsvector('english', NEW.username), 'A') ||
        setweight(to_tsvector('english', NEW.name), 'B') 
	);
	END IF;
END IF;
RETURN NEW;
END $$
LANGUAGE plpgsql;


-- Create a trigger before insert or update on the users table to run the update/insert function.
CREATE TRIGGER trig_users_search_update
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
EXECUTE PROCEDURE func_users_search_update();

-- Create search index for table users
CREATE INDEX idx_users_search ON category USING GIST (tsvectors);


-- ##################################           TRIGGERS          #####################################


-- * TRIGGER01 *

-- Create a trigger to delete bids on open auctions when a user account is deleted.
CREATE OR REPLACE FUNCTION delete_user_bids()
RETURNS TRIGGER AS $$
BEGIN
    DELETE FROM bid
    WHERE user_id = OLD.id
    AND EXISTS (
        SELECT 1
        FROM auction
        WHERE auction.id = bid.auction_id
        AND auction.active = true
    );

    RETURN OLD;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger for user account deletion.
CREATE TRIGGER trig_delete_user_bids
AFTER UPDATE ON users
FOR EACH ROW
WHEN (OLD.deleted = false AND NEW.deleted = true)
EXECUTE PROCEDURE delete_user_bids();


-- * TRIGGER02 *


-- Create a trigger to raise an exception if a user tries to bid as the current highest bidder.
CREATE OR REPLACE FUNCTION check_bid_higher_bidder()
RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (
        SELECT 1
        FROM bid
        WHERE auction_id = NEW.auction_id
        AND user_id = NEW.user_id
        AND top_bid = true
    ) THEN
        RAISE EXCEPTION 'A user can only make a bid if they are not the current higher bidder on that auction.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger for bid insertion to check for the highest bidder.
CREATE TRIGGER trig_check_bid_higher_bidder
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE PROCEDURE check_bid_higher_bidder();


-- * TRIGGER03 *


-- Create a trigger function to update auction end time based on bid date.
CREATE OR REPLACE FUNCTION update_auction_end_time()
RETURNS TRIGGER AS $$
BEGIN
    -- Check if the condition is met.
    IF EXISTS (
        SELECT 1
        FROM auction
        WHERE NEW.auction_id = auction.id
        AND NEW.date + INTERVAL '15 minutes' > auction.end_t
    ) THEN
        -- Calculate the new end time as bid date + 30 minutes.
        UPDATE auction
        SET end_t = NEW.date + INTERVAL '30 minutes'
        WHERE auction.id = NEW.auction_id;
    END IF;
    
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger for bid insertion to update auction end time.
CREATE TRIGGER trig_update_auction_end_time
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE PROCEDURE update_auction_end_time();


-- * TRIGGER04 *


-- Create a trigger to raise an exception if the auction owner tries to bid on their own auction.
CREATE OR REPLACE FUNCTION check_auction_owner_bid()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.user_id = (SELECT owner_id FROM auction WHERE id = NEW.auction_id) THEN
        RAISE EXCEPTION 'An auction owner can''t bid on their own auction.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger for bid insertion to check for auction owner bidding.
CREATE TRIGGER trig_check_auction_owner_bid
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE PROCEDURE check_auction_owner_bid();



-- * TRIGGER05 *


CREATE OR REPLACE FUNCTION delete_user_auctions()
RETURNS TRIGGER AS $$
BEGIN
   -- Delete open auctions when a user is deleted.
   DELETE FROM auction
   WHERE owner_id = OLD.id
   AND active = true;

   -- Delete associated bids.
   DELETE FROM bid
   WHERE auction_id IN (
       SELECT id
       FROM auction
       WHERE owner_id = OLD.id
   );

   RETURN OLD;
END;
$$ LANGUAGE plpgsql;

-- * TRIGGER06 *

-- Create a trigger function to prevent administrators from making bids.
CREATE OR REPLACE FUNCTION prevent_admin_bids()
RETURNS TRIGGER AS $$
BEGIN
    -- Check if the user associated with the bid is an administrator.
    IF EXISTS (
        SELECT 1
        FROM users
        WHERE NEW.user_id = users.id
        AND users.type = 'admin'
    ) THEN
        RAISE EXCEPTION 'An administrator can''t make bids';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger for bid insertion to prevent administrators from making bids.
CREATE TRIGGER trig_prevent_admin_bids
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE PROCEDURE prevent_admin_bids();


-- * TRIGGER07 *

-- Create a trigger function to check the bid value.
CREATE OR REPLACE FUNCTION check_bid_value()
RETURNS TRIGGER AS $$
    -- Find the starting price and the latest bid with top_bid=true for the same auction.
    DECLARE
        starting FLOAT;
        latest_bid_value FLOAT;
BEGIN
    SELECT amount
    INTO latest_bid_value
    FROM bid
    WHERE auction_id = NEW.auction_id AND top_bid = true;

    SELECT starting_price
    INTO starting
    FROM auction
    WHERE auction.id = NEW.auction_id;

    IF NEW.amount < starting THEN
        RAISE EXCEPTION 'The new bid must be equal to or higher than the starting price for the auction.';
    END IF;

    -- Check if the new bid amount is lower than the latest bid.
    IF NEW.amount <= latest_bid_value THEN
        RAISE EXCEPTION 'The new bid must be higher than the latest bid on that auction.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger for bid insertion to check the bid value.
CREATE TRIGGER trig_check_bid_value
BEFORE INSERT ON bid
FOR EACH ROW
EXECUTE PROCEDURE check_bid_value();



-- * TRIGGER08 *

-- Create a trigger function to check the comment source_user_id.
CREATE OR REPLACE FUNCTION check_comment_auction_owner()
RETURNS TRIGGER AS $$
BEGIN
    -- Get the source_user_id from the associated comment.
    DECLARE
        comment_source_user_id INTEGER;
    BEGIN
        SELECT source_user_id
        INTO comment_source_user_id
        FROM comment
        WHERE id = NEW.comment_id;

        -- Check if the source_user_id in the comment is the same as the user_id in the auction.
        IF comment_source_user_id = (SELECT user_id FROM auction WHERE id = NEW.auction_id) THEN
            RAISE EXCEPTION 'A user can''t comment on their own auction.';
        END IF;

        RETURN NEW;
    END;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger for comment_auction insertion to check the comment source_user_id.
CREATE TRIGGER trig_check_comment_auction_owner
BEFORE INSERT ON comment_auction
FOR EACH ROW
EXECUTE PROCEDURE check_comment_auction_owner();


-- * TRIGGER09 *

-- Create a trigger function to check if a user is rating themselves.
CREATE OR REPLACE FUNCTION check_self_rating()
RETURNS TRIGGER AS $$
BEGIN
    -- Check if the user_id in comment_user is the same as source_user_id in the associated comment.
    IF NEW.user_id = (SELECT source_user_id FROM comment WHERE id = NEW.comment_id) THEN
        RAISE EXCEPTION 'A user can''t rate themselves.';
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger for comment_user insertion to check self-rating.
CREATE TRIGGER trig_check_self_rating
BEFORE INSERT ON comment_user
FOR EACH ROW
EXECUTE PROCEDURE check_self_rating();


-- * TRIGGER10 *

-- Create a trigger after insert on comment_auction to create a notification for the auction owner.
CREATE OR REPLACE FUNCTION create_auction_comment_notification()
RETURNS TRIGGER AS $$
DECLARE
    comment_author_username TEXT;
    notification_id INT;
BEGIN

    -- Get the username of the user who made the comment from the associated comment.
    SELECT username INTO comment_author_username
    FROM users
    WHERE id = (SELECT source_user_id FROM comment WHERE id = NEW.comment_id);

    -- Create a new notification with the message.
    INSERT INTO notifications (message, user_id, is_seen)
    VALUES (comment_author_username || ' commented on your auction.', 
            (SELECT owner_id FROM auction WHERE id = NEW.auction_id), 
            FALSE)
    RETURNING id INTO notification_id;

    -- Insert the notification and comment association into the notification_comment table.
    INSERT INTO notification_comment (notification_id, comment_id)
    VALUES (notification_id, NEW.comment_id);

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger after insert on comment_auction to create a notification.
CREATE TRIGGER trig_create_auction_comment_notification
AFTER INSERT ON comment_auction
FOR EACH ROW
EXECUTE PROCEDURE create_auction_comment_notification();


-- * TRIGGER11 *

-- Create a trigger before insert on comment_user to update the user's rate in the users table.
CREATE OR REPLACE FUNCTION update_user_rate()
RETURNS TRIGGER AS $$
DECLARE
    avg_rating FLOAT;
BEGIN
    -- Calculate the average rating for the user in comment_user.
    SELECT AVG(rating) INTO avg_rating
    FROM comment_user
    WHERE user_id = NEW.user_id;

    -- Update the user's rate in the users table with the calculated average.
    UPDATE users
    SET rate = avg_rating
    WHERE id = NEW.user_id;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create a trigger before insert on comment_user to update the user's rate.
CREATE TRIGGER trig_update_user_rate
BEFORE INSERT ON comment_user
FOR EACH ROW
EXECUTE PROCEDURE update_user_rate();

