<?php

//Pages

Route::set('index.php', function () {
    Index::CreateView('Index');
});

Route::set('index', function () {
    Index::CreateView('Index');
});

Route::set('stock', function () {
    Stock::CreateView('Stock');
});

Route::set('po', function () {
    PO::CreateView('PO');
});

Route::set('sj', function () {
    SJ::CreateView('SJ');
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

Route::set('POPDF', function () {
    Controller::SubmitForm("POPDF");
});

Route::set('SJPDF', function () {
    Controller::SubmitForm("SJPDF");
});
