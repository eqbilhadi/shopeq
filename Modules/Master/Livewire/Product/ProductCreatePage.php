<?php

namespace Modules\Master\Livewire\Product;

use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Master\app\Models\MstCategory;
use Modules\Master\app\Models\MstUnit;
use Modules\Master\Enums\StatusEnum;
use Modules\Master\Enums\VisibilityEnum;
use Modules\Master\Livewire\Validations\ProductCreateValidations;
use Modules\Master\Services\Product\Registration\ProductRegistration;
use Modules\Master\traits\WithFlashMessage;

class ProductCreatePage extends Component
{
    use WithFileUploads, ProductCreateValidations, WithFlashMessage;

    public array $form = [
        'name' => '',
        'category_id' => '',
        'description' => '',
        'barcode' => '',
        'minimal_stok' => '',
        'status' => '',
        'visibility' => '',
        'other_image' => '',
        'is_auto_barcode' => true,
        'images' => [
            'main_image' => [
                'filename' => null,
                'is_main_image' => true
            ],
            'other_image' => []
        ],
        'units' => [
            'main_unit' => [
                'unit_id' => '',
                'is_main_unit' => true,
                'selling_price' => '',
                'purchase_price' => '',
            ],
            'other_unit' => []
        ]
    ];

    public array $options = [];

    public function mount()
    {
        $this->options['category'] = MstCategory::where('is_active', true)
            ->get()
            ->toArray();

        $this->options['unit'] = MstUnit::all()
            ->toArray();

        $enumOptions = [
            'visibility' => VisibilityEnum::class,
            'status' => StatusEnum::class,
        ];

        foreach ($enumOptions as $name => $class) {
            $this->options[$name] = call_user_func([$class, 'array']);
        }
    }

    public function save()
    {
        $this->validate();

        try {
            (new ProductRegistration(null, $this->form))->handle();

            $this->flashSuccess('Successfully saved');

            return to_route('master.product.index');
        } catch (Exception $exception) {
            $this->flashError($exception->getMessage());
        }
    }

    public function updatedForm($value, $key)
    {
        if ($key == 'images.main_image.filename') {
            $this->validateOnly('form.images.main_image.filename');
        }
    }

    public function updatedFormOtherImage()
    {
        $this->validateOnly('form.other_image');
        array_push($this->form['images']['other_image'], $this->form['other_image']);
        $this->reset('form.other_image');
    }

    public function removeOtherImage($key)
    {
        array_splice($this->form['images']['other_image'], $key, 1);
    }

    public function addOtherUnit()
    {
        $otherUnit = [
            'unit_id' => '',
            'is_main_unit' => false,
            'convert_main' => '',
            'convert_other' => '',
            'selling_price' => '',
            'purchase_price' => '',
        ];

        array_push($this->form['units']['other_unit'], $otherUnit);
    }

    public function removeOtherUnit($key)
    {
        array_splice($this->form['units']['other_unit'], $key, 1);
    }

    public function render()
    {
        return view('master::livewire.product.product-create-page');
    }
}
