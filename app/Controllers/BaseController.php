<?php
// BaseController here
namespace App\Controllers;

use eftec\bladeone\BladeOne;

class BaseController{

    /**
    * Render một view Blade.
    *
    * @param string $viewFile Tên file view cần render.
    * @param array $data Dữ liệu truyền vào view.
    */
    protected function render($viewFile, $data = [])
    {
        $viewDir = __DIR__ . "/../../src/views";
        $storageDir = __DIR__ . "/../../storage";
        $blade = new BladeOne(null, null, BladeOne::MODE_DEBUG);
        $blade->setPath($viewDir, $storageDir);
        echo $blade->run($viewFile, $data);
    }
}