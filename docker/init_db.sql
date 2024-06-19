use interview;

create table if not exists user
(
	id         int auto_increment
        primary key,
	first_name varchar(25)  not null,
	last_name  varchar(25)  not null,
	email      varchar(180) not null,
	password   varchar(60)  not null,
	is_active  tinyint(1)   not null,
	avatar     longtext     not null,
	created_at datetime     not null comment '(DC2Type:datetime_immutable)',
	updated_at datetime     null comment '(DC2Type:datetime_immutable)',
	roles      json         not null,
	full_name  varchar(51)  not null,
	uuid       char(36)     not null comment '(DC2Type:guid)',
	constraint UNIQ_8D93D649E7927C74
		unique (email)
)
	collate = utf8mb4_unicode_ci;

create table if not exists photo
(
	id         int auto_increment
        primary key,
	user_id    int          null,
	name       varchar(255) not null,
	url        varchar(255) not null,
	created_at datetime     not null comment '(DC2Type:datetime_immutable)',
	updated_at datetime     not null comment '(DC2Type:datetime_immutable)',
	constraint FK_14B78418A76ED395
		foreign key (user_id) references user (id)
)
	collate = utf8mb4_unicode_ci;

create index IDX_14B78418A76ED395
	on photo (user_id);

