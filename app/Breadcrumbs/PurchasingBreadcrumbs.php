<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('purchasing', function ($trail) {
    $trail->push('Purchasing');
});

Breadcrumbs::for('purchasing.invoice.index', function($trail) {
    $trail->parent('purchasing');
    $trail->push('Invoice', route('purchasing.invoice.index'));
    $trail->push('Invoice List');
});

Breadcrumbs::for('purchasing.invoice.create', function($trail) {
    $trail->parent('purchasing');
    $trail->push('Product', route('purchasing.invoice.create'));
    $trail->push('Add Purchasing Invoice');
});

Breadcrumbs::for('purchasing.retur.index', function($trail) {
    $trail->parent('purchasing');
    $trail->push('Retur', route('purchasing.retur.index'));
    $trail->push('Retur List');
});
