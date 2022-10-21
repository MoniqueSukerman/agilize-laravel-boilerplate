create table questions
(
    id          uuid         not null
        primary key,
    subject_id  uuid
        constraint fk_8adc54d523edc87
            references subjects,
    description varchar(255) not null
);