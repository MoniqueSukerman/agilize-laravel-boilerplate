create table questions_exams
(
    id           uuid         not null
        primary key,
    exam_id      uuid
        constraint fk_ec498354578d5e91
            references exams,
    description  varchar(255) not null,
    right_answer boolean
);