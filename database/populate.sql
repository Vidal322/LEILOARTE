SET search_path to lbaw23113;

INSERT INTO users (username, email, name, description, password, img, deleted,  rate, type) values ('example_user', 'user@gmail.com', 'John', 'auser', 'password123', 'profilejpg', false,  4.5, 'user');
INSERT INTO users (username, email, name, description, password, img, deleted,  rate, type) values ('example_user2', 'user2@gmail.com', 'John2', 'auser2', 'password123', 'profilejpg', false,  4.5, 'user');


INSERT INTO category (description) values ('Electronics');

INSERT INTO auction (description, name, image, owner_id, active, start_t, end_t) VALUES ('Auction 1', 'Auction 1', 'auction1.jpg', 1, true, '2020-01-01 00:00:00', '2020-01-02 00:00:00');

INSERT INTO bid (amount, date, top_bid, user_id, auction_id) values (10, '2020-01-01 00:00:00', true, 2, 1);

INSERT INTO comment (message, date, source_user_id) VALUES ('Comment 1', '2020-01-01 00:00:00', 2);

INSERT INTO comment_user (comment_id, user_id, rating) VALUES (1, 1, 3);

