CREATE TABLE notifications (server_notification VARCHAR(1000), device_notification VARCHAR(1000));

CREATE TABLE schedule (weekly_schedule DATE, location VARCHAR(1000));

CREATE TABLE events (event DATE, msg varchar(1000));

CREATE TABLE score (date DATE, score int);

CREATE TABLE fcm_info (fcm_token varchar(400) UNIQUE);
