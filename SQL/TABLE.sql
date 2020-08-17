--------------------------------------------------------------------------------------------------
/*Query Create Table*/
-- Permission 0 - admin, Permission 1 - user
CREATE TABLE Users
(
	Id_User INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	Nama VARCHAR(20) NOT NULL,
	Password CHAR(32) NOT NULL,
	Permission INT NOT NULL
)

CREATE TABLE Kain
(
	Id_Kain INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	NomorKarung INT NOT NULL,
	Meter FLOAT NOT NULL,
	TanggalMasuk DATE NOT NULL,
	TanggalKeluar DATE,
	Status TINYINT NOT NULL,
)

CREATE TABLE Pembeli
(
	Id_Pembeli INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	Nama VARCHAR(50) NOT NULL,
	Alamat VARCHAR(50) NOT NULL
)

CREATE TABLE Penjual
(
	Id_Penjual INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	Nama VARCHAR(50) NOT NULL,
	Kode VARCHAR(50) NOT NULL
)

CREATE TABLE JenisKain
(
	Id_JenisKain INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	Nama VARCHAR(50) NOT NULL
)

CREATE TABLE Warna
(
	Id_Warna INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	Nama VARCHAR(50) NOT NULL
)

CREATE TABLE Sampel
(
	Id_Sampel INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	Nama VARCHAR(50) NOT NULL,
	Id_JenisKain INT NOT NULL FOREIGN KEY REFERENCES JenisKain(Id_JenisKain)
)

CREATE TABLE KainSampelWarna
(
	Id_Kain INT NOT NULL FOREIGN KEY REFERENCES Kain(Id_Kain),
	Id_Sampel INT NOT NULL FOREIGN KEY REFERENCES Sampel(Id_Sampel),
	Id_Warna INT NOT NULL FOREIGN KEY REFERENCES Warna(Id_Warna),
	PRIMARY KEY (Id_Kain,Id_Sampel,Id_Warna)
)

CREATE TABLE SampelWarna
(
	Id_Sampel INT NOT NULL FOREIGN KEY REFERENCES Sampel(Id_Sampel),
	Id_Warna INT NOT NULL FOREIGN KEY REFERENCES Warna(Id_Warna),
	PRIMARY KEY (Id_Sampel,Id_Warna)
)

CREATE TABLE PurchaseOrder
(
	No_PO INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	Tanggal DATE NOT NULL,
	Id_Penjual INT NOT NULL FOREIGN KEY REFERENCES Penjual(Id_Penjual),
	Id_Pembeli INT NOT NULL FOREIGN KEY REFERENCES Pembeli(Id_Pembeli),
	Total_Pcs INT,
	Total_Meter FLOAT
)

CREATE TABLE SuratJalan
(
	No_SJ INT NOT NULL IDENTITY(1,1) PRIMARY KEY,
	Tanggal DATE NOT NULL,
	No_PO INT NOT NULL FOREIGN KEY REFERENCES PurchaseOrder(No_PO)
)

/* table retur */
CREATE TABLE ListKainPO
(
	No_PO INT NOT NULL FOREIGN KEY REFERENCES PurchaseOrder(No_PO),
	Id_Kain INT NOT NULL FOREIGN KEY REFERENCES Kain(Id_Kain),
	StatusRetur TINYINT NOT NULL,
	PRIMARY KEY	(No_PO,Id_Kain)
)



--------------------------------------------------------------------------------------------------
/*Query Data Dummy*/
INSERT INTO Users
	(Nama,Password,Permission)
VALUES
	('admin', dbo.createPass('admin'), 0)
INSERT INTO Users
	(Nama,Password,Permission)
VALUES
	('user1', dbo.createPass('user1'), 1)


INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(1, 100, '2020-07-29', '2020-07-30', 0)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(2, 120, '2020-07-29', null, 1)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(3, 150, '2020-07-29', '2020-07-30', 0)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(4, 100, '2020-07-29', null, 1)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(5, 120, '2020-07-29', null, 1)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(6, 100, '2020-07-30', '2020-07-30', 0)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(7, 120, '2020-07-30', null, 1)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(8, 150, '2020-07-30', '2020-07-31', 0)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(9, 100, '2020-07-30', null, 1)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(10, 120, '2020-07-30', null, 1)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(11, 100, '2020-07-30', null, 1)


INSERT INTO Warna
	(Nama)
VALUES('HITAM')
INSERT INTO Warna
	(Nama)
VALUES('PUTIH')
INSERT INTO Warna
	(Nama)
VALUES('MERAH')
INSERT INTO Warna
	(Nama)
VALUES('KUNING')
INSERT INTO Warna
	(Nama)
VALUES('ABU')
INSERT INTO Warna
	(Nama)
VALUES('ABU TUA')
INSERT INTO Warna
	(Nama)
VALUES('HIJAU')
INSERT INTO Warna
	(Nama)
VALUES('UNGU')
INSERT INTO Warna
	(Nama)
VALUES('GOLD')
INSERT INTO Warna
	(Nama)
VALUES('KREM')
INSERT INTO Warna
	(Nama)
VALUES('COKLAT SUSU')
INSERT INTO Warna
	(Nama)
VALUES('COKLAT TUA')
INSERT INTO Warna
	(Nama)
VALUES('BRICK')
INSERT INTO Warna
	(Nama)
VALUES('BIRU')


INSERT INTO Pembeli
	( Nama, Alamat)
VALUES('Buyer1', 'Jakarta')
INSERT INTO Pembeli
	( Nama, Alamat)
VALUES('Buyer2', 'Bandung')
INSERT INTO Pembeli
	( Nama, Alamat)
VALUES('Buyer3', 'Surabaya')

INSERT INTO Penjual
	(Nama,Kode)
VALUES('Seller1', 'S1')
INSERT INTO Penjual
	(Nama, Kode)
VALUES('Seller2' , 'S2')
INSERT INTO Penjual
	(Nama, Kode)
VALUES('Seller3' , 'S3')


INSERT INTO JenisKain
	(Nama)
VALUES
	('Vitrase Printing')
INSERT INTO JenisKain
	(Nama)
VALUES
	('Vitrase Printing Mas')
INSERT INTO JenisKain
	(Nama)
VALUES
	('Blackout Printing Emboss')
INSERT INTO JenisKain
	(Nama)
VALUES
	('Blackout Printing Emboss Laser')
INSERT INTO JenisKain
	(Nama)
VALUES
	('Blackout Printing Flocking')
INSERT INTO JenisKain
	(Nama)
VALUES
	('Blackout Printing Mas')
INSERT INTO JenisKain
	(Nama)
VALUES
	('Blackout Printing Mas Beludru')
INSERT INTO JenisKain
	(Nama)
VALUES
	('Jakat Print')

INSERT INTO Sampel
	(Nama, Id_JenisKain)
VALUES
	('Ikan', 1)
INSERT INTO Sampel
	(Nama, Id_JenisKain)
VALUES
	('Burung', 2)
INSERT INTO Sampel
	(Nama, Id_JenisKain)
VALUES
	('Gajah', 3)
INSERT INTO Sampel
	(Nama, Id_JenisKain)
VALUES
	('Kucing', 4)
INSERT INTO Sampel
	(Nama, Id_JenisKain)
VALUES
	('Anjing', 5)

INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(1, 1)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(1, 2)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(1, 3)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(1, 4)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(2, 1)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(2, 2)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(3, 3)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(3, 4)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(3, 1)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(4, 1)
INSERT INTO SampelWarna
	(Id_Sampel,Id_Warna)
VALUES
	(5, 4)

INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(1, 1, 1)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(2, 1, 2)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(3, 1, 3)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(4, 1, 4)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(5, 2, 1)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(6, 2, 2)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(7, 3, 3)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(8, 3, 4)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(9, 5, 4)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(10, 4, 1)
INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(11, 1, 1)

INSERT INTO PurchaseOrder
	(Tanggal,Id_Penjual,Id_Pembeli,Total_Pcs,Total_Meter)
VALUES
	('2020-07-30', 1, 2, 2, 250)
INSERT INTO PurchaseOrder
	(Tanggal,Id_Penjual,Id_Pembeli,Total_Pcs,Total_Meter)
VALUES
	('2020-07-30', 2, 1, 1, 100)
INSERT INTO PurchaseOrder
	(Tanggal,Id_Penjual,Id_Pembeli,Total_Pcs,Total_Meter)
VALUES
	('2020-07-31', 2, 3, 1, 150)

INSERT INTO ListKainPO
	(No_PO, Id_Kain, StatusRetur)
VALUES
	(1, 1, 1)
INSERT INTO ListKainPO
	(No_PO, Id_Kain, StatusRetur)
VALUES
	(1, 3, 1)
INSERT INTO ListKainPO
	(No_PO, Id_Kain, StatusRetur)
VALUES
	(2, 6, 1)
INSERT INTO ListKainPO
	(No_PO, Id_Kain, StatusRetur)
VALUES
	(3, 8, 1)

INSERT INTO SuratJalan
	(Tanggal,No_PO)
VALUES('2020-07-30', 1)
INSERT INTO SuratJalan
	(Tanggal,No_PO)
VALUES('2020-07-30', 2)
INSERT INTO SuratJalan
	(Tanggal,No_PO)
VALUES('2020-07-31', 3)

