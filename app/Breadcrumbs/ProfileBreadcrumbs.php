<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('profile', function ($trail) {
    $trail->push('Profile');
});

Breadcrumbs::for('rbac.index', function ($trail) {
    $trail->parent('profile');
    $trail->push('Index', route('rbac.index'));
});


