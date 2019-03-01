<?php
/**
 * PhpStorm
 * User: zucheng
 * Date: 2019/3/1
 */

namespace Zu\Editormd;

use Illuminate\Support\Facades\Facade;

class EditorMdFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'editormd-parse';
    }
}