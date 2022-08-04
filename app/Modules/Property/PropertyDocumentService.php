<?php

namespace App\Modules\Property;

use App\Libraries\Crud\CrudService;
use App\Modules\FileUpload\FileUploadService;
use Illuminate\Database\Eloquent\Collection;
use Intervention\Image\Facades\Image;

class PropertyDocumentService extends CrudService
{
    const IMAGE_EXTENSIONS  = [
        'gif', 'jpg', 'jpeg', 'png', 'swf', 'psd', 'bmp',
        'tiff', 'tiff', 'jpc', 'jp2', 'jpf', 'jb2', 'swc',
        'aiff', 'wbmp', 'xbm'
    ];

    protected array $allowedRelations = ['property'];

    private PropertyRepository $propertyRepository;
    private PropertyDocumentRepository $documentRepository;
    private FileUploadService $fileUploadService;

    public function __construct(
        PropertyRepository $propertyRepository,
        PropertyDocumentRepository $repo,
        FileUploadService $fileUploadService
    ) {
        parent::__construct($repo);
        $this->documentRepository = $repo;
        $this->propertyRepository = $propertyRepository;
        $this->fileUploadService = $fileUploadService;
    }

    /**
     * Get all documents
     *
     * @return Collection
     */
    public function getAll(string $propertyId): Collection
    {
        $property = $this->propertyRepository->getOne($propertyId, [
            'fields' => ['id', 'assignee_id', 'assignor_id']
        ]);
        $user = request()->user();

        $options = ['file_path', 'file_type', 'file_name', 'created_at'];
        if ($user->can('view', $property)) {
            $options = ['*'];
        }

        return $this->documentRepository->getAll($propertyId, $options);
    }

    /**
     * @param string $fileType
     */
    public function isImage(string $fileType)
    {
        return in_array($fileType, self::IMAGE_EXTENSIONS);
    }

    /**
     * @param string $documentId
     * @param string $propertyId
     * @return PropertyDocument
     */
    public function getOneOfProperty(string $documentId, string $propertyId): PropertyDocument
    {
        $document = $this->documentRepository->getOneOfProperty($documentId, $propertyId);
        $document || abort(404);

        return $document;
    }

    /**
     * string $imagePath
     */
    public function getImageContent(string $imagePath)
    {
        return $this->fileUploadService->storage()->get($imagePath);
    }

    /**
     * string $documentPath
     */
    public function fullPath(string $documentPath)
    {
        return $this->fileUploadService->storage()->get($documentPath);
    }

    /**
     * string $documentPath
     */
    public function fullPathDocument(string $documentPath)
    {
        return $this->fileUploadService->storage()->path($documentPath);
    }

    /**
     * @param PropertyDocument $document
     */
    public static function url(PropertyDocument $document): string
    {
        return url('api/properties/' . $document->property_id . '/documents/' . $document->id);
    }
}