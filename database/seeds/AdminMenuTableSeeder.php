<?php

use Illuminate\Database\Seeder;
use App\Models\AdminMenu;

class AdminMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AdminMenu::query()->truncate();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'dashboard';
        $adminMenu->icon = 'dashboard';
        $adminMenu->url = '';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 0;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $adminMenu->save();
        $dashboard = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'home';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $dashboard;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'dashboard';
        $adminMenu->action   = 'home';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.dashboard';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'statistic';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $dashboard;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'dashboard';
        $adminMenu->action   = 'statistic';
        $adminMenu->params = '';
        $adminMenu->save();

        #countries
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'countries';
        $adminMenu->icon = 'flag';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.country.index';
        $adminMenu->save();
        $country = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new country';
        $adminMenu->url = '/country/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $country;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'country';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.country.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list countries';
        $adminMenu->url = '/country/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $country;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'country';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.country.index';
        $adminMenu->save();

        #city
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'cities';
        $adminMenu->icon = 'outlined_flag';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new city';
        $adminMenu->url = '/city/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'city';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.city.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list cities';
        $adminMenu->url = '/city/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'city';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.country.index';
        $adminMenu->save();

        #area
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'areas';
        $adminMenu->icon = 'edit_location';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $area = $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new area';
        $adminMenu->url = '/area/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'area';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.area.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list areas';
        $adminMenu->url = '/area/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'area';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.area.index';
        $adminMenu->save();

        #speciality
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'specialities';
        $adminMenu->icon = 'folder_special';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $speciality = $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new speciality';
        $adminMenu->url = '/specialty/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'specialty';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.specialty.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list specialities';
        $adminMenu->url = '/specialty/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'specialty';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.specialty.index';
        $adminMenu->save();

        #doctors
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'doctors';
        $adminMenu->icon = 'view_module';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new doctor';
        $adminMenu->url = '/doctor/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'doctor';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.doctor.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list doctors';
        $adminMenu->url = '/doctor/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'doctor';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.doctor.index';
        $adminMenu->save();

        #pharmacy
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'pharmacies';
        $adminMenu->icon = 'local_pharmacy';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $pharmacy = $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new pharmacy';
        $adminMenu->url = '/pharmacy/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'pharmacy';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.pharmacy.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list pharmacies';
        $adminMenu->url = '/pharmacy/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'pharmacy';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.pharmacy.index';
        $adminMenu->save();

        #lab
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'labs';
        $adminMenu->icon = 'store';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $lab = $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new lab service';
        $adminMenu->url = '/lab_services/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'lab_services';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.lab_service.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list lab service';
        $adminMenu->url = '/lab_services/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'lab_services';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.lab_service.index';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new lab';
        $adminMenu->url = '/lab/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 2;
        $adminMenu->controller = 'lab';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.lab.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list labs';
        $adminMenu->url = '/lab/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 3;
        $adminMenu->controller = 'lab';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.lab.index';
        $adminMenu->save();


        #insurance_company
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'insurance companies';
        $adminMenu->icon = 'work';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new insurance company';
        $adminMenu->url = '/insurance_company/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'insurance_company';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.insurance_company.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list insurance companies';
        $adminMenu->url = '/insurance_company/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'insurance_company';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.insurance_company.index';
        $adminMenu->save();

        #hospital
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'hospitals';
        $adminMenu->icon = 'local_hospital';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $hospital = $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new hospital';
        $adminMenu->url = '/hospital/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'hospital';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.hospital.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list hospitals';
        $adminMenu->url = '/hospital/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'hospital';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.hospital.index';
        $adminMenu->save();

        #pages
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'pages';
        $adminMenu->icon = 'view_headline';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new page';
        $adminMenu->url = '/page/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'page';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.page.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list pages';
        $adminMenu->url = '/page/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'page';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.page.index';
        $adminMenu->save();

        #Faq
        $adminMenu = new AdminMenu();
        $adminMenu->title = 'faq';
        $adminMenu->icon = 'question_answer';
        $adminMenu->url = '/';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->display_order = 1;
        $adminMenu->controller = '';
        $adminMenu->action   = '';
        $adminMenu->params = '';
        $adminMenu->save();
        $lastId = $adminMenu->id;

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'create new faq';
        $adminMenu->url = '/faq/create';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 0;
        $adminMenu->controller = 'faq';
        $adminMenu->action   = 'create';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.faq.create';
        $adminMenu->save();

        $adminMenu = new AdminMenu();
        $adminMenu->title = 'list faqs';
        $adminMenu->url = '/faq/index';
        $adminMenu->in_menu = 1;
        $adminMenu->in_permission = 1;
        $adminMenu->parent_id = $lastId;
        $adminMenu->display_order = 1;
        $adminMenu->controller = 'page';
        $adminMenu->action   = 'index';
        $adminMenu->params = '';
        $adminMenu->route_name = 'admin.faq.index';
        $adminMenu->save();





    }
}
