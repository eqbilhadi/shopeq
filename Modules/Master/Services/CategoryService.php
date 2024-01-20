<?php

namespace Modules\Master\Services;

use Illuminate\Support\Str;
use Modules\Master\Repositories\CategoryRepository;

class CategoryService
{
    public function __construct(
        protected CategoryRepository $categoryRepository,
    ) {
    }

    public function getCategory()
    {
        return $this->categoryRepository->getCategory()->get();
    }

    public function getPageDataCategory($filter = [])
    {
        $query = $this->categoryRepository->getCategory()->orderBy('created_at', 'desc');

        if (isset($filter['search']) && $filter['search'] != null) {
            $query->where('name', 'like', '%' . $filter['search'] . '%');
        }

        return $query->paginate(10)->setPath(route('master.category.index'));
    }

    public function getCategoryById($id)
    {
        return $this->categoryRepository->getCategory()->whereId($id)->first();
    }

    public function store($form)
    {
        $slug = $this->checkSlug(Str::slug($form['name']));

        $params = [
            'name' => $form['name'],
            'slug' => $slug,
            'is_active' => $form['status'],
        ];

        $this->categoryRepository->insert($params);
    }

    public function update($form, $id)
    {
        $slug = $this->checkSlugUpdate(Str::slug($form['name']), $id);

        $params = [
            'name' => $form['name'],
            'slug' => $slug
        ];

        $this->categoryRepository->update($params, $id);
    }

    public function deleteCategory($id)
    {
        $this->categoryRepository->delete($id);
    }

    public function checkSlug($string)
    {
        $slug = $string;
        while ($this->categoryRepository->getCategory()->whereSlug($string)->first()) {
            $string = $slug . "-" . Str::random(5);
        }
        return $string;
    }

    public function checkSlugUpdate($string, $id)
    {
        $slug = $string;
        while ($this->categoryRepository->getCategory()->whereSlug($string)->where("id", "<>", $id)->first()) {
            $string = $slug . "-" . Str::random(5);
        }
        return $string;
    }
}
