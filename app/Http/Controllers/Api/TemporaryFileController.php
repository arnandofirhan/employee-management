<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Helpers\FileHelperRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TemporaryFileController extends Controller
{
    private $fileHelperRepository;

    public function __construct(
        FileHelperRepository $fileHelperRepository
    ) {
        $this->fileHelperRepository = $fileHelperRepository;
    }

    public function index(Request $request): JsonResponse
    {
        $fileDirectory = 'temporary-files';
        if ($request->hasFile('temporary_file')) {
            $file          = $request->file('temporary_file');
            $res = $this->fileHelperRepository->store($fileDirectory, $file);
            if ($res['meta']['success'] === false) {
                return response()->json($res, $res['meta']['code']);
            }

            return response()->json([
                'meta' => [
                    'success'   => true,
                    'code'      => 200,
                    'message'   => 'File uploaded successfully',
                    'errors'    => []
                ],
                'data' => $res['data']['url'],
            ]);
        } else {
            if ($request->hasFile('temporary_files')) {
                $fileUrls = [];
                foreach ($request->file('temporary_files') as $index => $file) {
                    $res = $this->fileHelperRepository->store($fileDirectory, $file);
                    if ($res['meta']['success']) {
                        $fileUrls[$request->input('temporary_file_ids')[$index]] = $res['data']['url'];
                    }
                }

                return response()->json([
                    'meta' => [
                        'success'   => true,
                        'code'      => 200,
                        'message'   => 'File uploaded successfully',
                        'errors'    => []
                    ],
                    'data' => $fileUrls,
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'success'   => false,
                        'code'      => 500,
                        'message'   => 'File uploaded failed',
                        'errors'    => []
                    ],
                    'data' => null,
                ], 500);
            }
        }
    }

    public function base64(Request $request): JsonResponse
    {
        $fileUrl = null;
        $fileDirectory = 'temporary-files';
        $fileUri = $request->input('uri');
        if ($fileUri) {
            if (preg_match('/^data:image\/(\w+);base64,/', $fileUri, $fileExtension)) {
                $fileUri = substr($fileUri, strpos($fileUri, ',') + 1);
                $fileExtension = strtolower($fileExtension[1]);
                if (!in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                    return response()->json([
                        'meta' => [
                            'success'   => false,
                            'code'      => 500,
                            'message'   => 'File format not acceptable',
                            'errors'    => []
                        ],
                        'data' => null,
                    ]);
                }

                $fileUri = str_replace(' ', '+', $fileUri);
                $fileUri = base64_decode($fileUri);

                if ($fileUri === false) {
                    return response()->json([
                        'meta' => [
                            'success'   => false,
                            'code'      => 500,
                            'message'   => 'base64_decode function failed',
                            'errors'    => []
                        ],
                        'data' => null,
                    ]);
                }

                do {
                    $randomString = Str::random(30);
                    $fileName = date('Y_m_d_His_') . $randomString . '.' . $fileExtension;
                } while (Storage::disk('public')->exists($fileUrl = $fileDirectory . '/' . $fileName));

                if (Storage::disk('public')->put($fileUrl, $fileUri) === false) {
                    return response()->json([
                        'meta' => [
                            'success'   => false,
                            'code'      => 500,
                            'message'   => 'File not stored',
                            'errors'    => []
                        ],
                        'data' => null,
                    ]);
                }

                return response()->json([
                    'meta' => [
                        'success'   => true,
                        'code'      => 200,
                        'message'   => 'File uploaded successfully',
                        'errors'    => []
                    ],
                    'data' => $fileUrl,
                ]);
            } else {
                return response()->json([
                    'meta' => [
                        'success'   => false,
                        'code'      => 500,
                        'message'   => 'File not match data URI with image data',
                        'errors'    => []
                    ],
                    'data' => null,
                ]);
            }
        }

        return response()->json([
            'meta' => [
                'success'   => false,
                'code'      => 500,
                'message'   => 'File uploaded failed',
                'errors'    => []
            ],
            'data' => null,
        ], 500);
    }
}
