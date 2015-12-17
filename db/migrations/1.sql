CREATE TABLE "user"
(
    id         bigserial NOT NULL,
    first_name varchar   NOT NULL,
    last_name  varchar   NOT NULL,
    email      varchar   NOT NULL,
    password   varchar   NOT NULL,
    about      varchar,

    PRIMARY KEY (id)
);

CREATE UNIQUE INDEX ON "user" (lower(email));

CREATE TABLE category
(
    id   bigserial NOT NULL,
    name varchar   NOT NULL,

    PRIMARY KEY (id)
);

CREATE TABLE service
(
    id          bigserial NOT NULL,
    user_id     bigint    NOT NULL,
    category_id bigint    NOT NULL,
    title       varchar   NOT NULL,
    description varchar   NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES "user",
    FOREIGN KEY (category_id) REFERENCES category
);

CREATE TABLE location
(
    id      bigserial NOT NULL,
    country varchar   NOT NULL,
    city    varchar   NOT NULL,

    PRIMARY KEY (id)
);
