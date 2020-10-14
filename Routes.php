<?php

//Pages

Route::set('index.php', function () {
    Index::CreateView('Index');
});

Route::set('index', function () {
    Index::CreateView('Index');
});

Route::set('authLogin', function () {
    Controller::SubmitForm("loginHandler");
});


Route::set('stock', function () {
    if (isset($_COOKIE["username"])) {
        Stock::CreateView('Stock');
    }
});

if (isset($_COOKIE["userpermission"])) {
    if ($_COOKIE["userpermission"] == 0) {
        Route::set('so', function () {
            PO::CreateView('SO');
        });

        Route::set('po', function () {
            PO::CreateView('PO');
        });

        Route::set('sj', function () {
            SJ::CreateView('SJ');
        });

        Route::set('alllist', function () {
            SJ::CreateView('AllList');
        });

        Route::set('xlsx', function () {
            Xlsx::CreateView('Xlsx');
        });

        Route::set('retur', function () {
            Retur::CreateView('Retur');
        });

        Route::set('listretur', function () {
            ListRetur::CreateView('ListRetur');
        });

        //Function
        Route::set('getListWarna', function () {
            AJAX::getListWarna();
        });

        Route::set('getBySO', function () {
            AJAX::getBySO();
        });

        Route::set('getByPO', function () {
            AJAX::getByPO();
        });

        //FormHandler
        Route::set('StockFormHandler', function () {
            Controller::SubmitForm("StockHandler");
            header("Location: stock");
        });

        Route::set('SOHandler', function () {
            Controller::SubmitForm("SOHandler");
            header("Location: so");
        });

        Route::set('POHandler', function () {
            Controller::SubmitForm("POHandler");
            header("Location: po");
        });

        Route::set('SJHandler', function () {
            Controller::SubmitForm("SJHandler");
            header("Location: sj");
        });

        Route::set('AllListHandler', function () {
            Controller::SubmitForm("AllListHandler");
            header("Location: alllist");
        });

        Route::set('ReturHandler', function () {
            Controller::SubmitForm("ReturHandler");
            header("Location: retur");
        });

        Route::set('ListReturHandler', function () {
            Controller::SubmitForm("ListReturHandler");
            header("Location: listretur");
        });

        Route::set('POPDF', function () {
            Controller::SubmitForm("POPDF");
        });

        Route::set('SJPDF', function () {
            Controller::SubmitForm("SJPDF");
        });

        Route::set('SOPDF', function () {
            Controller::SubmitForm("SOPDF");
        });

        Route::set('StockPDF', function () {
            Controller::SubmitForm("StockPDF");
        });

        Route::set('ReturPDF', function () {
            Controller::SubmitForm("ReturPDF");
        });

    } else if ($_COOKIE["userpermission"] == 1) {
        Route::set('StockFormHandler', function () {
            Controller::SubmitForm("StockHandler");
            header("Location: stock");
        });

        Route::set('StockPDF', function () {
            Controller::SubmitForm("StockPDF");
        });
    }
}
