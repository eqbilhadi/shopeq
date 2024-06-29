<?php

namespace Modules\Master\Builder;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class MstProductBuilder extends Builder
{
    public function filter(array $filters = []): self
    {
        $this->when($filters['search'] ?? false, function ($query, $searchText) {
            $query->where(function ($query) use ($searchText) {
                $query->where('name', 'like', '%' . $searchText . '%');
            });
        });

        $this->when($filters['category'] ?? false, function ($query, $category) {
            $query->where('category_id', $category);
        });
        
        $this->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });
        
        $this->when($filters['visibility'] ?? false, function ($query, $visibility) {
            $query->where('visibility', $visibility);
        });

        return $this;
    }

    public function generateAutomaticBarcode($prefix = null, $length = 12)
    {
        do {
            $randomCharacters = Str::random($length);
            $barcode = $prefix . $randomCharacters;
            $existingBarcode = self::where('barcode', $barcode)->first();
        } while ($existingBarcode);

        return $barcode;
    }
}
