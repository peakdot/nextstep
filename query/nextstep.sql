create Database nextstep;

	use nextstep;

	CREATE TABLE Employer
	(
		ID int AUTO_INCREMENT,
		email varchar(50) NOT NULL,
		fname varchar(50) character set utf8 NOT NULL,
		lname varchar(50) character set utf8 NOT NULL,
		password varchar(128),
		accpro varchar(50),
		PRIMARY KEY (ID),
		UNIQUE (email)
		);

	ALTER TABLE Employer AUTO_INCREMENT = 10000000;

	Create table Employee
	(
		ID int AUTO_INCREMENT,
		email varchar(50) NOT NULL,
		fname varchar(50) character set utf8 NOT NULL,
		lname varchar(50) character set utf8 NOT NULL,
		password varchar(128),
		accpro varchar(50),
		PRIMARY KEY (ID),
		UNIQUE (email)
		);

	ALTER TABLE Employee AUTO_INCREMENT = 20000000;

	Create table Company
	(
		ID int AUTO_INCREMENT,
		email  varchar(50) NOT NULL,
		name varchar(50) character set utf8 NOT NULL,
		site varchar(70),
		password varchar(128),
		accpro varchar(50),
		PRIMARY KEY (ID),
		UNIQUE (email)
		);

	ALTER TABLE Company AUTO_INCREMENT = 30000000;

	Create table Joblist
	(
		ID int AUTO_INCREMENT,
		Type int NOT NULL,
		name varchar(70) character set utf8 NOT NULL,
		PRIMARY KEY (ID),
		FOREIGN KEY (Type) REFERENCES JobTypeList(ID) 
		);


	Create table JobTypeList
	(
		ID int AUTO_INCREMENT,
		name varchar(70) character set utf8 NOT NULL,
		PRIMARY KEY (ID)
		);

	Create table employer_phone
	(
		ID int,
		number int NOT NULL,
		FOREIGN KEY (ID) REFERENCES Employer(ID)
		);

	Create table employee_phone
	(
		ID int,
		number int NOT NULL,
		FOREIGN KEY (ID) REFERENCES Employee(ID)
		);

	Create table company_phone
	(
		ID int,
		number int NOT NULL,
		FOREIGN KEY (ID) REFERENCES Company(ID)
		);

	Create table Jobs
	(
		ID int AUTO_INCREMENT,
		jobID int,
		SalaryMax int NOT NULL,
		SalaryMin int NOT NULL,
		wtimeStart int NOT NULL,
		wtimeEnd int NOT NULL,
		week tinyint NOT NULL,
		email varchar(50),
		mobile1 int NOT NULL,
		mobile2 int,
		gender int,
		age int,
		edu int,
		createdDate DATE,
		createdBy int,
		PRIMARY KEY (ID),
		FOREIGN KEY (jobID) REFERENCES JobList(ID) 
		);

	ALTER TABLE Jobs AUTO_INCREMENT = 1000000000;

	Create table Coordinates
	(
		ID int,
		coorX FLOAT(7,4), 
		coorY FLOAT(7,4),
		FOREIGN KEY (ID) REFERENCES Jobs(ID)
		);

	INSERT INTO JobTypeList (ID, `name`) VALUES
	(1, N'Үйлчилгээ'),
	(2, N'Эрүүл ахуй'),
	(3, N'Мөнгө санхүү'),
	(4, N'Үндсэн ажил');

	INSERT INTO Joblist (`Type`, `name`) VALUES
	(1, N'Цэвэрлэгч (Талбайн)'),
	(1, N'Гал тогооны үйлчлэгч'),
	(1, N'Зөөгч'),
	(1, N'Захиалга авагч'),
	(1, N'Угаагч'),
	(1, N'Хамгаалагч'),
	(2, N'Хүнсний технологич'),
	(3, N'Нягтлан бодогч'),
	(4, N'Тогооч'),
	(4, N'Туслах тогооч'),
	(4, N'Бэлтгэгч'),
	(3, N'Цэвэрлэгч');

	SELECT * FROM Coordinates LEFT JOIN 
	(SELECT createdBy, JobList.Type, name, wtimeStart, wtimeEnd, 
		SalaryMin, SalaryMax, createdDate,Jobs.ID 
		as ID FROM Jobs LEFT JOIN JobList ON Jobs.jobID = JobList.ID) 
	as b ON b.ID = Coordinates.ID;