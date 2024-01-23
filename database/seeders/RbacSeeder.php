<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Rbac\app\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Modules\Rbac\app\Models\Menu;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superadmin = User::create([
            'email' => 'superadmin@test.com',
            'username' => 'superadmin',
            'password' => Hash::make('password'),
            'first_name' => 'System',
            'last_name' => 'Administrator',
        ]);

        $admin = User::create([
            'email' => 'admin@test.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'first_name' => 'Web',
            'last_name' => 'Admin',
        ]);

        $user = User::create([
            'email' => 'user@test.com',
            'username' => 'user',
            'password' => Hash::make('password'),
            'first_name' => 'Web',
            'last_name' => 'User',
        ]);

        $role_spd = Role::create([
            'code' => 'SPD',
            'name' => 'superadmin'
        ]);

        $role_adm = Role::create([
            'code' => 'ADM',
            'name' => 'admin'
        ]);

        $role_usr = Role::create([
            'code' => 'USR',
            'name' => 'user'
        ]);

        $user->roles()->sync([$role_usr->id]);
        $admin->roles()->sync([$role_adm->id]);
        $superadmin->roles()->sync([$role_spd->id, $role_adm->id, $role_usr->id]);

        $accessSettingMenu = Menu::create([
            'icon' => 'fa-solid fa-square-sliders',
            'label_name' => 'Access Settings',
            'controller_name' => 'Modules\Rbac\app\Http\Controllers\RbacController',
            'route_name' => 'rbac.index',
            'url' => 'rbac'
        ]);

        $menuManagement = Menu::create([
            'parent_id' => $accessSettingMenu->id,
            'icon' => 'fa-sharp fa-solid fa-square-list',
            'label_name' => 'Navigation Management',
            'controller_name' => 'Modules\Rbac\app\Http\Controllers\NavigationManagementController',
            'route_name' => 'rbac.nav.index',
            'url' => 'rbac/navigation-management'
        ]);

        $roleManagement = Menu::create([
            'parent_id' => $accessSettingMenu->id,
            'icon' => 'fa-sharp fa-solid fa-shield-keyhole',
            'label_name' => 'Role Management',
            'controller_name' => 'Modules\Rbac\app\Http\Controllers\RoleManagementController',
            'route_name' => 'rbac.role.index',
            'url' => 'rbac/role-management'
        ]);

        $userManagement = Menu::create([
            'parent_id' => $accessSettingMenu->id,
            'icon' => 'fa-solid fa-users-gear',
            'label_name' => 'User Management',
            'controller_name' => 'Modules\Rbac\app\Http\Controllers\UserManagementController',
            'route_name' => 'rbac.user.index',
            'url' => 'rbac/user-management'
        ]);

        $masterData = Menu::create([
            'icon' => 'fa-solid fa-gifts',
            'label_name' => 'Master Data Products',
            'controller_name' => 'Modules\Master\app\Http\Controllers\MasterController',
            'route_name' => 'master.index',
            'url' => 'master'
        ]);

        $category = Menu::create([
            'parent_id' => $masterData->id,
            'icon' => 'fa-solid fa-layer-group',
            'label_name' => 'Category',
            'controller_name' => 'Modules\Master\app\Http\Controllers\CategoryController',
            'route_name' => 'master.category.index',
            'url' => 'master/category'
        ]);

        $unit = Menu::create([
            'parent_id' => $masterData->id,
            'icon' => 'fa-solid fa-weight-scale',
            'label_name' => 'Unit',
            'controller_name' => 'Modules\Master\app\Http\Controllers\UnitController',
            'route_name' => 'master.unit.index',
            'url' => 'master/unit'
        ]);

        $product = Menu::create([
            'parent_id' => $masterData->id,
            'icon' => 'fa-solid fa-box-open',
            'label_name' => 'Product',
            'controller_name' => 'Modules\Master\app\Http\Controllers\ProductController',
            'route_name' => 'master.product.index',
            'url' => 'master/product'
        ]);

        $image = Menu::create([
            'parent_id' => $masterData->id,
            'icon' => 'fa-solid fa-images',
            'label_name' => 'Product Images',
            'controller_name' => 'Modules\Master\app\Http\Controllers\ImageController',
            'route_name' => 'master.image.index',
            'url' => 'master/image'
        ]);

        $role_spd->menus()->sync([
            $accessSettingMenu->id,
            $menuManagement->id,
            $roleManagement->id,
            $userManagement->id,
            $masterData->id,
            $category->id,
            $product->id,
            $unit->id,
            $image->id,
        ]);
    }
}
