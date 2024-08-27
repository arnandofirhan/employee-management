<?php

namespace App\Repositories\Mails;

use App\Exceptions\InvalidModelException;
use App\Models\Mail;
use App\Repositories\Helpers\FileHelperRepository;
use App\Repositories\Helpers\MailHelperRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;

class MailRepository
{
    protected $app;
    private $fileHelperRepository;
    private $mailHelperRepository;

    public function __construct(
        Application $app,

        FileHelperRepository $fileHelperRepository,
        MailHelperRepository $mailHelperRepository,
    ) {
        $this->app = $app;
        $this->makeModel();

        $this->fileHelperRepository = $fileHelperRepository;
        $this->mailHelperRepository = $mailHelperRepository;
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new InvalidModelException($this->model());
        }

        return $this->model = $model;
    }

    public function model()
    {
        return Mail::class;
    }

    public function query(array $advancedQuery = []): QueryBuilder
    {
        $query =  $this->model->query()
            ->selectRaw('
                mails.id                                AS id,
                mails.category                          AS category,
                mails.transaction_time                  AS transaction_time,
                mails.sender_full_name                  AS sender_full_name,
                mails.sender_mail_address               AS sender_mail_address,
                mails.recipient_mail_addresses          AS recipient_mail_addresses,
                mails.carbon_copy_mail_addresses        AS carbon_copy_mail_addresses,
                mails.blind_carbon_copy_mail_addresses  AS blind_carbon_copy_mail_addresses,
                mails.subject                           AS subject,
                mails.body                              AS body
            ');

        if ($advancedQuery && count($advancedQuery)) {
        }

        $query = $query->orderBy('mails.transaction_time');

        return $query;
    }

    public function find(string $id, array $with = [])
    {
        return $this->model->query()->with($with)->find($id);
    }

    public function findOrFail(string $id, array $with = [])
    {
        return $this->model->query()->with($with)->findOrFail($id);
    }

    public function list(array $advancedQuery = []): array
    {
        $query = $this->with([
            'mailRecipients',
            'mailCarbonCopies',
            'mailBlindCarbonCopies',
            'mailAttachments',
        ])->query();

        if ($advancedQuery && count($advancedQuery)) {
        }

        $query = $query->get();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => '',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function store(array $data): array
    {
        $query = $this->model->query()->create([
            'category' => $data['category'],
            'transaction_time' => $data['transaction_time'],

            'sender_full_name' => $data['sender_full_name'],
            'sender_mail_address' => $data['sender_mail_address'],

            'recipient_mail_addresses' => $data['recipient_mail_addresses'],
            'carbon_copy_mail_addresses' => $data['carbon_copy_mail_addresses'],
            'blind_carbon_copy_mail_addresses' => $data['blind_carbon_copy_mail_addresses'],

            'subject' => $data['subject'],
            'body' => $data['body'],
        ]);

        $items = [];
        if (array_key_exists('recipient_mail_addresses', $data)) {
            $items = explode(";", $data['recipient_mail_addresses']);
            $data['recipient_mail_addresses'] = '';
            foreach ($items as $item) {
                $item = preg_replace('/\s+/', '', $item);
                if ($item !== '') {
                    $execute = $query->mailRecipients()->create([
                        'mail_address' => $item,
                    ]);
                    if ($data['recipient_mail_addresses'] !== '') {
                        $data['recipient_mail_addresses'] .= ';';
                    }
                    $data['recipient_mail_addresses'] .= $execute->mail_address;
                }
            }
            $query->recipient_mail_addresses = $data['recipient_mail_addresses'];
        }

        $items = [];
        if (array_key_exists('carbon_copy_mail_addresses', $data)) {
            $items = explode(";", $data['carbon_copy_mail_addresses']);
            $data['carbon_copy_mail_addresses'] = '';
            foreach ($items as $item) {
                $item = preg_replace('/\s+/', '', $item);
                if ($item !== '') {
                    $execute = $query->mailCarbonCopies()->create([
                        'mail_address' => $item,
                    ]);
                    if ($data['carbon_copy_mail_addresses'] !== '') {
                        $data['carbon_copy_mail_addresses'] .= ';';
                    }
                    $data['carbon_copy_mail_addresses'] .= $execute->mail_address;
                }
            }
            $query->carbon_copy_mail_addresses = $data['carbon_copy_mail_addresses'];
        }

        $items = [];
        if (array_key_exists('blind_carbon_copy_mail_addresses', $data)) {
            $items = explode(";", $data['blind_carbon_copy_mail_addresses']);
            $data['blind_carbon_copy_mail_addresses'] = '';
            foreach ($items as $item) {
                $item = preg_replace('/\s+/', '', $item);
                if ($item !== '') {
                    $execute = $query->mailBlindCarbonCopies()->create([
                        'mail_address' => $item,
                    ]);
                    if ($data['blind_carbon_copy_mail_addresses'] !== '') {
                        $data['blind_carbon_copy_mail_addresses'] .= ';';
                    }
                    $data['blind_carbon_copy_mail_addresses'] .= $execute->mail_address;
                }
            }
            $query->blind_carbon_copy_mail_addresses = $data['blind_carbon_copy_mail_addresses'];
        }

        $query->save();

        if (array_key_exists('attachments', $data) && is_array($data['attachments'])) {
            foreach ($data['attachments'] as $item) {
                $itemUrl = $this->fileHelperRepository->copy($item['url'], 'mail-attachments', array_key_exists('prefix', $item) ? $item['prefix'] : null);
                $query->mailAttachments()->create([
                    'name' => $item['name'],
                    'mime_type' => $item['mime_type'],
                    'size' => $item['size'],
                    'url' => $itemUrl,
                ]);
            }
        }

        $query = $this->find($query->id, [
            'mailRecipients',
            'mailCarbonCopies',
            'mailBlindCarbonCopies',
            'mailAttachments',
        ]);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Mail created successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function show(string $id): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'Mail not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => '',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function update(string $id, array $data): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'Mail not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->category = $data['category'];
        $query->transaction_time = $data['transaction_time'];
        $query->sender_full_name = $data['sender_full_name'];
        $query->sender_mail_address = $data['sender_mail_address'];
        $query->recipient_mail_addresses = $data['recipient_mail_addresses'];
        $query->carbon_copy_mail_addresses = $data['carbon_copy_mail_addresses'];
        $query->blind_carbon_copy_mail_addresses = $data['blind_carbon_copy_mail_addresses'];
        $query->subject = $data['subject'];
        $query->body = $data['body'];

        $items = [];
        $itemIds = $query->mailRecipients->pluck("id", "id");
        if (array_key_exists('recipient_mail_addresses', $data)) {
            $items = explode(";", $data['recipient_mail_addresses']);
            $data['recipient_mail_addresses'] = '';
            foreach ($items as $item) {
                $item = preg_replace('/\s+/', '', $item);
                if ($item !== '') {
                    $execute = $query->mailRecipients()->where('mail_address', $item)->first();
                    if ($execute) {
                        if ($itemIds->contains($execute->id)) {
                            $itemIds->forget($execute->id);
                        }
                    } else {
                        $execute = $query->mailRecipients()->create([
                            'mail_address' => $item,
                        ]);
                    }

                    if ($data['recipient_mail_addresses'] !== '') {
                        $data['recipient_mail_addresses'] .= ';';
                    }
                    $data['recipient_mail_addresses'] .= $execute->mail_address;
                }
            }
            $query->recipient_mail_addresses = $data['recipient_mail_addresses'];
        }
        if ($itemIds->count()) {
            $query->mailRecipients()->whereIn('id', $itemIds->toArray())->delete();
        }

        $items = [];
        $itemIds = $query->mailCarbonCopies->pluck("id", "id");
        if (array_key_exists('carbon_copy_mail_addresses', $data)) {
            $items = explode(";", $data['carbon_copy_mail_addresses']);
            $data['carbon_copy_mail_addresses'] = '';
            foreach ($items as $item) {
                $item = preg_replace('/\s+/', '', $item);
                if ($item !== '') {
                    $execute = $query->mailCarbonCopies()->where('mail_address', $item)->first();
                    if ($execute) {
                        if ($itemIds->contains($execute->id)) {
                            $itemIds->forget($execute->id);
                        }
                    } else {
                        $execute = $query->mailCarbonCopies()->create([
                            'mail_address' => $item,
                        ]);
                    }

                    if ($data['carbon_copy_mail_addresses'] !== '') {
                        $data['carbon_copy_mail_addresses'] .= ';';
                    }
                    $data['carbon_copy_mail_addresses'] .= $execute->mail_address;
                }
            }
            $query->carbon_copy_mail_addresses = $data['carbon_copy_mail_addresses'];
        }
        if ($itemIds->count()) {
            $query->mailCarbonCopies()->whereIn('id', $itemIds->toArray())->delete();
        }

        $items = [];
        $itemIds = $query->mailBlindCarbonCopies->pluck("id", "id");
        if (array_key_exists('blind_carbon_copy_mail_addresses', $data)) {
            $items = explode(";", $data['blind_carbon_copy_mail_addresses']);
            $data['blind_carbon_copy_mail_addresses'] = '';
            foreach ($items as $item) {
                $item = preg_replace('/\s+/', '', $item);
                if ($item !== '') {
                    $execute = $query->mailBlindCarbonCopies()->where('mail_address', $item)->first();
                    if ($execute) {
                        if ($itemIds->contains($execute->id)) {
                            $itemIds->forget($execute->id);
                        }
                    } else {
                        $execute = $query->mailBlindCarbonCopies()->create([
                            'mail_address' => $item,
                        ]);
                    }

                    if ($data['blind_carbon_copy_mail_addresses'] !== '') {
                        $data['blind_carbon_copy_mail_addresses'] .= ';';
                    }
                    $data['blind_carbon_copy_mail_addresses'] .= $execute->mail_address;
                }
            }
            $query->blind_carbon_copy_mail_addresses = $data['blind_carbon_copy_mail_addresses'];
        }
        if ($itemIds->count()) {
            $query->mailBlindCarbonCopies()->whereIn('id', $itemIds->toArray())->delete();
        }

        $query->save();

        $itemIds = $query->mailAttachments->pluck("id", "id");
        if (array_key_exists('attachments', $data) && is_array($data['attachments']) && count($data['attachments'])) {
            foreach ($data['attachments'] as $itemId => $item) {
                if ($itemIds->contains($itemId)) {
                    $itemIds->forget($itemId);
                } else {
                    $itemUrl = $this->fileHelperRepository->copy($item['url'], 'mail-attachments', array_key_exists('prefix', $item) ? $item['prefix'] : null);
                    $query->mailAttachments()->create([
                        'name' => $item['name'],
                        'mime_type' => $item['mime_type'],
                        'size' => $item['size'],
                        'url' => $itemUrl,
                    ]);
                }
            }
        }
        if ($itemIds->count()) {
            $query->mailAttachments()->whereIn('id', $itemIds->toArray())->delete();
        }

        $query = $this->find($query->id, [
            'mailRecipients',
            'mailCarbonCopies',
            'mailBlindCarbonCopies',
            'mailAttachments',
        ]);

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Mail updated successfully',
                'errors'    => []
            ],
            'data' => $query,
        ];
    }

    public function destroy(string $id): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'Mail not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        $query->delete();
        $query->mailRecipients()->delete();
        $query->mailCarbonCopies()->delete();
        $query->mailBlindCarbonCopies()->delete();
        $query->mailAttachments()->delete();

        return [
            'meta' => [
                'success'   => true,
                'code'      => 200,
                'message'   => 'Mail deleted successfully',
                'errors'    => []
            ],
            'data' => null,
        ];
    }

    public function send($id): array
    {
        $query = $this->find($id);
        if ($query === null) {
            return [
                'meta' => [
                    'success'   => false,
                    'code'      => 404,
                    'message'   => 'Mail not found',
                    'errors'    => []
                ],
                'data' => null,
            ];
        }

        return $this->mailHelperRepository->send($query);
    }
}
