CREATE TABLE pengguna (
	id_user INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nama VARCHAR (30) NOT NULL,
	nrp CHAR (14) NOT NULL,
	no_telp VARCHAR(12) NOT NULL,
	alamat VARCHAR(50) NOT null,
	password VARCHAR (100) not null,
	isAdmin INT NOT NULL
);

CREATE TABLE pc (
	id_pc INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nama_pc VARCHAR(10) NOT NULL,
	ip VARCHAR(15) NOT NULL,
	hdd VARCHAR(30),
	ram VARCHAR(30),
	processor VARCHAR(30),
	gpu VARCHAR(30),
	status_pc VARCHAR(10),
	pc_lab INT
);

CREATE TABLE lammas.laboratorium (
	id_lab INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	nama_lab VARCHAR(30) NOT NULL,
	ruangan VARCHAR(6) NOT NULL,
	status_lab VARCHAR(10) NOT NULL
);

CREATE TABLE lammas.permohonan_pc (
	id_ppc INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	pc_or_ip INT,
	id_user INT,
	tanggal DATETIME NOT NULL,
	lab INT,
	keperluan VARCHAR(50),
	jenis VARCHAR(50),
	status VARCHAR(10)
);

CREATE TABLE lammas.permohonan_ruangan (
	id_plab INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	id_lab INT,
	id_user INT,
	tanggal DATETIME NOT NULL,
	keperluan VARCHAR(50),
	status VARCHAR(50),
	created_at DATETIME NOT NULL
);