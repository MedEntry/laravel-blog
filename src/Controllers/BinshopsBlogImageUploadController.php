<?php

namespace BinshopsBlog\Controllers;

use App\Http\Controllers\Controller;
use BinshopsBlog\Models\BinshopsBlogUploadedPhoto;
use BinshopsBlog\Requests\UploadImageRequest;
use BinshopsBlog\Traits\UploadFileTrait;
use File;
use Illuminate\View\View;

/**
 * Class BinshopsBlogAdminController
 */
class BinshopsBlogImageUploadController extends Controller
{
    use UploadFileTrait;

    /**
     * BinshopsBlogAdminController constructor.
     */
    public function __construct()
    {
        if (! is_array(config('binshopsblog'))) {
            throw new \RuntimeException('The config/binshopsblog.php does not exist. Publish the vendor files for the Binshops Blog package by running the php artisan publish:vendor command');
        }

        if (! config('binshopsblog.image_upload_enabled')) {
            throw new \RuntimeException('The binshopsblog.php config option has not enabled image uploading');
        }
    }

    /**
     * Show the main listing of uploaded images
     */
    public function index(): View
    {
        return view('binshopsblog_admin::imageupload.index', ['uploaded_photos' => BinshopsBlogUploadedPhoto::orderBy('id', 'desc')->paginate(10)]);
    }

    /**
     * show the form for uploading a new image
     */
    public function create(): View
    {
        return view('binshopsblog_admin::imageupload.create', []);
    }

    /**
     * Save a new uploaded image
     *
     * @throws \Exception
     */
    public function store(UploadImageRequest $request): View
    {
        $processed_images = $this->processUploadedImages($request);

        return view('binshopsblog_admin::imageupload.uploaded', ['images' => $processed_images]);
    }

    /**
     * Process any uploaded images (for featured image)
     *
     *
     * @return array returns an array of details about each file resized.
     *
     * @throws \Exception
     *
     * @todo - This class was added after the other main features, so this duplicates some code from the main blog post admin controller (BinshopsBlogAdminController). For next full release this should be tided up.
     */
    protected function processUploadedImages(UploadImageRequest $request): array
    {
        $this->increaseMemoryLimit();
        $photo = $request->file('upload');

        // to save in db later
        $uploaded_image_details = [];

        $sizes_to_upload = $request->input('sizes_to_upload');
        $suggested_title = ($request->has('image_title')) ? $request->input('image_title') : null;

        // now upload a full size - this is a special case, not in the config file.
        // We only store full size images in this class, not as part of the featured blog image uploads.
        if (isset($sizes_to_upload['BinshopsBlog_full_size']) && $sizes_to_upload['BinshopsBlog_full_size'] === 'true') {
            $uploaded_image_details['BinshopsBlog_full_size'] = $this->UploadAndResize($suggested_title, 'fullsize', $photo);
        }

        foreach ((array) config('binshopsblog.image_sizes') as $size => $image_size_details) {

            if (! isset($sizes_to_upload[$size]) || ! $sizes_to_upload[$size] || ! $image_size_details['enabled']) {
                continue;
            }

            // this image size is enabled, and
            // we have an uploaded image that we can use
            $uploaded_image_details[$size] = $this->UploadAndResize($suggested_title, $image_size_details, $photo, null);
        }

        // store the image upload.
        BinshopsBlogUploadedPhoto::create([
            'image_title' => $request->input('image_title'),
            'source' => 'ImageUpload',
            'uploader_id' => optional(\Auth::user())->id,
            'uploaded_images' => $uploaded_image_details,
        ]);

        return $uploaded_image_details;
    }
}
