<?php

namespace App\Repositories\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileHelperRepository
{
    public string $temporaryDirectory = 'temporary-files';

    public function info($url)
    {
        if (Storage::disk('public')->exists($url)) {
            $fullUrl = public_path('storage/' . $url);
            $pathInfo = pathinfo($fullUrl);

            return [
                'meta' => [
                    'success'   => true,
                    'code'      => 200,
                    'message'   => 'File found',
                    'errors'    => []
                ],
                'data' => [
                    'name' => $pathInfo['filename'],
                    'full_name' => $pathInfo['basename'],
                    'extension' => $pathInfo['extension'],
                    'mime_type' => mime_content_type($fullUrl),
                    'size' => Storage::disk('public')->size($url),
                    'url' => $url,
                    'full_url' => $fullUrl,
                    'link' => asset('storage/' . $url),
                ],
            ];
        }

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

    public function store($directory, $file): ?array
    {
        do {
            $name      = date('Y_m_d_His_') . $file->hashName();
        } while (Storage::disk('public')->exists($directory . '/' . $name));
        $url    = $file->storeAs($directory, $name, 'public') ?? null;

        $res = $this->info($url);
        if ($res['meta']['success'] === false) {
            return $res;
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'File stored successfully',
                'errors'    => []
            ],
            'data' => $res['data'],
        ];
    }

    public function storeByUri($fileDirectory, $fileUri): array
    {
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

                $res = $this->info($fileUrl);
                if ($res['meta']['success'] === false) {
                    return $res;
                }

                return response()->json([
                    'meta' => [
                        'success'   => true,
                        'code'      => 200,
                        'message'   => 'File uploaded successfully',
                        'errors'    => []
                    ],
                    'data' => $res['data'],
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

    public function copy($originUrl, $targetDirectory, $prefixName = null, $suffixName = null)
    {
        if (Storage::disk('public')->exists($originUrl)) {
            $pathInfo = pathinfo($originUrl);
            $name = str_replace(' ', '_', $pathInfo['filename']);
            $extension = $pathInfo['extension'];
            $newUrl = $targetDirectory . '/' . ($prefixName ? str_replace(' ', '_', $prefixName) . '_' : '') . $name . ($suffixName ? '_' . str_replace(' ', '_', $suffixName) : '') . '.' . $extension;
            if ($originUrl !== $newUrl && Storage::disk('public')->copy($originUrl, $newUrl)) {
                return $newUrl;
            }
        }

        return $originUrl;
    }

    public function move($originUrl, $targetDirectory, $prefixName = null, $suffixName = null)
    {
        if (Storage::disk('public')->exists($originUrl)) {
            $pathInfo = pathinfo($originUrl);
            $name = str_replace(' ', '_', $pathInfo['filename']);
            $extension = $pathInfo['extension'];
            $newUrl = $targetDirectory . '/' . ($prefixName ? str_replace(' ', '_', $prefixName) . '_' : '') . $name . ($suffixName ? '_' . str_replace(' ', '_', $suffixName) : '') . '.' . $extension;
            if ($originUrl !== $newUrl && Storage::disk('public')->move($originUrl, $newUrl)) {
                return $newUrl;
            }
        }

        return $originUrl;
    }

    public function remove($url): bool
    {
        if (Storage::disk('public')->exists($url) && Storage::disk('public')->delete($url)) {
            return true;
        }

        return false;
    }

    public function moveBackToTemporaryDirectory($previousUrl)
    {
        if (Storage::disk('public')->exists($previousUrl)) {
            $pathInfo = pathinfo($previousUrl);
            $newUrl =  $this->temporaryDirectory . '/' . $pathInfo['basename'];
            if ($previousUrl !== $newUrl && Storage::disk('public')->move($previousUrl, $newUrl)) {
                return $newUrl;
            }
        }

        return $previousUrl;
    }
}
