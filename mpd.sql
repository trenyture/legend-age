DROP DATABASE beaume;
CREATE DATABASE beaume CHARACTER SET UTF8mb4 COLLATE utf8mb4_bin;
USE beaume;
SET NAMES utf8mb4;

/*
 * LES COMPTES
 */
CREATE TABLE user (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	email VARCHAR(128) UNIQUE NOT NULL,
	firstname VARCHAR(128) NOT NULL,
	lastname VARCHAR(128) NOT NULL,
	birth_date DATE NOT NULL,
	activation_key VARCHAR(255) NULL,
	created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	archived_date TIMESTAMP NULL,
	newsletter BOOL NOT NULL DEFAULT 1,
	is_admin BOOL NOT NULL DEFAULT 0,
	PRIMARY KEY (id),
	INDEX birth_date_idx (birth_date),
	INDEX created_date_idx (created_date),
	INDEX archived_date_idx (archived_date)
);

CREATE TABLE password(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	hash VARCHAR(90) NOT NULL,
	created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	archived_date TIMESTAMP NULL,
	fk_user INT UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (fk_user)
	REFERENCES user(id),
	INDEX created_date_idx (created_date),
	INDEX archived_date_idx (archived_date)
);

/*
 * LES ADRESSES
 */
CREATE TABLE country(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	label VARCHAR(100) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE address(
	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
	label VARCHAR(90) NULL,
	recipient VARCHAR(180) NOT NULL,
	street VARCHAR(100) NOT NULL,
	complement VARCHAR(100) NULL,
	delivery_instructions TEXT NULL COMMENT 'Commentaire pour la livraison',
	postcode VARCHAR(20) NOT NULL,
	city VARCHAR(100) NOT NULL,
	phone_number VARCHAR(15) NULL,
	created_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	archived_date TIMESTAMP NULL,
	fk_country INT UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (fk_country)
		REFERENCES country(id),
	INDEX created_date_idx (created_date),
	INDEX archived_date_idx (archived_date)
);

/*
 * LES COMMANDES
 */
CREATE TABLE command (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL,
	creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	payment_date TIMESTAMP NULL,
	total_price_before_tax DECIMAL(15, 2) UNSIGNED NOT NULL DEFAULT 0,
	total_price_with_tax DECIMAL(15, 2) UNSIGNED NOT NULL DEFAULT 0,
	tax_amount DECIMAL(15, 2) UNSIGNED NOT NULL DEFAULT 0,
	treated_date TIMESTAMP NULL,
	sent_date TIMESTAMP NULL,
	archiving_date TIMESTAMP NULL,
	PRIMARY KEY (id),
	INDEX creation_date_idx (creation_date),
	INDEX payment_date_idx (payment_date),
	INDEX archiving_date_idx (archiving_date),
	INDEX treated_date_idx (treated_date),
	INDEX sent_date_idx (sent_date)
);

CREATE TABLE product (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL,
	creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	label VARCHAR(80) NOT NULL,
	unit_price FLOAT(9,2) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (id),
	INDEX creation_date_idx (creation_date)
);

CREATE TABLE command_line (
	id INT UNSIGNED AUTO_INCREMENT NOT NULL,
	creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	ordered_quantity INT UNSIGNED NOT NULL,
	fk_command INT UNSIGNED NOT NULL,
	fk_product INT UNSIGNED NOT NULL,
	PRIMARY KEY (id),
	INDEX creation_date_idx (creation_date),
	FOREIGN KEY (fk_command)
		REFERENCES command(id),
	FOREIGN KEY (fk_product)
		REFERENCES product(id)
);

/*
 * LES EMAILS
 */
CREATE TABLE email_status(
	id INT UNSIGNED AUTO_INCREMENT NOT NULL,
	label VARCHAR(10) UNIQUE NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE email_pool(
	id INT UNSIGNED AUTO_INCREMENT NOT NULL,
	sender VARCHAR(90) NOT NULL,
	alias VARCHAR(90) NULL,
	recipient VARCHAR(90) NOT NULL,
	subject VARCHAR(78) NOT NULL,
	message TEXT NOT NULL,
	error TEXT NULL,
	sent_date TIMESTAMP NULL,
	fk_email_status INT UNSIGNED NOT NULL DEFAULT 1,
	PRIMARY KEY (id),
	INDEX sent_date_idx (sent_date),
	FOREIGN KEY (fk_email_status)
		REFERENCES email_status(id)
);

/*
 * TABLES ASSOCIATIVES
 */
CREATE TABLE at_command_address(
	fk_command INT UNSIGNED NOT NULL,
	fk_address INT UNSIGNED NOT NULL,
	PRIMARY KEY (fk_command, fk_address),
	FOREIGN KEY (fk_command)
		REFERENCES command(id),
	FOREIGN KEY (fk_address)
		REFERENCES address(id)
);

CREATE TABLE at_command_user(
	fk_command INT UNSIGNED NOT NULL,
	fk_user INT UNSIGNED NOT NULL,
	PRIMARY KEY (fk_command, fk_user),
	FOREIGN KEY (fk_command)
		REFERENCES command(id),
	FOREIGN KEY (fk_user)
		REFERENCES user(id)
);


/*
 * INSERTIONS
 */

INSERT INTO product(label,unit_price)
VALUES
	("Beaume à lèvres", 29.90),
	("Lot de 4 beaumes", 99.00);

INSERT INTO email_status (label)
VALUES
	("En cours"),
	("Envoyé"),
	("Erreur");

INSERT INTO country (label)
VALUES
	("Afghanistan"),
	("Åland Islands"),
	("Albania"),
	("Algeria"),
	("American Samoa"),
	("Andorra"),
	("Angola"),
	("Anguilla"),
	("Antarctica"),
	("Antigua and Barbuda"),
	("Argentina"),
	("Armenia"),
	("Aruba"),
	("Australia"),
	("Austria"),
	("Azerbaijan"),
	("Bahamas"),
	("Bahrain"),
	("Bangladesh"),
	("Barbados"),
	("Belarus"),
	("Belgium"),
	("Belize"),
	("Benin"),
	("Bermuda"),
	("Bhutan"),
	("Bolivia"),
	("Bonaire Sint Eustatius and Saba"),
	("Bosnia and Herzegovina"),
	("Botswana"),
	("Bouvet Island"),
	("Brazil"),
	("British Indian Ocean Territory"),
	("Brunei Darussalam"),
	("Bulgaria"),
	("Burkina Faso"),
	("Burundi"),
	("Cabo Verde"),
	("Cambodia"),
	("Cameroon"),
	("Canada"),
	("Cayman Islands"),
	("Central African Republic"),
	("Chad"),
	("Chile"),
	("China"),
	("Christmas Island"),
	("Cocos Islands"),
	("Colombia"),
	("Comoros"),
	("Congo"),
	("Congo"),
	("Cook Islands"),
	("Costa Rica"),
	("Côte d'Ivoire"),
	("Croatia"),
	("Cuba"),
	("Curaçao"),
	("Cyprus"),
	("Czechia"),
	("Denmark"),
	("Djibouti"),
	("Dominica"),
	("Dominican Republic"),
	("Ecuador"),
	("Egypt"),
	("El Salvador"),
	("Equatorial Guinea"),
	("Eritrea"),
	("Estonia"),
	("Eswatini"),
	("Ethiopia"),
	("Falkland Islands [Malvinas]"),
	("Faroe Islands"),
	("Fiji"),
	("Finland"),
	("France"),
	("French Guiana"),
	("French Polynesia"),
	("French Southern Territories"),
	("Gabon"),
	("Gambia"),
	("Georgia"),
	("Germany"),
	("Ghana"),
	("Gibraltar"),
	("Greece"),
	("Greenland"),
	("Grenada"),
	("Guadeloupe"),
	("Guam"),
	("Guatemala"),
	("Guernsey"),
	("Guinea"),
	("Guinea-Bissau"),
	("Guyana"),
	("Haiti"),
	("Heard Island and McDonald Islands"),
	("Holy See"),
	("Honduras"),
	("Hong Kong"),
	("Hungary"),
	("Iceland"),
	("India"),
	("Indonesia"),
	("Iran"),
	("Iraq"),
	("Ireland"),
	("Isle of Man"),
	("Israel"),
	("Italy"),
	("Jamaica"),
	("Japan"),
	("Jersey"),
	("Jordan"),
	("Kazakhstan"),
	("Kenya"),
	("Kiribati"),
	("Korea"),
	("Korea"),
	("Kuwait"),
	("Kyrgyzstan"),
	("Lao People's Democratic Republic"),
	("Latvia"),
	("Lebanon"),
	("Lesotho"),
	("Liberia"),
	("Libya"),
	("Liechtenstein"),
	("Lithuania"),
	("Luxembourg"),
	("Macao"),
	("Madagascar"),
	("Malawi"),
	("Malaysia"),
	("Maldives"),
	("Mali"),
	("Malta"),
	("Marshall Islands"),
	("Martinique"),
	("Mauritania"),
	("Mauritius"),
	("Mayotte"),
	("Mexico"),
	("Micronesia"),
	("Moldova"),
	("Monaco"),
	("Mongolia"),
	("Montenegro"),
	("Montserrat"),
	("Morocco"),
	("Mozambique"),
	("Myanmar"),
	("Namibia"),
	("Nauru"),
	("Nepal"),
	("Netherlands"),
	("New Caledonia"),
	("New Zealand"),
	("Nicaragua"),
	("Niger"),
	("Nigeria"),
	("Niue"),
	("Norfolk Island"),
	("North Macedonia"),
	("Northern Mariana Islands"),
	("Norway"),
	("Oman"),
	("Pakistan"),
	("Palau"),
	("Palestine - State of"),
	("Panama"),
	("Papua New Guinea"),
	("Paraguay"),
	("Peru"),
	("Philippines"),
	("Pitcairn"),
	("Poland"),
	("Portugal"),
	("Puerto Rico"),
	("Qatar"),
	("Réunion"),
	("Romania"),
	("Russian Federation"),
	("Rwanda"),
	("Saint Barthélemy"),
	("Saint Helena - Ascension and Tristan da Cunha"),
	("Saint Kitts and Nevis"),
	("Saint Lucia"),
	("Saint Martin"),
	("Saint Pierre and Miquelon"),
	("Saint Vincent and the Grenadines"),
	("Samoa"),
	("San Marino"),
	("Sao Tome and Principe"),
	("Saudi Arabia"),
	("Senegal"),
	("Serbia"),
	("Seychelles"),
	("Sierra Leone"),
	("Singapore"),
	("Sint Maarten"),
	("Slovakia"),
	("Slovenia"),
	("Solomon Islands"),
	("Somalia"),
	("South Africa"),
	("South Georgia and the South Sandwich Islands"),
	("South Sudan"),
	("Spain"),
	("Sri Lanka"),
	("Sudan"),
	("Suriname"),
	("Svalbard and Jan Mayen"),
	("Sweden"),
	("Switzerland"),
	("Syrian Arab Republic"),
	("Taiwan"),
	("Tajikistan"),
	("Tanzania - the United Republic of"),
	("Thailand"),
	("Timor-Leste"),
	("Togo"),
	("Tokelau"),
	("Tonga"),
	("Trinidad and Tobago"),
	("Tunisia"),
	("Turkey"),
	("Turkmenistan"),
	("Turks and Caicos Islands"),
	("Tuvalu"),
	("Uganda"),
	("Ukraine"),
	("United Arab Emirates"),
	("United Kingdom of Great Britain and Northern Ireland"),
	("United States Minor Outlying Islands"),
	("United States of America"),
	("Uruguay"),
	("Uzbekistan"),
	("Vanuatu"),
	("Venezuela"),
	("Viet Nam"),
	("Virgin Islands"),
	("Virgin Islands"),
	("Wallis and Futuna"),
	("Western Sahara"),
	("Yemen"),
	("Zambia"),
	("Zimbabwe");