create TABLE ex_user_group (
    id int(10) unsigned not null,
    parent_id int(10) unsigned,
    name varchar(255),
    image varchar(255),
    rank int(10) unsigned not null default '0',
    PRIMARY KEY (id),
    FOREIGN KEY (parent_id) REFERENCES ex_user_group (id)
);
CREATE UNIQUE INDEX ex_user_group_id_uindex ON ex_user_group (id);
CREATE UNIQUE INDEX ex_user_group_title_uindex ON ex_user_group (name);