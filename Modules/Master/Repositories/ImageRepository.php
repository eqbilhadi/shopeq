<?php

namespace Modules\Master\Repositories;

use App\Repositories\BaseRepository;
use Modules\Master\app\Models\MstImage;

class ImageRepository extends BaseRepository
{
    public function __construct(MstImage $model)
    {
        parent::__construct($model);
    }

    public function getImage()
    {
        return $this->model;
    }
}