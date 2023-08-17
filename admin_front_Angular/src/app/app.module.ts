import { NgModule, APP_INITIALIZER } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { HttpClientModule } from '@angular/common/http';
import { HttpClientInMemoryWebApiModule } from 'angular-in-memory-web-api';
import { ClipboardModule } from 'ngx-clipboard';
import { TranslateModule } from '@ngx-translate/core';
import { InlineSVGModule } from 'ng-inline-svg-2';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { EditorModule } from '@tinymce/tinymce-angular';
import { FormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { AuthService } from './modules/auth/services/auth.service';
import { environment } from 'src/environments/environment';

// #fake-start#
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
    ZeroConfigComponentComponent,
  ],
  imports: [
    // BodypartListModule,
    BrowserModule,
    FormsModule,
    BrowserAnimationsModule,
    TranslateModule.forRoot(),
    HttpClientModule,
    ClipboardModule,
    EditorModule,
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


