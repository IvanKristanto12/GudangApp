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
VALUES('MERAH TUA')
INSERT INTO Warna
    (Nama)
VALUES('PINK')
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
VALUES('SILVER')
INSERT INTO Warna
    (Nama)
VALUES('CREAM')
INSERT INTO Warna
    (Nama)
VALUES('COKLAT MUDA')
INSERT INTO Warna
    (Nama)
VALUES('COKLAT TUA')
INSERT INTO Warna
    (Nama)
VALUES('BRICK')
INSERT INTO Warna
    (Nama)
VALUES('BIRU')
INSERT INTO Warna
    (Nama)
VALUES('GOLD TANGKAI HIJAU')
INSERT INTO Warna
    (Nama)
VALUES('GOLD TANGKAI COKLAT')

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
    ('EMBOSS 3D')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('EMBOSS FOIL')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('EMBOSS LASER')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('EMBOSS PITA')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('FLOCKING')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('JAKAT PRINT')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('JAQUARD')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('JAQUARD FLOCKING')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('JAQUARD KARUNG')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('KIDS COLLECTION')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('PRINT BLUDRU FOIL')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('PRINT DASAR PUTIH')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('PRINT MAS')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('PRINT MAS BLUDRU')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('PRINT MAS BLUDRU WO')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('PRINT MAS CERAH')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('PRINT MAS DASAR PUTIH')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('PRINT MAS FOIL')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('PRINTING MAS EMBOSS')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('RESTU IBU')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('V PRINTING')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('VITRASE BORDIR')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('VITRASE FLOCKING')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('VITRASE FOIL')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('VITRASE KIDS COLLECTION')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('VITRASE MASTER / FH')
INSERT INTO JenisKain
    (Nama)
VALUES
    ('VITRASE PRINTING')

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

INSERT INTO SuratOrder
    (Tanggal,Id_Penjual,Id_Pembeli,Keterangan,Status)
VALUES
    ('2020-07-30', 1, 2, 'Barang dicek dahulu', 1)
INSERT INTO SuratOrder
    (Tanggal,Id_Penjual,Id_Pembeli,Keterangan,Status)
VALUES
    ('2020-07-30', 2, 1, 'Barang dikirim ke Bandung', 1)
INSERT INTO SuratOrder
    (Tanggal,Id_Penjual,Id_Pembeli,Keterangan,Status)
VALUES
    ('2020-07-31', 2, 3, '', 1)

INSERT INTO ListSampelSO
    (No_SO,Id_Sampel,Id_Warna,Total_Pcs)
VALUES
    (1, 1, 1, 1)
INSERT INTO ListSampelSO
    (No_SO,Id_Sampel,Id_Warna,Total_Pcs)
VALUES
    (1, 1, 3, 1)
INSERT INTO ListSampelSO
    (No_SO,Id_Sampel,Id_Warna,Total_Pcs)
VALUES
    (2, 2, 2, 1)
INSERT INTO ListSampelSO
    (No_SO,Id_Sampel,Id_Warna,Total_Pcs)
VALUES
    (3, 3, 4, 1)

INSERT INTO PurchaseOrder
    (Tanggal,Id_Penjual,Id_Pembeli,Total_Pcs,Total_Meter,Status,No_SO)
VALUES
    ('2020-07-30', 1, 2, 2, 250, 1, 1)
INSERT INTO PurchaseOrder
    (Tanggal,Id_Penjual,Id_Pembeli,Total_Pcs,Total_Meter,Status,No_SO)
VALUES
    ('2020-07-30', 2, 1, 1, 100, 1, 2)
INSERT INTO PurchaseOrder
    (Tanggal,Id_Penjual,Id_Pembeli,Total_Pcs,Total_Meter,Status,No_SO)
VALUES
    ('2020-07-31', 2, 3, 1, 150, 1, 3)

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
    (Tanggal,No_PO,Keterangan)
VALUES('2020-07-30', 1, '')
INSERT INTO SuratJalan
    (Tanggal,No_PO,Keterangan)
VALUES('2020-07-30', 2, '')
INSERT INTO SuratJalan
    (Tanggal,No_PO,Keterangan)
VALUES('2020-07-31', 3, '')


