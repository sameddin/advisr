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
    id          bigserial NOT NULL,
    user_id     bigint    NOT NULL,
    title       varchar   NOT NULL,
    description varchar   NOT NULL,

    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES "user"
);
