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

  //disease router
  {
    path: 'disease/create',
    component : CreateDiseaseComponent
  },
  {
    path: 'disease/list',
    component : DiseaseListComponent
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
