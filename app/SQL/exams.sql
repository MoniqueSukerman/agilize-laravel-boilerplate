create table exams
(
    id                  uuid         not null
        primary key,
    student_id          uuid
        constraint fk_69311328cb944f1a
            references students,
    subject_id          uuid
        constraint fk_6931132823edc87
            references subjects,
    status              varchar(255) not null,
    number_of_questions integer      not null,
    created_at          timestamp(0) not null
);