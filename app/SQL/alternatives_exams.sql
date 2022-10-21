create table alternatives_exams
(
    id          uuid         not null
        primary key,
    question_id uuid
        constraint fk_488285de1e27f6bf
            references questions_exams,
    description varchar(255) not null,
    correct     boolean      not null,
    chosen      boolean      not null
);