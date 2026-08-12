<?php

namespace BinshopsBlog\Requests;

use BinshopsBlog\Interfaces\BaseRequestInterface;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class BaseRequest
 */
abstract class BaseRequest extends FormRequest implements BaseRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return \Auth::check() && \Auth::user()->canManageBinshopsBlogPosts();
    }
}
