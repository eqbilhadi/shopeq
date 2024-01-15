<?php

use Diglactic\Breadcrumbs\Breadcrumbs;

Breadcrumbs::for('rbac', function($trail){
    $trail->push('Rbac');
});

Breadcrumbs::for('rbac.nav.index', function($trail) {
    $trail->parent('rbac');
    $trail->push('Navigation Management', route('rbac.nav.index'));
    $trail->push('Navigation List');
});

Breadcrumbs::for('rbac.nav.create', function($trail) {
    $trail->parent('rbac');
    $trail->push('Navigation Management', route('rbac.nav.index'));
    $trail->push('Create Navigation');
});

Breadcrumbs::for('rbac.nav.edit', function($trail, $menu) {
    $trail->parent('rbac');
    $trail->push('Navigation Management', route('rbac.nav.index'));
    $trail->push('Edit Navigation', route('rbac.nav.edit', $menu->id));
    $trail->push($menu->label_name);
});

Breadcrumbs::for('rbac.user.index', function($trail) {
    $trail->parent('rbac');
    $trail->push('User Management', route('rbac.user.index'));
    $trail->push('User List');
});

Breadcrumbs::for('rbac.user.create', function($trail) {
    $trail->parent('rbac');
    $trail->push('User Management', route('rbac.user.index'));
    $trail->push('Create User');
});

Breadcrumbs::for('rbac.user.edit', function($trail, $menu) {
    $trail->parent('rbac');
    $trail->push('User Management', route('rbac.user.index'));
    $trail->push('Edit User', route('rbac.user.edit', $menu->id));
    $trail->push($menu->full_name);
});

Breadcrumbs::for('rbac.role.index', function($trail) {
    $trail->parent('rbac');
    $trail->push('Role Management', route('rbac.role.index'));
    $trail->push('Role List');
});

Breadcrumbs::for('rbac.role.create', function($trail) {
    $trail->parent('rbac');
    $trail->push('Role Management', route('rbac.role.index'));
    $trail->push('Create Role');
});

Breadcrumbs::for('rbac.role.edit', function($trail, $menu) {
    $trail->parent('rbac');
    $trail->push('Role Management', route('rbac.role.index'));
    $trail->push('Manage Role', route('rbac.role.edit', $menu->id));
    $trail->push($menu->name);
});