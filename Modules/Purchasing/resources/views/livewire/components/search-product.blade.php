<div>
    <div class="w-full">
        <div class="">
            <div class="form-icon right">
                <input type="text" class="form-control form-control-sm" placeholder="Search product" id="productId{{ $key }}" @if (!$isSelected) wire:model.live.debounce.300="product" @else wire:model="productName" @readonly(true) wire:click="resetProduct" @endif autocomplete="off">
                <i class="fa-solid fa-spinner-third fa-spin ms-5" style="--fa-animation-duration: 0.7s;" wire:loading.flex wire:target="selectProduct,product,resetProduct,loadMore"></i>
            </div>
        </div>
        @error('product')
            <small class="text-danger" style="font-size: 8pt">{{ $message }}</small>
        @enderror
        @isset($this->products)
            <ul class="dropdown-menu show overflow-auto" id="product-list" style="max-height: 200px">
                @forelse ($this->products as $prd)
                    <li wire:key='{{ $loop->index }}'>
                        <a class="dropdown-item" href="javascript:void(0);" wire:click='selectProduct("{{ $prd->id }}","{{ $key }}")'>
                            <div class="fw-bold">{{ $prd->name }}</div>
                            <div class="small">{{ $prd->barcode }}</div>
                        </a>
                    </li>
                @empty
                    <li class="p-2">Product data not found</li>
                @endforelse
                <div x-data="{
                    observe() {
                        const observer = new IntersectionObserver((product) => {
                            product.forEach(prd => {
                                if (prd.isIntersecting) {
                                    @this.loadMore()
                                }
                            })
                        })
                        observer.observe(this.$el)
                    }
                }" x-init="observe"></div>
            </ul>
        @endisset
    </div>
    @script
        <script>
            document.addEventListener('livewire:initialized', function() {

            });
            Livewire.hook('component.init', ({
                component,
                cleanup
            }) => {
                $("#productId{{ $key }}").focus();
            })
        </script>
    @endscript
</div>
