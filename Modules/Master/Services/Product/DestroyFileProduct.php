<?php

namespace Modules\Master\Services\Product;

use Modules\Master\app\Models\MstImage;
use Modules\Master\app\Models\MstProduct;

class DestroyFileProduct
{    
    public static function destroyByPath($path)
    {
        $deletePath = public_path($path);
        if (file_exists($deletePath)) {
            unlink($deletePath);
        }
    }

    public static function destroyById($id)
    {
        $imagesToDelete = MstImage::where('id', $id)->first();

        if ($imagesToDelete?->filename != null) {
            $deletePath = public_path($imagesToDelete->filename);
            if (file_exists($deletePath)) {
                unlink($deletePath);
            }
        }
    }

    public static function destroyByImageableId($id)
    {
        $imagesToDelete = MstImage::where('imageable_id', $id)->get();
        
        foreach ($imagesToDelete as $key => $imageToDelete) {
            if ($imageToDelete?->filename != null) {
                $deletePath = public_path($imageToDelete->filename);
                if (file_exists($deletePath)) {
                    unlink($deletePath);
                }
            }
        }
    }
}
