<?php
/**
 * Created by PhpStorm.
 * User: kamal
 * Date: 9/16/18
 * Time: 8:00 PM
 */

namespace App\Mangers;

use App\Models\Area;
use Illuminate\Database\Eloquent\Builder;

class SearchManger
{

    private $query;
    private $request;
    private $rows;
    private $data;
    private $order = ['id', 'desc'];

    public function __construct($request)
    {
        $this->request = $request;
    }

    private function _setOrder()
    {
        $this->query = $this->query->orderBy($this->order[0], $this->order[1]);
    }

    private function _setActive()
    {
        $this->query = $this->query->where('is_active', 1);
    }

    private function _setWithTranslate()
    {
        $this->query = $this->query->withTranslation();
    }

    private function _prepareQuery()
    {
        $this->_setWithTranslate();
        $this->_setActive();
        $this->_setOrder();
    }

    public function of(Builder $query)
    {
        $this->query = $query->make();
        return $this;
    }

    public function query()
    {
        return $this->query;
    }

    public function filterWithArea()
    {
        if($area = $this->request->input('area', null))
            $this->query = $this->query->where('area_id', $area);

        return $this;
    }

    public function filterWithCity()
    {
        if($area = $this->request->input('city', 0))
            $this->query = $this->query->where('city_id', $area);

        return $this;
    }

    public function filterWithTitle()
    {
        if($name = $this->request->input('title', null))
            $this->query = $this->query->where('name', $name);

        return $this;
    }
    public function filterWithName()
    {
        if($name = $this->request->input('name', null))
            $this->query = $this->query->whereTranslationLike('name', '%'.$name.'%');

        return $this;
    }    
    
    public function filterWithGender()
    {
        if($gender = $this->request->input('gender', null))
            $this->query = $this->query->where('gender', $gender);

        return $this;
    }

    public function filterWithSubCat()
    {
        if($sub_cat = $this->request->input('sub_cat', null))
            $this->query = $this->query->where('sub_cats_ar', '%'.$sub_cat.'%');

        return $this;
    }


    public function filterWithInsuranceCompany()
    {
        if($tId = $this->request->input('insurance_company', null))
        $this->query = $this->query->whereHas('insuranceCompanies', function($q) use ($tId){
                $q->where('insurance_company_id', $tId);
            });

        return $this;
    }
    public function filterWithMedicineCompany()
    {
        if($company = $this->request->input('company', null))
            $this->query = $this->query->where('company', $company);

        return $this;
    }
    public function filterWithMedicineForm()
    {
        if($form = $this->request->input('form', null))
            $this->query = $this->query->where('form', $form);

        return $this;
    }
    public function filterWithMedicineCategory()
    {
        if($category = $this->request->input('category', null))
            $this->query = $this->query->where('category', 'like', ''.$category.',%')
                ->orWhere('category', 'like', '%,'.$category.',%')
                ->orWhere('category', 'like', '%,'.$category.'')
                ->orWhere('category', $category);

        // dd($this);
        return $this;
    }
    public function filterWithMedicineScientificName1()
    {
        if($scientific_name = $this->request->input('scientific_name_1', null))
            $this->query = $this->query->where('scientific_name_1', $scientific_name)
                                     ->orWhere('scientific_name_2', $scientific_name)
                                     ->orWhere('scientific_name_3', $scientific_name);

        return $this;
    }

    public function filterWithLabService()
    {
        $service = $this->request->input('lab_service', null);
        if($service)
        {
            $this->query = $this->query->join('lab_lab_service as llb', 'llb.lab_id', '=', 'labs.id', 'inner')->where('llb.lab_service_id',  $service);

            $this->order = ['labs.id', 'DESC'];

            $this->query = $this->query->groupBy('labs.id');

            $this->query = $this->query->selectRaw('count(*) AS cnt, labs.*');
        }

            //labServices()->where('lab_service_id', $service);

        return $this;
    }

    public function filterWithSpeciality()
    {
        if($speciality = $this->request->input('speciality', null))
        {
            $this->query = $this->query->whereHas('specialties', function($q) use ($speciality){
                $q->where('specialties.id', $speciality);
            });

        }

        return $this;
    }

    public function with($method)
    {
        $this->query = $this->query->with($method);
        return $this;
    }

    public function whereHas($relation, $callback, $val = true)
    {
        if($val)
            $this->query = $this->query->whereHas($relation, $callback);

        return $this;
    }

    public function paginate()
    {
        $this->_prepareQuery();
        //$this->query = $this->query->where('ids',1);

        return $this->query->paginate(env('ROWS_PER_PAGE'));
    }




}
