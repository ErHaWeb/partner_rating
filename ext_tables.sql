CREATE TABLE tx_partnerrating_domain_model_partner
(
    title      varchar(255) NOT NULL DEFAULT '',
    partner_nr varchar(255) NOT NULL DEFAULT '',
    slug       varchar(2048)
);

CREATE TABLE tx_partnerrating_domain_model_rating
(
    rate_value  int(11)          DEFAULT '0' NOT NULL,
    partner     int(11) unsigned DEFAULT '0',
    reason      int(11) unsigned DEFAULT '0',
    reason_text text,
    department  int(11) unsigned DEFAULT '0'
);

CREATE TABLE tx_partnerrating_domain_model_reason
(
    title       varchar(255) NOT NULL DEFAULT '',
    description text,
    department  int(11) unsigned      DEFAULT '0'
);

CREATE TABLE tx_partnerrating_domain_model_department
(
    title varchar(255) NOT NULL DEFAULT '',
    slug  varchar(2048)
);
