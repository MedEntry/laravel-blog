<?php

namespace BinshopsBlog\Requests;

use Illuminate\Validation\Rule;

class StoreBinshopsBlogCategoryRequest extends BaseBinshopsBlogCategoryRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $return = $this->baseCategoryRules();
        $return['slug'][] = Rule::unique('binshops_blog_categories', 'slug');

        return $return;
    }
}
