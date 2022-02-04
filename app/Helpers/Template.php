<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Blade;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class Template
{
    public static function eval($string, $data = []) {
        $php = str_replace(['&gt;', '&amp;'], ['>', '&'], 
        Blade::compileString($string));

        $obLevel = ob_get_level();
        ob_start();
        $data['__env'] = app(\Illuminate\View\Factory::class);
        extract($data, EXTR_SKIP);

        try {
            eval('?' . '>' . $php);
        } catch (\Exception $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $obLevel) ob_end_clean();
            throw new FatalThrowableError($e);
        }

        return ob_get_clean();
    }
}
