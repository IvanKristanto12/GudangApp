--------------------------------------------------------------------------------------------------
/*****List Function*****/
SELECT *
FROM GordenDB.INFORMATION_SCHEMA.ROUTINES
WHERE ROUTINE_TYPE = 'PROCEDURE'
/*Query Function*/

--Function No. 1
--function hash MD5 
--@param input password
--@return input yang sudah di hash MD5
Use GordenDB
GO
CREATE FUNCTION createPass (@input VARCHAR(50))
RETURNS NVARCHAR(32)
AS BEGIN
	DECLARE @Work NVARCHAR(32)
	SET @Work = CONVERT(NVARCHAR(32),HASHBYTES('MD5',@input),2)
	RETURN @work
END
GO
--------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------
/*****List Procedure*****/
SELECT *
FROM GordenDB.INFORMATION_SCHEMA.ROUTINES
WHERE ROUTINE_TYPE = 'PROCEDURE'

--------------------------------------------------------------------------------------------------
/*****Query Procedure*****/
/*Procedure No. 1*/
--List Stock 
--@param status kain 1 = ada, 0 = tidak ada
--@return table 
USE GordenDB
GO
CREATE OR ALTER PROC GetListKain
	@inputStatus INT
AS
SELECT Id_Kain, NomorKarung, Meter, TanggalMasuk, TanggalKeluar, Sampel, Warna, "Jenis Kain"
FROM ListStockKain
WHERE Status = @inputStatus
ORDER BY Sampel , Warna
GO

exec GetListKain 1

--------------------------------------------------------------------------------------------------
/*Procedure No. 2*/
--List PO 
--@param - 
--@return table 
USE GordenDB
GO
CREATE OR ALTER PROC GetListPO
AS
SELECT *
FROM ListPO
GO

exec GetListPO

--------------------------------------------------------------------------------------------------
/*Procedure No. 3*/
--List SJ
--@param - 
--@return table 
USE GordenDB
GO
CREATE OR ALTER PROC GetListSJ
AS
SELECT *
FROM ListSJ
GO

exec GetListSJ

--------------------------------------------------------------------------------------------------
/*Procedure No. 4*/
--List Sampel 
--@param - 
--@return table 
USE GordenDB
GO
CREATE OR ALTER PROC GetListSampel
AS
DECLARE @a TABLE (Sampel VARCHAR(50),
	[Jenis Kain] VARCHAR(50),
	Total_Pcs INT ,
	Total_Meter FLOAT)
INSERT INTO @a
SELECT Sampel , [Jenis Kain], Count(Id_Kain) as 'Total_Pcs', SUM(Meter) as 'Total_Meter'
FROM ListStockKain
WHERE Status = 1
GROUP BY Sampel , [Jenis Kain]

SELECT Sampel.Nama as 'Sampel' , JenisKain.Nama as 'Jenis Kain' , a.Total_Pcs , a.Total_Meter
FROM @a as a
	RIGHT OUTER JOIN Sampel ON a.Sampel = Sampel.Nama
	JOIN JenisKain ON Sampel.Id_JenisKain = JenisKain.Id_JenisKain
ORDER BY Sampel
GO

exec GetListSampel

--------------------------------------------------------------------------------------------------
/*Procedure No. 5*/
--List Warna Sampel 
--@param nama Sampel
--@return table 
USE GordenDB
GO
CREATE OR ALTER PROC GetListWarnaSampel
	@inputNamaSampel VARCHAR(50)
AS
DECLARE @a TABLE (NomorKarung INT,
	Meter FLOAT,
	TanggalMasuk DATE,
	Sampel VARCHAR(50),
	Warna VARCHAR(50))
INSERT INTO @a
SELECT NomorKarung, Meter , TanggalMasuk , Sampel , Warna
FROM ListStockKain
WHERE Status = 1 AND Sampel = @inputNamaSampel

DECLARE @b TABLE (Sampel VARCHAR(50) ,
	Warna VARCHAR(50))
INSERT INTO @b
SELECT *
FROM ListSampelWarna
WHERE Sampel = @inputNamaSampel

DECLARE @c TABLE (Warna VARCHAR(50) ,
	Total_Pcs INT ,
	Total_Meter FLOAT)
INSERT INTO @c
SELECT Warna, COUNT(Warna) as Total_Pcs , SUM(Meter) as Total_Meter
FROM ListStockKain
WHERE Status = 1 AND Sampel = @inputNamaSampel
GROUP BY Warna

SELECT NomorKarung, Meter, TanggalMasuk, b.Warna , c.Total_Pcs , c.Total_Meter
FROM @a as a
	RIGHT OUTER JOIN @b as b ON a.Warna = b.Warna
	LEFT OUTER JOIN @c as c ON b.Warna = c.Warna
ORDER BY b.Warna
GO

exec GetListWarnaSampel 'Anjing'

--------------------------------------------------------------------------------------------------
/*Procedure No. 6*/
--All Pcs dan All Meter
--@param-
--@return table 
USE GordenDB
GO
CREATE OR ALTER PROC GetAllPcsAllMeter
AS
SELECT COUNT(Id_Kain) as 'All Pcs' , SUM(Meter) as 'All Meter'
FROM Kain
WHERE Status = 1
GO

exec GetAllPcsAllMeter

--------------------------------------------------------------------------------------------------
/*Procedure No. 7*/
--CreatePO
--@param- tanggal, idPenjual, idPembeli, inputKain string cth (1,1,)
--@return - 
USE GordenDB
GO
CREATE OR ALTER PROC CreatePO
	@inputTanggal DATE,
	@inputPenjual INT,
	@inputPembeli INT,
	@inputKain VARCHAR(8000)
AS
DECLARE @totalPcs INT, @totalMeter FLOAT, @noPO INT
SET @totalPcs = 0
SET @totalMeter = 0

INSERT INTO PurchaseOrder
	(Tanggal,Id_Penjual,Id_Pembeli,Total_Pcs,Total_Meter,Status)
VALUES
	(@inputTanggal, @inputPenjual, @inputPembeli, @totalPcs, @totalMeter,0)

SET @noPO = (SELECT MAX(No_PO)
FROM PurchaseOrder)

DECLARE @i INT, @idxKain INT, @temp VARCHAR(8000)
SET @i = 1
SET @temp = @inputKain

WHILE LEN(@temp) != 0
	BEGIN
	SET @i = CHARINDEX(',',@temp)
	SET @idxKain = CAST(SUBSTRING(@temp,1, @i-1) as INT)

	INSERT INTO ListKainPO
		(No_PO,Id_Kain,StatusRetur)
	VALUES
		(@noPO, @idxKain, 1)
	UPDATE Kain SET Status = 0 , TanggalKeluar = CAST(@inputTanggal as DATE) WHERE Id_Kain = @idxKain

	SET @totalPcs = @totalPcs + 1
	SET @totalMeter = @totalMeter + (SELECT Meter
	FROM Kain
	WHERE Id_Kain = @idxKain)

	SET @i = @i+1
	SET @temp = SUBSTRING(@temp ,@i,LEN(@temp))
END

UPDATE PurchaseOrder SET Total_Pcs = @totalPcs , Total_Meter = @totalMeter WHERE No_PO = @noPO

GO

exec CreatePO '2020-07-31' , 1 , 1 , '2,'

--------------------------------------------------------------------------------------------------
/*Procedure No. 8*/
--Tambah Sampel Baru
--@param Nama Sampel , Id Jenis kain
--@return -
USE GordenDB
GO
CREATE OR ALTER PROC InsertNewSampel
	@inputNama VARCHAR(50),
	@inputIdJenisKain INT,
	@inputIdWarna VARCHAR(8000)
AS

INSERT INTO Sampel
	(Nama, Id_JenisKain)
VALUES
	(@inputNama, @inputIdJenisKain)
DECLARE @idSampel INT
SET @idSampel = (SELECT MAX(Id_Sampel)
FROM Sampel)

DECLARE @i INT, @idxWarna INT, @temp VARCHAR(8000)
SET @i = 1
SET @temp = @inputIdWarna

WHILE LEN(@temp) != 0
	BEGIN
	SET @i = CHARINDEX(',',@temp)
	SET @idxWarna = CAST(SUBSTRING(@temp,1, @i-1) as INT)
	INSERT INTO SampelWarna
		(Id_Sampel, Id_Warna)
	VALUES
		(@idSampel, @idxWarna)
	SET @i = @i+1
	SET @temp = SUBSTRING(@temp, @i,LEN(@temp))
END
GO

exec InsertNewSampel 'Belalang' , 3, '1,2,3,4,'

--------------------------------------------------------------------------------------------------
/*Procedure No. 9*/
--List Sampel Warna Kain
--@param Id_Sampel
--@return 
-- if input 0 Id_Sampel, Nama 
-- else Id_Sampel, Sampel, Id_Warna, Warna
USE GordenDB
GO
CREATE OR ALTER PROC GetIdSampelIdWarna
	@inputIdSampel INT
AS
IF @inputIdSampel = 0
	BEGIN
	SELECT Id_Sampel, Nama
	FROM Sampel
	ORDER BY Nama
END
	ELSE
	BEGIN
	SELECT Id_Warna , Warna
	FROM ListIdSampelIdWarna
	WHERE Id_Sampel = @inputIdSampel
	ORDER BY Warna
END
GO

exec GetIdSampelIdWarna 1
--------------------------------------------------------------------------------------------------
/*Procedure No. 10*/
--Insert Stock
--@param Id_Sampel , Id_Warna
--@return -
USE GordenDB
GO
CREATE OR ALTER PROC InsertStock
	@inputNomorKarung INT,
	@inputMeter FLOAT,
	@inputTanggalMasuk DATE ,
	@inputIdSampel INT ,
	@inputIdWarna INT
AS
SET @inputTanggalMasuk = CAST(@inputTanggalMasuk as DATE)
INSERT INTO Kain
	(NomorKarung,Meter,TanggalMasuk,TanggalKeluar,Status)
VALUES
	(@inputNomorKarung, @inputMeter, @inputTanggalMasuk, null, 1)

DECLARE @idKain INT
SET @idKain = (SELECT MAX(Id_Kain)
FROM Kain)

INSERT INTO KainSampelWarna
	(Id_Kain,Id_Sampel,Id_Warna)
VALUES
	(@idKain, @inputIdSampel, @inputIdWarna)
GO

exec InsertStock 12, 250,'2020-08-04', 1, 3
--------------------------------------------------------------------------------------------------
/*Procedure No. 11*/
--List Jenis Kain 
--@param -
--@return list JenisKain
USE GordenDB
GO
CREATE OR ALTER PROC GetListJenisKain
AS
SELECT *
FROM JenisKain
GO

exec GetListJenisKain
--------------------------------------------------------------------------------------------------
/*Procedure No. 12*/
--List Warna
--@param -
--@return list Warna
USE GordenDB
GO
CREATE OR ALTER PROC GetListWarna
AS
SELECT *
FROM Warna
ORDER BY Nama
GO

exec GetListWarna
--------------------------------------------------------------------------------------------------
/*Procedure No. 13*/
--List Penjual
--@param -
--@return list Penjual
USE GordenDB
GO
CREATE OR ALTER PROC GetListPenjual
AS
SELECT *
FROM Penjual
ORDER BY Nama
GO

exec GetListPenjual
--------------------------------------------------------------------------------------------------
/*Procedure No. 14*/
--List Pembeli
--@param -
--@return list Pembeli
USE GordenDB
GO
CREATE OR ALTER PROC GetListPembeli
AS
SELECT *
FROM Pembeli
ORDER BY Nama
GO

exec GetListPembeli
--------------------------------------------------------------------------------------------------
/*Procedure No. 15*/
--Detail PO
--@param noPO
--	0 = detail po terakhir, else detail po ke - param
--@return detail PO 
USE GordenDB
GO
CREATE OR ALTER PROC GetDetailPO
	@inputNoPO INT
AS
IF(@inputNoPO = 0)
	BEGIN
	DECLARE @lastPO INT
	SET @lastPO = (SELECT MAX(No_PO)
	FROM PurchaseOrder)

	SELECT *
	FROM ListPO
	WHERE No_PO = @lastPO
	ORDER BY Sampel, Warna
END
	ELSE
	BEGIN
	SELECT *
	FROM ListPO 
	WHERE No_PO = @inputNoPO
	ORDER BY Sampel, Warna
END
GO

exec GetDetailPO 1
--------------------------------------------------------------------------------------------------
/*Procedure No. 16*/
--list PO
--@param -
--@return List PO 
USE GordenDB
GO
CREATE OR ALTER PROC GetListPO
AS
SELECT *
FROM PurchaseOrder
WHERE Status =  0
GO

exec GetListPO
--------------------------------------------------------------------------------------------------
/*Procedure No. 17*/
--create SJ
--@param tanggalSJ , NoPO
--@return - 
USE GordenDB
GO
CREATE OR ALTER PROC CreateSJ
	@inputTanggal DATE ,
	@inputNoPO INT,
	@inputKeterangan VARCHAR(500)
AS
INSERT INTO SuratJalan
	(Tanggal,No_PO,Keterangan)
VALUES
	( CAST(@inputTanggal as DATE) , @inputNoPO , @inputKeterangan)

UPDATE PurchaseOrder SET Status = 1 WHERE No_PO = @inputNoPO
GO

exec CreateSJ '2020-08-30',1,''
--------------------------------------------------------------------------------------------------
/*Procedure No. 18*/
--insert Warna Baru
--@param namaWarna
--@return 
USE GordenDB
GO
CREATE OR ALTER PROC InsertWarnaBaru
	@inputNama VARCHAR(50), @inputNomorBaru INT
AS
DECLARE @i VARCHAR(50)
IF @inputNomorBaru = 0
BEGIN
SET @i = (SELECT DISTINCT Nama
FROM Warna
WHERE Nama LIKE UPPER(@inputNama))
END
ELSE 
BEGIN
SET @i = (SELECT Id_Warna
FROM Warna
WHERE Nama LIKE UPPER(@inputNama) AND NomorWarna = @inputNomorBaru)
END
IF @i IS NULL
	BEGIN
	INSERT INTO Warna
		(Nama , NomorWarna)
	VALUES
		(UPPER(@inputNama) , @inputNomorBaru)
	SELECT 1
END
	ELSE 
	BEGIN
	SELECT 0
END
GO

exec InsertWarnaBaru 'hitam',10
--------------------------------------------------------------------------------------------------
/*Procedure No. 19*/
--insert Penjual Baru
--@param namaPenjual , kode
--@return 
USE GordenDB
GO
CREATE OR ALTER PROC InsertPenjualBaru
	@inputNama VARCHAR(50),
	@inputKode VARCHAR(50)
AS
DECLARE @i INT
SET @i = (SELECT Id_Penjual
FROM Penjual
WHERE Kode LIKE @inputKode)
IF @i IS NULL
	BEGIN
	INSERT INTO Penjual
		(Nama,Kode)
	VALUES
		(@inputNama, @inputKode)
	SELECT 1
END
	ELSE 
	BEGIN
	SELECT 0
END
GO

exec InsertPenjualBaru 'Seller4' , 'S4'

--------------------------------------------------------------------------------------------------
/*Procedure No. 20*/
--insert Pembeli Baru
--@param namaPembeli , alamat
--@return 
USE GordenDB
GO
CREATE OR ALTER PROC InsertPembeliBaru
	@inputNama VARCHAR(50),
	@inputAlamat VARCHAR(50)
AS
DECLARE @i INT
SET @i = (SELECT Id_Pembeli
FROM Pembeli
WHERE Alamat LIKE @inputAlamat AND Nama  LIKE @inputNama)
IF @i IS NULL
	BEGIN
	INSERT INTO Pembeli
		(Nama,Alamat)
	VALUES
		(@inputNama, @inputAlamat)
	SELECT 1
END
	ELSE 
	BEGIN
	SELECT 0
END
GO

exec InsertPembeliBaru 'Buyer4' , 'Garut'

--------------------------------------------------------------------------------------------------
/*Procedure No. 21*/
--GetStock
--@param 
--@return 
USE GordenDB
GO
CREATE OR ALTER PROC GetStock
AS
DECLARE @a TABLE (Sampel VARCHAR(50),
	Warna VARCHAR(50),
	NomorWarna INT,
	TotalPcs INT,
	TotalMeter FLOAT)
INSERT INTO @a
SELECT Sampel.Nama, Warna.Nama, Warna.NomorWarna, COUNT(Kain.Id_Kain) as 'TotalPcs' , SUM(Kain.Meter) as 'TotalMeter'
FROM Kain
	JOIN KainSampelWarna on Kain.Id_Kain = KainSampelWarna.Id_Kain
	JOIN Sampel on Sampel.Id_Sampel = KainSampelWarna.Id_Sampel
	JOIN Warna on Warna.Id_Warna = KainSampelWarna.Id_Warna
WHERE Status = 1
GROUP BY Sampel.Nama, Warna.Nama , Warna.NomorWarna
ORDER BY Sampel.Nama, Warna.Nama , Warna.NomorWarna

SELECT ListSampelWarna.Sampel, ListSampelWarna.Warna, a.NomorWarna, a.TotalPcs, a.TotalMeter
FROM @a as a
RIGHT OUTER JOIN ListSampelWarna ON ListSampelWarna.Sampel = a.Sampel AND ListSampelWarna.Warna = a.Warna
ORDER BY ListSampelWarna.Sampel , ListSampelWarna.Warna
GO

exec GetStock
--------------------------------------------------------------------------------------------------
/*Procedure No. 22*/
--insert Jenis Kain Baru
--@param namaJenisKain
--@return 
USE GordenDB
GO
CREATE OR ALTER PROC InsertJenisKainBaru
	@inputJenisKain VARCHAR(50)
AS
DECLARE @i INT
SET @i = (SELECT Id_JenisKain
FROM JenisKain
WHERE Nama LIKE UPPER(@inputJenisKain))
IF @i IS NULL
	BEGIN
	INSERT INTO JenisKain
		(Nama)
	VALUES
		(UPPER(@inputJenisKain))
	SELECT 1
END
	ELSE 
	BEGIN
	SELECT 0
END
GO

exec InsertJenisKainBaru 'Vitrase' 
--------------------------------------------------------------------------------------------------
/*Procedure No. 23*/
--Get List All
--@param 
--@return 
USE GordenDB
GO
CREATE OR ALTER PROC GetListAll
AS

SELECT PurchaseOrder.No_PO, PurchaseOrder.Tanggal as 'Tanggal PO', No_SJ, SuratJalan.Tanggal as 'Tanggal SJ', Kode
FROM PurchaseOrder 
	JOIN SuratJalan on SuratJalan.No_PO = PurchaseOrder.No_PO
	JOIN Penjual on Penjual.Id_Penjual = PurchaseOrder.Id_Penjual
GO

exec GetListAll
--------------------------------------------------------------------------------------------------
/*Procedure No. 24*/
--Get SJ Ket
--@param 
--@return 
USE GordenDB
GO
CREATE OR ALTER PROC GetSJKet
@inputNoPo INT
AS
SELECT Keterangan
FROM SuratJalan 
WHERE SuratJalan.No_PO = @inputNoPo
GO

exec GetSJKet 1
--------------------------------------------------------------------------------------------------
/*Procedure No. 25*/
--Login Auth
--@param 
--@return 
USE GordenDB
GO
CREATE OR ALTER PROC LoginAuth
@inputUserName VARCHAR(50),
@inputPassword VARCHAR(50)
AS
SELECT *
FROM Users
WHERE Nama = @inputUserName AND Users.[Password] = dbo.createPass(@inputPassword) 
GO

exec LoginAuth 'admin' , 'admin'
--------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------
/*****List View*****/
SELECT
	OBJECT_SCHEMA_NAME(v.object_id) schema_name,
	v.name
FROM
	sys.views as v;

--------------------------------------------------------------------------------------------------
/*****View List*****/
/*View No. 1*/
--ListStockKain
USE GordenDB
GO
CREATE OR ALTER VIEW ListStockKain
AS
	SELECT Kain.Id_Kain, NomorKarung, Meter, TanggalMasuk, TanggalKeluar, Sampel.Nama as 'Sampel', Warna.Nama as 'Warna', JenisKain.Nama as 'Jenis Kain', Status
	FROM Kain
		JOIN KainSampelWarna ON Kain.Id_Kain = KainSampelWarna.Id_Kain
		JOIN Sampel ON Sampel.Id_Sampel = KainSampelWarna.Id_Sampel
		JOIN Warna ON Warna.Id_Warna = KainSampelWarna.Id_Warna
		JOIN JenisKain ON Sampel.Id_JenisKain = JenisKain.Id_JenisKain
GO

SELECT *
FROM ListStockKain
--------------------------------------------------------------------------------------------------
/*View No. 2*/
--List PO
USE GordenDB
GO
CREATE OR ALTER VIEW ListPO
AS
	SELECT PurchaseOrder.No_PO, PurchaseOrder.Tanggal, Penjual.Kode as 'KodePenjual', Penjual.Nama as 'Penjual', Pembeli.Nama as 'Pembeli', Pembeli.Alamat, PurchaseOrder.Total_Pcs ,
		PurchaseOrder.Total_Meter, NomorKarung, Meter, ListStockKain.Sampel, ListStockKain.Warna , ListStockKain.[Jenis Kain]
	FROM PurchaseOrder
		JOIN Penjual ON PurchaseOrder.Id_Penjual = Penjual.Id_Penjual
		JOIN Pembeli ON PurchaseOrder.Id_Pembeli = Pembeli.Id_Pembeli
		JOIN ListKainPO ON PurchaseOrder.No_PO = ListKainPO.No_PO
		JOIN ListStockKain ON ListKainPO.Id_Kain = ListStockKain.Id_Kain
GO

SELECT *
FROM ListPO
--------------------------------------------------------------------------------------------------
/*View No. 3*/
--List SJ
USE GordenDB
GO
CREATE OR ALTER VIEW ListSJ
AS
	SELECT PurchaseOrder.No_PO, PurchaseOrder.Tanggal as 'Tanggal PO', SuratJalan.Tanggal as 'Tanggal SJ'
	FROM PurchaseOrder
		JOIN SuratJalan ON PurchaseOrder.No_PO = SuratJalan.No_PO
GO

SELECT *
FROM ListSJ
--------------------------------------------------------------------------------------------------
/*View No. 4*/
--List SampelWarna
USE GordenDB
GO
CREATE OR ALTER VIEW ListSampelWarna
AS
	SELECT Sampel.Nama as 'Sampel', Warna.Nama as 'Warna', Warna.NomorWarna as 'NomorWarna'
	FROM SampelWarna
		JOIN Sampel ON Sampel.Id_Sampel = SampelWarna.Id_Sampel
		JOIN Warna ON Warna.Id_Warna = SampelWarna.Id_Warna
GO

SELECT *
FROM ListSampelWarna
---------------------------------------------------------------------------------------------------
/*View No. 5*/
--List IdSampelIdWarna
USE GordenDB
GO
CREATE OR ALTER VIEW ListIdSampelIdWarna
AS
	SELECT Sampel.Id_Sampel, Sampel.Nama as 'Sampel', Warna.Id_Warna, Warna.Nama as 'Warna'
	FROM SampelWarna
		JOIN Sampel ON Sampel.Id_Sampel = SampelWarna.Id_Sampel
		JOIN Warna ON Warna.Id_Warna = SampelWarna.Id_Warna
GO

SELECT *
FROM ListIdSampelIdWarna
--------------------------------------------------------------------------------------------------
--------------------------------------------------------------------------------------------------
SELECT *
FROM Users
SELECT *
FROM Kain
SELECT *
FROM Warna
SELECT *
FROM Pembeli
SELECT *
FROM Penjual
SELECT *
FROM JenisKain
SELECT *
FROM Sampel
SELECT *
FROM SampelWarna
SELECT *
FROM KainSampelWarna
SELECT *
FROM PurchaseOrder
SELECT *
FROM ListKainPO
SELECT *
FROM SuratJalan

USE GordenDB
GO
CREATE OR ALTER PROC resetDatabase
AS
--remove data
DELETE FROM ListKainPO
DELETE FROM SampelWarna
DELETE FROM KainSampelWarna
DELETE FROM SuratJalan
DELETE FROM PurchaseOrder
DELETE FROM Users
DELETE FROM Kain
DELETE FROM Warna
DELETE FROM Pembeli
DELETE FROM Penjual
DELETE FROM Sampel
DELETE FROM JenisKain

--autoincrement jdi 1
DBCC CHECKIDENT(Users,RESEED,0)
DBCC CHECKIDENT(Kain,RESEED,0)
DBCC CHECKIDENT(Warna,RESEED,0)
DBCC CHECKIDENT(Pembeli,RESEED,0)
DBCC CHECKIDENT(Penjual,RESEED,0)
DBCC CHECKIDENT(JenisKain,RESEED,0)
DBCC CHECKIDENT(Sampel,RESEED,0)
DBCC CHECKIDENT(PurchaseOrder,RESEED,0)
DBCC CHECKIDENT(SuratJalan,RESEED,0)
GO

exec resetDatabase




