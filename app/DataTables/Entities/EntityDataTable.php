<?php

namespace App\DataTables\Entities;

use App\Http\Requests\Entities\AdvancedSearchEntityRequest;
use App\Repositories\Entities\EntityRepository;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class EntityDataTable extends DataTable
{
    private $entityRepository;

    public function __construct(
        EntityRepository $entityRepository
    ) {
        $this->entityRepository = $entityRepository;
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
                return view('contents.entities.datatables.full-name', [
                    'query' => $query
                ]);
            })
            ->addColumn('full_name1_to_text', function ($query) {
                return view('contents.entities.datatables.full-name1', [
                    'query' => $query
                ]);
            })
            ->addColumn('gender_category_to_text', function ($query) {
                return view('contents.entities.datatables.gender-category', [
                    'query' => $query
                ]);
            })
            ->addColumn('gender_category1_to_text', function ($query) {
                return view('contents.entities.datatables.gender-category1', [
                    'query' => $query
                ]);
            })
            ->addColumn('phone_to_text', function ($query) {
                return view('contents.entities.datatables.phone', [
                    'query' => $query
                ]);
            })
            ->addColumn('job_placement_to_text', function ($query) {
                return view('contents.entities.datatables.job-placement', [
                    'query' => $query
                ]);
            })
            ->addColumn('department_full_name_to_text', function ($query) {
                return view('contents.entities.datatables.department-full-name', [
                    'query' => $query
                ]);
            })
            ->addColumn('employee_status_name_to_text', function ($query) {
                return view('contents.entities.datatables.employee-status-name', [
                    'query' => $query
                ]);
            })
            ->addColumn('employee_status1_name_to_text', function ($query) {
                return view('contents.entities.datatables.employee-status-name1', [
                    'query' => $query
                ]);
            })
            ->addColumn('action', function ($query) {
                return view('contents.entities.datatables.action', [
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
    public function query(AdvancedSearchEntityRequest $request): QueryBuilder
    {
        $advancedQuery = $request->data();

        return $this->entityRepository->query($advancedQuery);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('table_entity')
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
                ->title('<strong>' . __('No.') . '</strong>')
                ->searchable(false)
                ->orderable(false)
                ->width(5)
                ->addClass('min-w-50px text-center'),
            Column::make('full_name_to_text')
                ->title('<strong>' . __('Nama Lengkap') . '</strong>')
                ->name('full_name')
                ->addClass('min-w-250px'),
            Column::make('department_full_name_to_text')
                ->title('<strong>' . __('Departement') . '</strong>')
                ->name('department_id')
                ->searchable(false)
                ->orderable(false)
                ->addClass('min-w-120px'),
            Column::make('job_placement_to_text')
                ->title('<strong>' . __('Plant') . '</strong>')
                ->name('job_placement')
                ->searchable(false)
                ->orderable(false)
                ->addClass('min-w-55px'),
            Column::make('employee_status_name_to_text')
                ->title('<strong>' . __('Status Karyawan') . '</strong>')
                ->name('employee_status_id')
                ->searchable(false)
                ->orderable(false)
                ->addClass('min-w-100px'),
            Column::make('gender_category1_to_text')
                ->title('<strong>' . __('Tempat, Tanggal Lahir') . '</strong>')
                ->name('birth_place')
                ->searchable(false)
                ->orderable(false)
                ->addClass('min-w-200px'),
            Column::make('gender_category_to_text')
                ->title('<strong>' . __('Jenis Kelamin') . '</strong>')
                ->name('gender_category')
                ->searchable(false)
                ->orderable(false)
                ->addClass('min-w-100px'),
            Column::make('full_name1_to_text')
                ->title('<strong>' . __('No. KTP') . '</strong>')
                ->name('full_name1')
                ->addClass('min-w-120px'),
            Column::make('phone_to_text')
                ->title('<strong>' . __('No. Telepon') . '</strong>')
                ->name('phone')
                ->addClass('min-w-100px'),
            Column::make('employee_status1_name_to_text')
                ->title('<strong>' . __('Tanggal Gabung') . '</strong>')
                ->name('employee_status_id')
                ->searchable(false)
                ->orderable(false)
                ->addClass('min-w-100px'),  
            Column::computed('action')
                ->title('<strong>' . __('Tindakan') . '</strong>')
                ->searchable(false)
                ->orderable(false)
                ->width(5)
                ->addClass('min-w-125px'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Entity_' . date('Y_m_d_His');
    }
}
