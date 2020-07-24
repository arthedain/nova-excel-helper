<?php


namespace Arthedain\NovaExcelHelper\Classes;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExport implements FromCollection, WithHeadings
{
    public $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function collection(){
        return (new $this->model)->all();
    }

    public function headings(): array
    {
        $model = new $this->model;
        return $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
    }
}
