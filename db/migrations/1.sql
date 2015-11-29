CREATE TABLE advice
(
    id         bigserial NOT NULL,
    first_name varchar   NOT NULL,
    last_name  varchar   NOT NULL,
    email      varchar   NOT NULL,

    PRIMARY KEY (id)
);
