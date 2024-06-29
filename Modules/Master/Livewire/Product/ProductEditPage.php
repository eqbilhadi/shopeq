<?php

namespace Modules\Master\Livewire\Product;

use Exception;
use Illuminate\Http\UploadedFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Master\app\Models\MstCategory;
use Modules\Master\app\Models\MstProduct;
use Modules\Master\app\Models\MstUnit;
use Modules\Master\Enums\StatusEnum;
use Modules\Master\Enums\VisibilityEnum;
use Modules\Master\Livewire\Validations\ProductUpdateValidations;
use Modules\Master\Services\Product\Registration\ProductRegistration;
use Modules\Master\traits\WithFlashMessage;

class ProductEditPage extends Component
{
    use WithFileUploads, ProductUpdateValidations, WithFlashMessage;

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
                'id' => null,
                'imageable_id' => '',
                'filename' => null,
                'src' => '',
                'is_main_image' => true,
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

    public MstProduct $product;

    public array $options;

    public function mount($product = null)
    {
        // Set product
        $this->setProduct($product);

        // Set images product
        $this->setImageProduct($product->images);
        
        // Set units product
        $this->setUnitProduct($product->units);

        // Register select options
        $this->registerOptions();
    }

    private function registerOptions()
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

    private function setProduct($product)
    {
        $this->product = $product;
        $this->form['name'] = $product->name;
        $this->form['category_id'] = $product->category_id;
        $this->form['description'] = $product->description;
        $this->form['barcode'] = $product->barcode;
        $this->form['minimal_stok'] = $product->minimal_stok;
        $this->form['status'] = $product->status;
        $this->form['visibility'] = $product->visibility;
        $this->form['is_auto_barcode'] = (is_null($product->barcode)) ? true : false;
    }

    private function setImageProduct($img_products)
    {
        foreach ($img_products as $img_product) {
            if ($img_product->is_main_image) {
                $this->form['images']['main_image']['id'] = $img_product->id;
                $this->form['images']['main_image']['imageable_id'] = $img_product->imageable_id;
                $this->form['images']['main_image']['filename'] = $img_product->filename;
                $this->form['images']['main_image']['src'] = $img_product->img_url;
            } else {
                $this->form['images']['other_image'][] = [
                    'id' => $img_product->id,
                    'imageable_id' => $img_product->imageable_id,
                    'filename' => $img_product->filename,
                    'src' => $img_product->img_url,
                    'is_main_image' => false
                ];
            }
        }
    }
    
    private function setUnitProduct($unit_products)
    {
        foreach ($unit_products as $unit_product) {
            if ($unit_product->is_main_unit) {
                $this->form['units']['main_unit']['id'] = $unit_product->id;
                $this->form['units']['main_unit']['unit_id'] = $unit_product->unit_id;
                $this->form['units']['main_unit']['selling_price'] = $unit_product->selling_price;
                $this->form['units']['main_unit']['purchase_price'] = $unit_product->purchase_price;
            } else {
                $this->form['units']['other_unit'][] = [
                    'id' => $unit_product->id,
                    'unit_id' => $unit_product->unit_id,
                    'selling_price' => $unit_product->selling_price,
                    'purchase_price' => $unit_product->purchase_price,
                    'convert_main' => $unit_product->convert_main,
                    'convert_other' => $unit_product->convert_other,
                ];
            }
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
        $other_image = [
            'filename' => $this->form['other_image'],
            'id' => null,
            'imageable_id' => '',
            'src' => '',
            'is_main_image' => false,
        ];
        array_push($this->form['images']['other_image'], $other_image);
        $this->reset('form.other_image');
    }

    public function removeOtherImage($key)
    {
        array_splice($this->form['images']['other_image'], $key, 1);
    }

    public function addOtherUnit()
    {
        $otherUnit = [
            'id' => null,
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

    public function save()
    {
        $this->validate();

        try {
            (new ProductRegistration($this->product, $this->form))->handle();

            $this->flashSuccess('Successfully saved');

            return to_route('master.product.index');
        } catch (Exception $exception) {
            $this->flashError($exception->getMessage());
        }
    }

    public function render()
    {
        return view('master::livewire.product.product-edit-page');
    }
}
