CREATE TABLE "user"
(
    id         bigserial NOT NULL,
    first_name varchar   NOT NULL,
    last_name  varchar   NOT NULL,
    email      varchar   NOT NULL,
    password   varchar   NOT NULL,

    PRIMARY KEY (id)
);
CREATE TABLE service
(
    id bigserial NOT NULL,

    PRIMARY KEY (id)
);
