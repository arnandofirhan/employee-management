<?php

namespace App\DataTables\Users;

use App\Repositories\Users\UserRepository;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserDataTable extends DataTable
{
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('full_name_to_text', function ($query) {
                return view('contents.users.datatables.full_name', [
                    'query' => $query
                ]);
            })
            ->addColumn('email_to_text', function ($query) {
                return view('contents.users.datatables.email', [
                    'query' => $query
                ]);
            })
            ->addColumn('role_to_text', function ($query) {
                return view('contents.users.datatables.role', [
                    'query' => $query
                ]);
            })
            ->addColumn('setting_to_text', function ($query) {
                return view('contents.users.datatables.setting', [
                    'query' => $query
                ]);
            })
            ->addColumn('is_active_to_text', function ($query) {
                return view('contents.users.datatables.is-active', [
                    'query' => $query
                ]);
            })
            ->addColumn('action', function ($query) {
                return view('contents.users.datatables.action', [
                    'query' => $query
                ]);
            })
            ->setRowAttr([
                'data-id' => function ($query) {
                    return $query->id;
                },
            ])
            ->rawColumns([
                'is_active_to_text'
            ])
            ->filterColumn('is_active', function ($query, $keyword) {
                $sql = 'IF(users.is_active=1, "Active", "Inactive") like ?';
                $query->whereRaw($sql, ["{$keyword}%"]);
            });
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        return $this->userRepository->query();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('table_user')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1, 'asc')
            ->drawCallback("function() { KTMenu.init(); }");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')
                ->title('No.')
                ->searchable(false)
                ->orderable(false)
                ->width(5)
                ->addClass('min-w-50px text-center'),
            Column::make('full_name_to_text')
                ->title(__('Full Name'))
                ->name('full_name')
                ->addClass('min-w-250px'),
            Column::make('email_to_text')
                ->title(__('Email'))
                ->name('email')
                ->addClass('min-w-250px text-nowrap'),
            Column::make('role_to_text')
                ->title(__('Roles'))
                ->searchable(false)
                ->orderable(false)
                ->addClass('min-w-150px align-top'),
            Column::make('setting_to_text')
                ->title(__('Settings'))
                ->searchable(false)
                ->orderable(false)
                ->addClass('min-w-200px'),
            Column::make('is_active_to_text')
                ->title(__('Status'))
                ->name('is_active')
                ->addClass('min-w-100px'),
            Column::computed('action')
                ->title(__('Actions'))
                ->searchable(false)
                ->orderable(false)
                ->width(5)
                ->addClass('min-w-125px text-end'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('Y_m_d_His');
    }
}
