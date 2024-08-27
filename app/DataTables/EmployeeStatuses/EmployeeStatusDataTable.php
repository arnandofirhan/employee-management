<?php

namespace App\DataTables\EmployeeStatuses;

use App\Repositories\EmployeeStatuses\EmployeeStatusRepository;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EmployeeStatusDataTable extends DataTable
{
    private $employeeStatusRepository;

    public function __construct(
        EmployeeStatusRepository $employeeStatusRepository
    ) {
        $this->employeeStatusRepository = $employeeStatusRepository;
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
            ->addColumn('name_to_text', function ($query) {
                return view('contents.employee-statuses.datatables.name', [
                    'query' => $query
                ]);
            })
            ->addColumn('is_active_to_text', function ($query) {
                return view('contents.users.datatables.is-active', [
                    'query' => $query
                ]);
            })
            ->addColumn('action', function ($query) {
                return view('contents.employee-statuses.datatables.action', [
                    'query' => $query
                ]);
            })
            ->setRowAttr([
                'data-id' => function ($query) {
                    return $query->id;
                },
            ]);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(): QueryBuilder
    {
        return $this->employeeStatusRepository->query();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('table_employee_status')
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
            Column::make('name_to_text')
                ->title(__('Name'))
                ->name('name')
                ->addClass('min-w-250px'),
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
        return 'EmployeeStatus_' . date('Y_m_d_His');
    }
}
