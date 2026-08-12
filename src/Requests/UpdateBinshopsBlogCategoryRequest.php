<?php

namespace BinshopsBlog\Requests;

use Illuminate\Validation\Rule;

class UpdateBinshopsBlogCategoryRequest extends BaseBinshopsBlogCategoryRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $return = $this->baseCategoryRules();
        $return['slug'][] = Rule::unique('binshops_blog_categories', 'slug')->ignore($this->route()->parameter('categoryId'));

        return $return;

    }
}
