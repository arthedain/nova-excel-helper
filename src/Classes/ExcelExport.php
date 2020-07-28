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
        return $this->getTableColumns();
    }

    public function getTableColumns()
    {
        $model = new $this->model;
        $fields =  $model->getConnection()->select(
            (new \Illuminate\Database\Schema\Grammars\MySqlGrammar)->compileColumnListing()
            .' order by ordinal_position',
            [$model->getConnection()->getDatabaseName(), $model->getTable()]
        );
        $f = [];
        foreach ($fields as $item){
            array_push($f, $item->column_name);
        }

        return $f;
    }
}
