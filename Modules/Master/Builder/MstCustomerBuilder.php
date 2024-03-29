<?php

namespace Modules\Master\Builder;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class MstCustomerBuilder extends Builder
{
    public function filter(array $filters = []): self
    {
        $this->when($filters['search'] ?? null, function ($query, $searchText) {
            $query->where(function ($query) use ($searchText) {
                $query->where('name', 'like', '%' . $searchText . '%')
                    ->orWhere('phone', 'like', '%' . $searchText . '%');
            });
        });

        return $this;
    }
}
