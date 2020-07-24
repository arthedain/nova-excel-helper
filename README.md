## Arthedain/NovaExcelHelper
Laravel Nova tool to export and import database to Excel file 

### Installation

```
composer require arthedain/nova-excel-helper
```

Include tool in NovaServiceProvider
```
use Arthedain\NovaExcelHelper\NovaExcelHelper;

public function tools(){
    return [
        new NovaExcelHelper
    ];
}
```

Publish config file
```
php artisan vendor:publish --provider="Arthedain\NovaExcelHelper\ToolServiceProvider" --tag="config"
```

In the configuration file, write which models you will import and export in key-value format
```
// example
'classes' => [
    '\App\User' => 'User',
    '\App\News' => 'News',
],
```
##### Localization
```
"Nova Excel Helper": "Nova Excel Helper",
"Select resource": "Select resource",
"Pleace, select resource": "Pleace, select resource",
"Import": "Import",
"Select File": "Select File",
"Load only Excel file": "Load only Excel file",
"Export": "Export",
"Pleace, select file": "Pleace, select file",
"Success": "Success"
```
