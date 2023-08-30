<?php


namespace App\Traits;


use App\Model\Patient;
use Illuminate\Http\Request;

trait PatientFilter
{
    public function filteredPatient(Request $request)
    {
        $id = basename(preg_replace('/^([^?]*).*$/', '$1', $request->getRequestUri()));
        $patient = Patient::query();
        // $patient = Patient::query();
        $paginate = 10;

        if ($request->query('paginate') != '') {
            $paginate = $request->query('paginate');
        }

        if ($request->query('search_string') != '') {
            $patient->where('name', 'like', '%' . $request->query('search_string') . '%')
                ->orWhere('email', 'like', '%' . $request->query('search_string') . '%')
                ->orWhere('phone', 'like', '%' . $request->query('search_string') . '%');
        }

        if ($request->query('order') != '') {
            $patient->orderBy('id', $request->query('order'));
        } else {
            $patient->orderBy('id', 'desc');
        }

        if(\Auth::id() == 29)
            return $patient->paginate($paginate);

        return $patient->where('user_id', \Auth::id())->paginate($paginate);
    }
}