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
        Route::set('po', function () {
            PO::CreateView('PO');
        });

        Route::set('sj', function () {
            SJ::CreateView('SJ');
        });

        Route::set('alllist', function () {
            SJ::CreateView('AllList');
        });

        //Function
        Route::set('getListWarna', function () {
            AJAX::getListWarna();
        });

        //FormHandler
        Route::set('StockFormHandler', function () {
            Controller::SubmitForm("StockHandler");
            header("Location: stock");
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

        Route::set('POPDF', function () {
            Controller::SubmitForm("POPDF");
        });

        Route::set('SJPDF', function () {
            Controller::SubmitForm("SJPDF");
        });
    }
}

