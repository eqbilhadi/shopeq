<?php

namespace Modules\Purchasing\Livewire\Components;

use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Modules\Master\app\Models\MstProduct;

class SearchProduct extends Component
{
    public $key;
    #[Validate('min:2', message: 'Type at least 2 character')]
    public $product;
    public $productName;
    public $limitPage = 10;
    public $isSelected = false;

    public function mount($keys, $productname)
    {
        $this->key = $keys;
        if ($productname != '') {
            $this->productName = $productname;
            $this->isSelected = true;
        }
    }

    #[Computed]
    public function products()
    {
        if (strlen($this->product) >= 2 && !$this->isSelected) {
            return MstProduct::query()
                ->where(function ($query) {
                    $query->where('name', 'like', "%{$this->product}%");
                    $query->orWhere('barcode', 'like', "%{$this->product}%");
                })
                ->paginate($this->limitPage);
        }
    }

    public function loadMore()
    {
        $this->limitPage += 4;
    }

    public function updatingProduct()
    {
        $this->isSelected = false;
    }

    public function selectProduct($id, $key)
    {
        $product = MstProduct::find($id);
        $this->isSelected = true;
        $this->productName = $product->name;
        $this->product = "";


        $this->dispatch('select-product', productId: $id, key: $key);
    }

    public function resetProduct()
    {
        $this->isSelected = false;
        $this->productName = "";

        $this->dispatch('reset-product', key: $this->key);
    }

    public function render()
    {
        return view('purchasing::livewire.components.search-product');
    }
}
