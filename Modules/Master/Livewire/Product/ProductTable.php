<?php

namespace Modules\Master\Livewire\Product;

use Exception;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Master\app\Models\MstCategory;
use Modules\Master\app\Models\MstProduct;
use Modules\Master\Enums\StatusEnum;
use Modules\Master\Enums\VisibilityEnum;
use Modules\Master\Services\Product\Destroy\ProductDestroy;
use Modules\Master\traits\WithFlashMessage;

class ProductTable extends Component
{
    use WithPagination, WithFlashMessage;

    public array $filter = [
        'search' => null,
        'category' => null,
        'status' => null,
        'visibility' => null,
    ];

    public array $options = [];

    public function mount()
    {
        $this->options['category'] = MstCategory::where('is_active', true)
            ->pluck('name', 'id')
            ->toArray();

        $enumOptions = [
            'visibility' => VisibilityEnum::class,
            'status' => StatusEnum::class,
        ];

        foreach ($enumOptions as $name => $class) {
            $this->options[$name] = call_user_func([$class, 'array']);
        }
    }

    #[Computed]
    public function products()
    {
        return MstProduct::filter($this->filter)->with(['category', 'units.unit', 'images'])->paginate(10);
    }

    public function delete($id)
    {
        (new ProductDestroy($id))->handle();
        try {

            $this->flashSuccess('Successfully deleted');
            $this->dispatch("close-modal");

            return to_route('master.product.index');
        } catch (Exception $exception) {
            $this->flashError($exception->getMessage());
        }
    }

    public function render()
    {
        return view('master::livewire.product.product-table', [
            "results" => $this->products
        ]);
    }
}
