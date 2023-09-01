import { NgModule, APP_INITIALIZER } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http';
import { HttpClientInMemoryWebApiModule } from 'angular-in-memory-web-api';
import { ClipboardModule } from 'ngx-clipboard';
import { TranslateModule } from '@ngx-translate/core';
import { InlineSVGModule } from 'ng-inline-svg-2';
import { MatPaginatorModule } from '@angular/material/paginator';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { EditorModule } from '@tinymce/tinymce-angular';
import { FormsModule } from '@angular/forms';
import { DataTablesModule } from "angular-datatables";
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { AuthService } from './modules/auth/services/auth.service';
import { environment } from 'src/environments/environment';
import {MatTableModule} from '@angular/material/table';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatSelectModule } from '@angular/material/select';
import {MatTabsModule} from '@angular/material/tabs';

import { FakeAPIService } from './_fake/fake-api.service';
import { DoctorListComponent } from './pages/doctor/doctor-list/doctor-list.component';
import { CreateDoctorComponent } from './pages/doctor/create-doctor/create-doctor.component';
import { DoctorReservationComponent } from './pages/doctor/doctor-reservation/doctor-reservation.component';
import { CreateBodyPartComponent } from './pages/bodyPart/create-body-part/create-body-part.component';
import { BodypartListComponent } from './pages/bodyPart/bodypart-list/bodypart-list.component';
import { SymptomListComponent } from './pages/bodyPart/symptom-list/symptom-list.component';
import { CreateDiseaseComponent } from './pages/disease/create-disease/create-disease.component';
import { DiseaseListComponent } from './pages/disease/disease-list/disease-list.component';
import { CreatePharmacyComponent } from './pages/pharmecies/create-pharmacy/create-pharmacy.component';
import { PharmecyListComponent } from './pages/pharmecies/pharmecy-list/pharmecy-list.component';
import { PharmecyCompanyListComponent } from './pages/pharmecies/pharmecy-company-list/pharmecy-company-list.component';
import { CreateLabServiceComponent } from './pages/labs/create-lab-service/create-lab-service.component';
import { LabServiceListComponent } from './pages/labs/lab-service-list/lab-service-list.component';
import { CreateLabComponent } from './pages/labs/create-lab/create-lab.component';
import { LabListComponent } from './pages/labs/lab-list/lab-list.component';
import { LabCompanyListComponent } from './pages/labs/lab-company-list/lab-company-list.component';
import { LabCategoryListComponent } from './pages/labs/lab-category-list/lab-category-list.component';
import { CreateInsuranceCompanyComponent } from './pages/insurance_Company/create-insurance-company/create-insurance-company.component';
import { InsuranceCompanyListComponent } from './pages/insurance_Company/insurance-company-list/insurance-company-list.component';
import { CreatehospitalComponent } from './pages/hospital/createhospital/createhospital.component';
import { HospitalListComponent } from './pages/hospital/hospital-list/hospital-list.component';
import { CreateHospitalTypeComponent } from './pages/hospital/create-hospital-type/create-hospital-type.component';
import { HospitalTypeListComponent } from './pages/hospital/hospital-type-list/hospital-type-list.component';
import { CreateCenterComponent } from './pages/center/create-center/create-center.component';
import { CenterListComponent } from './pages/center/center-list/center-list.component';
import { ToggleSwitchComponent } from './component/toggle-switch/toggle-switch.component';
import { ZeroConfigComponentComponent } from './component/zero-config-component/zero-config-component.component';
import { WidgetsModule } from './_metronic/partials';
import { ModalsModule } from './_metronic/partials';
import { MedicineListComponent } from './pages/Medicine/medicine-list/medicine-list.component';
import { CreateMedicineComponent } from './pages/Medicine/create-medicine/create-medicine.component';
import { MedicineCompanyListComponent } from './pages/Medicine/medicine-company-list/medicine-company-list.component';
import { MedicineNameListComponent } from './pages/Medicine/medicine-name-list/medicine-name-list.component';
import { MedicineCategoryListComponent } from './pages/Medicine/medicine-category-list/medicine-category-list.component';
import { CreateTagComponent } from './pages/tag/create-tag/create-tag.component';
import { TagListComponent } from './pages/tag/tag-list/tag-list.component';
import { CreateSubCategoryComponent } from './pages/sub_category/create-sub-category/create-sub-category.component';
import { SubCategoryListComponent } from './pages/sub_category/sub-category-list/sub-category-list.component';
import { CreateQuestionAnswerComponent } from './pages/question_answer/create-question-answer/create-question-answer.component';
import { QuestionAnswerListComponent } from './pages/question_answer/question-answer-list/question-answer-list.component';
import { CreateCountryComponent } from './pages/create-country/create-country.component';
import { CountryListComponent } from './pages/country-list/country-list.component';
import { CityListComponent } from './pages/city/city-list/city-list.component';
import { CreateCityComponent } from './pages/city/create-city/create-city.component';
import { CreateAreaComponent } from './pages/area/create-area/create-area.component';
import { AreaListComponent } from './pages/area/area-list/area-list.component';
import { SpecialityListComponent } from './pages/speciality/speciality-list/speciality-list.component';
import { CreateSpecialityComponent } from './pages/speciality/create-speciality/create-speciality.component';
import { CreatePageComponent } from './pages/page/create-page/create-page.component';
import { PageListComponent } from './pages/page/page-list/page-list.component';
import { CreateFaqComponent } from './pages/faq/create-faq/create-faq.component';
import { FaqListComponent } from './pages/faq/faq-list/faq-list.component';
import { CreateRoleComponent } from './pages/role/create-role/create-role.component';
import { RoleListComponent } from './pages/role/role-list/role-list.component';
import { CreateUserComponent } from './pages/user/create-user/create-user.component';
import { UserListComponent } from './pages/user/user-list/user-list.component';
import { EditBodyPartComponent } from './pages/bodyPart/edit-body-part/edit-body-part.component';
import { EditDiseaseComponent } from './pages/disease/edit-disease/edit-disease.component';
import { EditDoctorComponent } from './pages/doctor/edit-doctor/edit-doctor.component';
import { DoctorRateComponent } from './pages/doctor/doctor-rate/doctor-rate.component';
import { DoctorBranchComponent } from './pages/doctor/doctor-branch/doctor-branch.component';
import { EditPharmacyComponent } from './pages/pharmecies/edit-pharmacy/edit-pharmacy.component';
import { CreatePharmacyCompanyComponent } from './pages/pharmecies/create-pharmacy-company/create-pharmacy-company.component';
import { EditPharmacyCompanyComponent } from './pages/pharmecies/edit-pharmacy-company/edit-pharmacy-company.component';
import { EditLabServiceComponent } from './pages/labs/edit-lab-service/edit-lab-service.component';
import { EditLabComponent } from './pages/labs/edit-lab/edit-lab.component';
import { EditLabCompanyComponent } from './pages/labs/edit-lab-company/edit-lab-company.component';
import { CreateLabCompanyComponent } from './pages/labs/create-lab-company/create-lab-company.component';
import { CreateLabCategoryComponent } from './pages/labs/create-lab-category/create-lab-category.component';
import { EditLabCategoryComponent } from './pages/labs/edit-lab-category/edit-lab-category.component';
import { EditInsuranceCompanyComponent } from './pages/insurance_Company/edit-insurance-company/edit-insurance-company.component';
import { EditHospitalComponent } from './pages/hospital/edit-hospital/edit-hospital.component';
import { EditHospitalTypeComponent } from './pages/hospital/edit-hospital-type/edit-hospital-type.component';

// import { BodypartListModule } from './pages/bodyPart/bodypart-list/bodypart-list.module';
// #fake-end#

function appInitializer(authService: AuthService) {
  return () => {
    return new Promise((resolve) => {
      //@ts-ignore
      authService.getUserByToken().subscribe().add(resolve);
    });
  };
}

@NgModule({
  declarations: [
    AppComponent, 
    DoctorListComponent, 
    CreateDoctorComponent, 
    DoctorReservationComponent, 
    CreateBodyPartComponent, 
    BodypartListComponent,
    SymptomListComponent, 
    CreateDiseaseComponent, 
    DiseaseListComponent, 
    CreatePharmacyComponent, 
    PharmecyListComponent, 
    PharmecyCompanyListComponent, 
    CreateLabServiceComponent, 
    LabServiceListComponent, 
    CreateLabComponent, 
    LabListComponent, 
    LabCompanyListComponent, 
    LabCategoryListComponent, 
    CreateInsuranceCompanyComponent, 
    InsuranceCompanyListComponent, 
    CreatehospitalComponent, 
    HospitalListComponent, 
    CreateHospitalTypeComponent, 
    HospitalTypeListComponent, 
    CreateCenterComponent, 
    CenterListComponent, 
    ToggleSwitchComponent, 
    ZeroConfigComponentComponent, MedicineListComponent, CreateMedicineComponent, MedicineCompanyListComponent, MedicineNameListComponent, MedicineCategoryListComponent, CreateTagComponent, TagListComponent, CreateSubCategoryComponent, SubCategoryListComponent, CreateQuestionAnswerComponent, QuestionAnswerListComponent, CreateCountryComponent, CountryListComponent, CityListComponent, CreateCityComponent, CreateAreaComponent, AreaListComponent, SpecialityListComponent, CreateSpecialityComponent, CreatePageComponent, PageListComponent, CreateFaqComponent, FaqListComponent, CreateRoleComponent, RoleListComponent, CreateUserComponent, UserListComponent, EditBodyPartComponent, EditDiseaseComponent, EditDoctorComponent, DoctorRateComponent, DoctorBranchComponent, EditPharmacyComponent, CreatePharmacyCompanyComponent, EditPharmacyCompanyComponent, EditLabServiceComponent, EditLabComponent, EditLabCompanyComponent, CreateLabCompanyComponent, CreateLabCategoryComponent, EditLabCategoryComponent, EditInsuranceCompanyComponent, EditHospitalComponent, EditHospitalTypeComponent,
  ],
  imports: [
    MatFormFieldModule,
    MatTabsModule,
    MatSelectModule,
    DataTablesModule,
    BrowserModule,
    FormsModule,
    BrowserAnimationsModule,
    TranslateModule.forRoot(),
    HttpClientModule,
    ClipboardModule,
    EditorModule,
    MatPaginatorModule,
    MatTableModule,
    // WidgetsModule,
    // ModalsModule,
    // #fake-start#
    environment.isMockEnabled
      ? HttpClientInMemoryWebApiModule.forRoot(FakeAPIService, {
          passThruUnknownUrl: true,
          dataEncapsulation: false,
        })
      : [],
    // #fake-end#
    AppRoutingModule,
    InlineSVGModule.forRoot(),
    NgbModule,
  ],
  exports: [
  ],
  providers: [
    {
      provide: APP_INITIALIZER,
      useFactory: appInitializer,
      multi: true,
      deps: [AuthService],
    },
  ],
  bootstrap: [AppComponent],
})
export class AppModule {}


