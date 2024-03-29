<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('master', function ($trail) {
    $trail->push('Master');
});

Breadcrumbs::for('master.supplier.index', function($trail) {
    $trail->parent('master');
    $trail->push('Supplier', route('master.supplier.index'));
    $trail->push('Supplier List');
});

Breadcrumbs::for('master.customer.index', function($trail) {
    $trail->parent('master');
    $trail->push('Customer', route('master.customer.index'));
    $trail->push('Customer List');
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

Breadcrumbs::for('master.product.create', function($trail) {
    $trail->parent('master');
    $trail->push('Product', route('master.product.create'));
    $trail->push('Add Product');
});

Breadcrumbs::for('master.product.edit', function($trail, $product) {
    $trail->parent('master');
    $trail->push('Product', route('master.product.index'));
    $trail->push('Edit Product', route('master.product.edit', $product->id));
    $trail->push($product->name);
});

Breadcrumbs::for('master.image.index', function($trail) {
    $trail->parent('master');
    $trail->push('Image', route('master.image.index'));
    $trail->push('Image List');
});