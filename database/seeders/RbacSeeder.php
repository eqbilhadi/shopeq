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
            'url' => 'rbac',
            'is_dropdown' => false
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
            'label_name' => 'Master Data',
            'controller_name' => 'Modules\Master\app\Http\Controllers\MasterController',
            'route_name' => 'master.index',
            'url' => 'master',
            'is_dropdown' => false
        ]);

        $supplier = Menu::create([
            'parent_id' => $masterData->id,
            'icon' => 'fa-sharp fa-solid fa-boxes-packing',
            'label_name' => 'Supplier',
            'controller_name' => 'Modules\Master\app\Http\Controllers\SupplierController',
            'route_name' => 'master.supplier.index',
            'url' => 'master/supplier'
        ]);

        $customer = Menu::create([
            'parent_id' => $masterData->id,
            'icon' => 'fa-solid fa-person-carry-box',
            'label_name' => 'Customer',
            'controller_name' => 'Modules\Master\app\Http\Controllers\CustomerController',
            'route_name' => 'master.customer.index',
            'url' => 'master/customer'
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

        $purchasing = Menu::create([
            'icon' => 'fa-duotone fa-money-bill',
            'label_name' => 'Purchasing',
            'controller_name' => 'Modules\Purchasing\app\Http\Controllers\PurchasingController',
            'route_name' => 'purchasing.index',
            'url' => 'purchasing',
            'is_dropdown' => false
        ]);

        $invoice = Menu::create([
            'parent_id' => $purchasing->id,
            'icon' => 'fa-solid fa-file-invoice',
            'label_name' => 'Purchasing Invoice',
            'controller_name' => 'Modules\Purchasing\app\Http\Controllers\InvoiceController',
            'route_name' => 'purchasing.invoice.index',
            'url' => 'purchasing/invoice'
        ]);

        $retur = Menu::create([ 
            'parent_id' => $purchasing->id,
            'icon' => 'fa-solid fa-sack-xmark',
            'label_name' => 'Purchasing Retur',
            'controller_name' => 'Modules\Purchasing\app\Http\Controllers\ReturController',
            'route_name' => 'purchasing.retur.index',
            'url' => 'purchasing/retur'
        ]);

        $settings = Menu::create([
            'icon' => 'fa-sharp fa-solid fa-gears',
            'label_name' => 'Settings',
            'controller_name' => 'Modules\Settings\app\Http\Controllers\SettingsController',
            'route_name' => 'settings.index',
            'url' => 'settings',
            'is_dropdown' => false
        ]);

        $theme = Menu::create([ 
            'parent_id' => $settings->id,
            'icon' => 'fa-duotone fa-brush',
            'label_name' => 'Website Theme',
            'controller_name' => 'Modules\Settings\app\Http\Controllers\ThemeController',
            'route_name' => 'settings.theme.index',
            'url' => 'settings/theme'
        ]);

        $role_spd->menus()->sync([
            $accessSettingMenu->id,
            $menuManagement->id,
            $roleManagement->id,
            $userManagement->id,
            $masterData->id,
            $supplier->id,
            $customer->id,
            $category->id,
            $product->id,
            $unit->id,
            $image->id,
            $purchasing->id,
            $invoice->id,
            $retur->id,
            $settings->id,
            $theme->id
        ]);

        $this->command->info('Rbac seeded.');
    }
}
