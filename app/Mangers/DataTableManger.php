<?php

namespace App\Mangers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DataTableManger
{
    private static $instance;

    private $query;
    private $request;
    private $data;

    //$search = $request->input('search.value');

    public static function getInstance()
    {
        #$this->request = $request;
        if (!isset(self::$instance)) {
            self::$instance = new DataTableManger	;
        }
        return self::$instance;
    }

    public function of(Builder $query)
    {
        $this->request = Request::capture();

        $this->query = $query;

        //dd($this->query->get());
        return $this;
    }

    public function buildQuery()
    {
        $queryVars = $this->queryVars();

        $this->count = $this->query->count();

        $this->rows = $this->query
            ->skip($queryVars['start'])
            ->limit($queryVars['limit'])
            ->orderBy($queryVars['columns'], $queryVars['dir'])
            ->get();
    }

    public function where($column, $id)
    {
        if ($id != null)
            $this->query->where($column, $id);

        return $this;
    }

    public function each($func)
    {
        $this->buildQuery();
        $this->eachCallback = $func;
        return $this;
    }

    public function getRows()
    {
        $data = $this->getTotals();
        $data['data'] = $this->rows;
        return $data;
    }

    public function heads($heads)
    {
        $this->heads[] = $heads;
        return $this;
    }

    public function getHeads()
    {

    }

    public function actions($func)
    {
        $this->actionsCallback = $func;
        return $this;
    }

    public function buidActions( array $actions, $row)
    {
        $acts = '';
        if ( array_key_exists('edit', $actions) && Gate::allows($actions['edit'][0]) )
        {
            $acts .= ' <a href="'. route($actions['edit'][0], $actions['edit'][1]) .'" class="btn btn-sm btn-info waves-effect"><i class="material-icons">mode_edit</i> Edit</a> ';
            view()->share(['hasListAction' => 1]);
        }

        if ( array_key_exists('copy', $actions) && Gate::allows($actions['copy'][0] ) )
        {
            $acts .= ' <a href="'. route($actions['copy'][0], $actions['copy'][1]) .'" class="btn bg-orange waves-effect" onclick="return confirm(\'Are you sure?\')"><i class="material-icons">content_copy</i> Copy</a> ';
            view()->share(['hasListAction' => 1]);
        }

        if ( array_key_exists('view', $actions) && Gate::allows($actions['view'][0] ) )
        {
            $acts .= ' <a href="'. route($actions['view'][0], $actions['view'][1]) .'" class="btn bg-orange waves-effect"><i class="material-icons">view_headline</i> view</a> ';
            view()->share(['hasListAction' => 1]);
        }

        if ( array_key_exists('delete', $actions) && Gate::allows($actions['delete'][0] ))
        {
            $acts .= ' <a href="'. route($actions['delete'][0], $actions['delete'][1]) .'" class="btn btn-sm btn-danger waves-effect" onclick="return confirm(\'Are you sure?\')"><i class="material-icons">delete</i> Delete</a> ';
            view()->share(['hasListAction' => true]);
        }

        if ( array_key_exists('toggle_active', $actions) && Gate::allows($actions['toggle_active'][0] ))
        {
            $icon = 'check';
            $title = 'Enabled';
            $color = "bg-green";

            if($row->is_active != 1)
            {
                $icon = 'block';
                $title = 'Disabled';
                $color = 'bg-black';
            }

            $acts .= ' <a href="'. route($actions['toggle_active'][0], $actions['toggle_active'][1]) .'" 
                class="btn '. $color .' waves-effect" >
                <i class="material-icons">'. $icon .'</i>'. $title .'</a> 
                ';
            view()->share(['hasListAction' => true]);
        }


        return $acts;
    }

    public function rows()
    {
        if(is_callable($this->eachCallback))
        {
            $i=0;
            foreach($this->rows as $row)
            {
                $this->data[] = call_user_func($this->eachCallback, $row);

                if ( isset($this->actionsCallback) && is_callable($this->actionsCallback) )
                    $this->data[$i][] = $this->buidActions( call_user_func($this->actionsCallback, $row), $row );

                $i++;
            }
        }

        $data = $this->getTotals();
        $data['data'] = $this->data;
        return $data;
    }

    public function queryVars()
    {
        $order = $this->request->input('order');
        $columns = $this->request->input('columns');

        return [
            'start' => $this->request->input('start', 0),
            'limit' => $this->request->input('length', 10),
            'order' => $this->request->input('order'),
            'columns' => isset($columns)?$columns[$order[0]['column']]['name']:'id' ,
            'dir' => isset($order[0]['dir'])?$order[0]['dir']:'ASC',
        ];
    }

    public function getTotals()
    {
        $countRows = $this->count;

        //dd($countRows);
        $data = array();
        $data['recordsTotal'] = $countRows;
        $data['recordsFiltered'] = $countRows;
        $data['draw'] = $this->request->input('draw');
        $data['input'] = $this->request->input('_');

        return $data;
    }

    public function filterColumns($columns)
    {
        /*foreach($columns as $clm)
        {
            dd($clm);
        }*/

        return $this;
    }


}
