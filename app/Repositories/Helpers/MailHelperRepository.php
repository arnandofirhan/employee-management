<?php

namespace App\Repositories\Helpers;

use App\Constants\MailCategoryConstant;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Mail;

class MailHelperRepository
{
    public function send($query): array
    {
        try {
            if ($query->category !== MailCategoryConstant::OUTBOX) {
                $res = [
                    'meta' => [
                        'success'   => false,
                        'code'      => 403,
                        'message'   => 'Mail category not allowed',
                        'errors'    => []
                    ],
                    'data' => null,
                ];
            } else {
                Mail::send(new SendEmail($query));
                if ($query->mailHistories === null) {
                    $query->transaction_time = date('Y-m-d H:i:s');
                }
                $query->save();

                $query->mailHistories()->create([
                    'transaction_time' => $query->transaction_time,
                ]);

                $res = [
                    'meta' => [
                        'success'   => true,
                        'code'      => 200,
                        'message'   => 'Mail sent successfully',
                        'errors'    => []
                    ],
                    'data' => $query,
                ];
            }
        } catch (\Exception $e) {
            $res = [
                'meta' => [
                    'success'   => false,
                    'code'      => \App\Constants\StatusCodeConstant::label($e->getCode()) ? $e->getCode() : 500,
                    'message'   => $e->getMessage(),
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return $res;
    }
}
