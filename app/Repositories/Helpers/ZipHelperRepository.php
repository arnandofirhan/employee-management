<?php

namespace App\Repositories\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class ZipHelperRepository
{
    protected $app;
    private $fileHelperRepository;

    public function __construct(
        FileHelperRepository $fileHelperRepository,
    ) {
        $this->fileHelperRepository = $fileHelperRepository;
    }

    public function store(array $data): ?array
    {
        if (is_array($data)) {
            $fileDirectory = $this->fileHelperRepository->temporaryDirectory;
            do {
                $randomString = Str::random(30);
                $fileName = date('Y_m_d_His_') . $randomString . '.zip';
            } while (Storage::disk('public')->exists($fileUrl = $fileDirectory . '/' . $fileName));

            $zip = new ZipArchive;
            if ($zip->open(public_path('storage/' . $fileUrl), ZipArchive::CREATE) === true) {
                foreach ($data as $item) {
                    if (Storage::disk('public')->exists($item['url'])) {
                        $item = public_path('storage/' . $item['url']);
                        $zip->addFile($item, basename($item));
                    }
                }
                $zip->close();

                if (Storage::disk('public')->exists($fileUrl) === null) {
                    return [
                        'meta' => [
                            'success'   => false,
                            'code'      => 404,
                            'message'   => 'File not found',
                            'errors'    => []
                        ],
                        'data' => null,
                    ];
                }

                return [
                    'meta' => [
                        'success'   => true,
                        'code'      => 200,
                        'message'   => 'Invoice saved successfully',
                        'errors'    => []
                    ],
                    'data' => [
                        'name' => $fileName,
                        'mime_type' => mime_content_type(public_path('storage/' . $fileUrl)),
                        'size' => Storage::disk('public')->size($fileUrl),
                        'url' => $fileUrl,
                    ],
                ];
            } else {
                return [
                    'meta' => [
                        'success'   => false,
                        'code'      => 500,
                        'message'   => 'Zip created failed',
                        'errors'    => []
                    ],
                    'data' => null,
                ];
            }
        } else {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 500,
                    'message'   => 'Data not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }
    }
}
