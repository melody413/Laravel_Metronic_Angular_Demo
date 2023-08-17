<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class MasterLayoutComposer
{
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('controller', '');
        $view->with('action', '');
        return;

        if (app('request')->route() == null)
        {
            $view->with('controller', '');
            $view->with('action', '');
            return;
        }

        $action = app('request')->route()->getAction();
        $controller = class_basename($action['controller']);
        list($controller, $action) = explode('@', $controller);

        $view->with('controller', $controller);
        $view->with('action', $action);
    }
}
