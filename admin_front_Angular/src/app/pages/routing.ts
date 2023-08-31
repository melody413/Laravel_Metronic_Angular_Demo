import { Routes } from '@angular/router';
import { CreateDoctorComponent } from './doctor/create-doctor/create-doctor.component';
import { DoctorListComponent } from './doctor/doctor-list/doctor-list.component';
import { DoctorReservationComponent } from './doctor/doctor-reservation/doctor-reservation.component';
import { CreateBodyPartComponent } from './bodyPart/create-body-part/create-body-part.component';
import { BodypartListComponent } from './bodyPart/bodypart-list/bodypart-list.component';
import { SymptomListComponent } from './bodyPart/symptom-list/symptom-list.component';
import { CreatePharmacyComponent } from './pharmecies/create-pharmacy/create-pharmacy.component';
import { PharmecyCompanyListComponent } from './pharmecies/pharmecy-company-list/pharmecy-company-list.component';
import { PharmecyListComponent } from './pharmecies/pharmecy-list/pharmecy-list.component'; 
import { CreateLabComponent } from './labs/create-lab/create-lab.component';
import { LabListComponent } from './labs/lab-list/lab-list.component';
import { LabServiceListComponent } from './labs/lab-service-list/lab-service-list.component';
import { CreateLabServiceComponent } from './labs/create-lab-service/create-lab-service.component';
import { LabCompanyListComponent } from './labs/lab-company-list/lab-company-list.component';
import { LabCategoryListComponent } from './labs/lab-category-list/lab-category-list.component';
import { CreateDiseaseComponent } from './disease/create-disease/create-disease.component';
import { DiseaseListComponent } from './disease/disease-list/disease-list.component';
import { CreateInsuranceCompanyComponent } from './insurance_Company/create-insurance-company/create-insurance-company.component';
import { InsuranceCompanyListComponent } from './insurance_Company/insurance-company-list/insurance-company-list.component';
import { CreateHospitalTypeComponent } from './hospital/create-hospital-type/create-hospital-type.component';
import { HospitalTypeListComponent } from './hospital/hospital-type-list/hospital-type-list.component';
import { HospitalListComponent } from './hospital/hospital-list/hospital-list.component';
import { CreatehospitalComponent } from './hospital/createhospital/createhospital.component';
import { CenterListComponent } from './center/center-list/center-list.component';
import { CreateCenterComponent } from './center/create-center/create-center.component';
import { CreateMedicineComponent } from './Medicine/create-medicine/create-medicine.component';
import { MedicineListComponent } from './Medicine/medicine-list/medicine-list.component';
import { MedicineCompanyListComponent } from './Medicine/medicine-company-list/medicine-company-list.component';
import { MedicineCategoryListComponent } from './Medicine/medicine-category-list/medicine-category-list.component';
import { MedicineNameListComponent } from './Medicine/medicine-name-list/medicine-name-list.component';
import { TagListComponent } from './tag/tag-list/tag-list.component';
import { CreateTagComponent } from './tag/create-tag/create-tag.component';
import { CreateSubCategoryComponent } from './sub_category/create-sub-category/create-sub-category.component';
import { SubCategoryListComponent } from './sub_category/sub-category-list/sub-category-list.component';
import { CreateQuestionAnswerComponent } from './question_answer/create-question-answer/create-question-answer.component';
import { QuestionAnswerListComponent } from './question_answer/question-answer-list/question-answer-list.component';
import { CreateCountryComponent } from './create-country/create-country.component';
import { CountryListComponent } from './country-list/country-list.component';
import { CreateCityComponent } from './city/create-city/create-city.component';
import { CityListComponent } from './city/city-list/city-list.component';
import { AreaListComponent } from './area/area-list/area-list.component';
import { CreateAreaComponent } from './area/create-area/create-area.component';
import { CreateSpecialityComponent } from './speciality/create-speciality/create-speciality.component';
import { SpecialityListComponent } from './speciality/speciality-list/speciality-list.component';
import { PageListComponent } from './page/page-list/page-list.component';
import { CreatePageComponent } from './page/create-page/create-page.component';
import { CreateFaqComponent } from './faq/create-faq/create-faq.component';
import { FaqListComponent } from './faq/faq-list/faq-list.component';
import { CreateRoleComponent } from './role/create-role/create-role.component';
import { RoleListComponent } from './role/role-list/role-list.component';
import { UserListComponent } from './user/user-list/user-list.component';
import { CreateUserComponent } from './user/create-user/create-user.component';
import { EditBodyPartComponent } from './bodyPart/edit-body-part/edit-body-part.component';
import { EditDiseaseComponent } from './disease/edit-disease/edit-disease.component';
import { EditDoctorComponent } from './doctor/edit-doctor/edit-doctor.component';
import { DoctorRateComponent } from './doctor/doctor-rate/doctor-rate.component';
import { DoctorBranchComponent } from './doctor/doctor-branch/doctor-branch.component';
import { EditPharmacyComponent } from './pharmecies/edit-pharmacy/edit-pharmacy.component';
import { EditPharmacyCompanyComponent } from './pharmecies/edit-pharmacy-company/edit-pharmacy-company.component';
import { CreatePharmacyCompanyComponent } from './pharmecies/create-pharmacy-company/create-pharmacy-company.component';

const Routing: Routes = [

  //body part router
  {
    path: 'bodypart/create',
    component : CreateBodyPartComponent
  },
  {
    path: 'bodypart/list',
    component : BodypartListComponent
  },
  {
    path: 'bodypart/symptom',
    component : SymptomListComponent
  },
  {
    path: `bodypart/edit/:id`,
    component : EditBodyPartComponent
  },

  //disease router
  {
    path: 'disease/create',
    component : CreateDiseaseComponent
  },
  {
    path: 'disease/list',
    component : DiseaseListComponent
  },
  {
    path: `disease/edit/:id`,
    component : EditDiseaseComponent
  },

  //doctor router
  {
    path: 'doctor/create',
    component : CreateDoctorComponent
  },
  {
    path: 'doctor/list',
    component : DoctorListComponent
  },
  {
    path: 'doctor/reservation',
    component : DoctorReservationComponent
  },
  {
    path: `doctor/edit/:id`,
    component : EditDoctorComponent
  },
  {
    path: `doctor/rate/:id`,
    component : DoctorRateComponent
  },
  {
    path: `doctor/branch/:id`,
    component : DoctorBranchComponent
  },
  //pharmecy router
  {
    path: 'pharmecy/create',
    component : CreatePharmacyComponent
  },
  {
    path: 'pharmecy/list',
    component : PharmecyListComponent
  },
  {
    path: 'pharmecy/companylist',
    component : PharmecyCompanyListComponent
  },

  {
    path: 'pharmecy/company/create',
    component : CreatePharmacyCompanyComponent
  },

  {
    path: 'pharmecy/company/edit/:id',
    component : EditPharmacyCompanyComponent
  },

  {
    path: 'pharmecy/edit/:id',
    component : EditPharmacyComponent
  },
  //lab router
  {
    path: 'lab/create_labservice',
    component : CreateLabServiceComponent
  },
  {
    path: 'lab/labservice_list',
    component : LabServiceListComponent
  },
  {
    path: 'lab/create_lab',
    component : CreateLabComponent
  },
  {
    path: 'lab/lab_list',
    component : LabListComponent
  },
  {
    path: 'lab/labCompany_list',
    component : LabCompanyListComponent
  },
  {
    path: 'lab/labCategory_list',
    component : LabCategoryListComponent
  },

  //insurance router
  {
    path: 'insurance/create',
    component : CreateInsuranceCompanyComponent
  },
  {
    path: 'insurance/list',
    component : InsuranceCompanyListComponent
  },

  //hospital router
  {
    path: 'hospital/create',
    component : CreatehospitalComponent
  },
  {
    path: 'hospital/list',
    component : HospitalListComponent
  },
  {
    path: 'hospital/create_hospitaltype',
    component : CreateHospitalTypeComponent
  },
  {
    path: 'hospital/hospitaltype_list',
    component : HospitalTypeListComponent
  },

  //center router
  {
    path: 'center/create',
    component : CreateCenterComponent
  },
  {
    path: 'center/list',
    component : CenterListComponent
  },

  //Medicine router
  {
    path: 'medicines/create',
    component : CreateMedicineComponent
  },
  {
    path: 'medicines/list',
    component : MedicineListComponent
  },
  {
    path: 'medicines/company_list',
    component : MedicineCompanyListComponent
  },
  {
    path: 'medicines/sname_list',
    component : MedicineNameListComponent
  },
  {
    path: 'medicines/category_list',
    component : MedicineCategoryListComponent
  },

  //Tag router
  {
    path: 'tag/create',
    component : CreateTagComponent
  },
  {
    path: 'tag/list',
    component : TagListComponent
  },

  //Tag router
  {
    path: 'sub_category/create',
    component : CreateSubCategoryComponent
  },
  {
    path: 'sub_category/list',
    component : SubCategoryListComponent
  },

  //Question&Answer router
  {
    path: 'question_answer/create',
    component : CreateQuestionAnswerComponent
  },
  {
    path: 'question_answer/list',
    component : QuestionAnswerListComponent
  },

  //Country router
  {
    path: 'country/create',
    component : CreateCountryComponent
  },
  {
    path: 'country/list',
    component : CountryListComponent
  },

  //City router
  {
    path: 'city/create',
    component : CreateCityComponent
  },
  {
    path: 'city/list',
    component : CityListComponent
  },

  //Area router
  {
    path: 'area/create',
    component : CreateAreaComponent
  },
  {
    path: 'area/list',
    component : AreaListComponent
  },

  //Speicality router
  {
    path: 'speciality/create',
    component : CreateSpecialityComponent
  },
  {
    path: 'speciality/list',
    component : SpecialityListComponent
  },

  //Page router
  {
    path: 'page/create',
    component : CreatePageComponent
  },
  {
    path: 'page/list',
    component : PageListComponent
  },

  //Faq router
  {
    path: 'faq/create',
    component : CreateFaqComponent
  },
  {
    path: 'faq/list',
    component : FaqListComponent
  },

  //Role router
  {
    path: 'role/create',
    component : CreateRoleComponent
  },
  {
    path: 'role/list',
    component : RoleListComponent
  },

  //User router
  {
    path: 'user/create',
    component : CreateUserComponent
  },
  {
    path: 'user/list',
    component : UserListComponent
  },


  {
    path: 'dashboard',
    loadChildren: () =>
      import('./dashboard/dashboard.module').then((m) => m.DashboardModule),
  },
  {
    path: 'builder',
    loadChildren: () =>
      import('./builder/builder.module').then((m) => m.BuilderModule),
  },
  {
    path: 'crafted/pages/profile',
    loadChildren: () =>
      import('../modules/profile/profile.module').then((m) => m.ProfileModule),
    data: { layout: 'light-sidebar' },
  },
  {
    path: 'crafted/account',
    loadChildren: () =>
      import('../modules/account/account.module').then((m) => m.AccountModule),
    data: { layout: 'dark-header' },
  },
  {
    path: 'crafted/pages/wizards',
    loadChildren: () =>
      import('../modules/wizards/wizards.module').then((m) => m.WizardsModule),
    data: { layout: 'light-header' },
  },
  {
    path: 'crafted/widgets',
    loadChildren: () =>
      import('../modules/widgets-examples/widgets-examples.module').then(
        (m) => m.WidgetsExamplesModule
      ),
    data: { layout: 'light-header' },
  },
  {
    path: 'apps/chat',
    loadChildren: () =>
      import('../modules/apps/chat/chat.module').then((m) => m.ChatModule),
    data: { layout: 'light-sidebar' },
  },
  {
    path: '',
    redirectTo: '/dashboard',
    pathMatch: 'full',
  },
  {
    path: '**',
    redirectTo: 'error/404',
  },

];

export { Routing };
