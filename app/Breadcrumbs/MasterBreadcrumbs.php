<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('master', function ($trail) {
    $trail->push('Master');
});

Breadcrumbs::for('master.category.index', function($trail) {
    $trail->parent('master');
    $trail->push('Category', route('master.category.index'));
    $trail->push('Category List');
});

Breadcrumbs::for('master.unit.index', function($trail) {
    $trail->parent('master');
    $trail->push('Unit', route('master.unit.index'));
    $trail->push('Unit List');
});

Breadcrumbs::for('master.product.index', function($trail) {
    $trail->parent('master');
    $trail->push('Product', route('master.product.index'));
    $trail->push('Product List');
});

Breadcrumbs::for('master.image.index', function($trail) {
    $trail->parent('master');
    $trail->push('Image', route('master.image.index'));
    $trail->push('Image List');
});