create table alternatives
(
    id          uuid         not null
        primary key,
    question_id uuid
        constraint fk_46682b541e27f6bf
            references questions,
    description varchar(255) not null,
    correct     boolean      not null
);