import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-create-lab-service',
  templateUrl: './create-lab-service.component.html',
  styleUrls: ['./create-lab-service.component.scss'],
  providers: [MessageService]

})
export class CreateLabServiceComponent implements OnInit{
  //reference valuable
  errorMessage1: string ="";
  errorMessage2: string ="";
  lab_category_id: number = -1;
  arName: string = "";
  enName: string = "";
  arTitle: string = "";
  enTitle: string = "";
  arExcerpt: string = "";
  enExcerpt: string = "";
  arDescription: string = "";
  enDescription: string = "";
  arSample: string = "";
  enSample: string = "";
  arRangeM: string = "";
  enRangeM: string = "";
  arRangeF: string = "";
  enRangeF: string = "";
  enMeasruing_unit: string = "";
  arMeasruing_unit: string = "";
  enAboutTest: string = "";
  arAboutTest: string = "";
  enUseTo: string = "";
  arUseTo: string = "";
  enReasonFor: string = "";
  arReasonFor: string = "";
  arHowIs: string = "";
  enHowIs: string = "";
  arHowPrepare: string = "";
  enHowPrepare: string = "";
  arRisk: string = "";
  enRisk: string = "";
  enInterpretationResult: string = "";
  arInterpretationResult: string = "";
  enReasonReading: string = "";
  arReasonReading: string = "";
  enReference: string = "";
  arReference: string = "";

  image: File ;


  lab_categories: any[] = [];
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "lab_services/create")
        .subscribe((response)=>{
          this.lab_categories = response.categories;
          this.crd.detectChanges();
        })
  }

  onInputChange1(event : any){
    
    const string = event;
    if(string){
      this.errorMessage1 = "";
    }else{
      this.errorMessage1 = "*Please input the ar Name";
    }
    this.crd.detectChanges(); // Manually trigger change detection
  }
  onInputChange2(event : any){
    const string = event;
    if(string){
      this.errorMessage2 = "";
    }else{
      this.errorMessage2 = "*Please input the en Name";
    }
    this.crd.detectChanges(); // Manually trigger change detection
  }

  onFileSelected(event: any) {
    this.image = event.target.files[0];
    this.showImage();

  }

  showImage() {
    const reader = new FileReader();
    reader.onload = (e: any) => {
      let image_tmp: any = document.getElementById('image') as HTMLElement;
      image_tmp.src = e.target.result;
      image_tmp.style.display="block";
    };
    reader.readAsDataURL(this.image);
  }

  create(){
    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      this.showWarn();
      return;
    }
    const formdata = new FormData();
    formdata.append("lab_category[]", this.lab_category_id.toString());
    
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    formdata.append("ar[sample]", this.arSample);
    formdata.append("en[sample]", this.enSample);
    formdata.append("ar[measruing_unit]", this.arMeasruing_unit);
    formdata.append("en[measruing_unit]", this.enMeasruing_unit);
    formdata.append("ar[measruing_unit_female]", this.arRangeF);
    formdata.append("en[measruing_unit_female]", this.enRangeF);
    formdata.append("ar[normal_range]", this.arRangeM);
    formdata.append("en[normal_range]", this.enRangeM);
    formdata.append("ar[about_test]", this.arAboutTest);
    formdata.append("en[about_test]", this.enAboutTest);
    formdata.append("ar[used_to]", this.arUseTo);
    formdata.append("en[used_to]", this.enUseTo);
    formdata.append("ar[reasons_for]", this.arReasonFor);
    formdata.append("en[reasons_for]", this.enReasonFor);
    formdata.append("ar[how_is]", this.arHowIs);
    formdata.append("en[how_is]", this.enHowIs);
    formdata.append("ar[how_prepare]", this.arHowPrepare);
    formdata.append("en[how_prepare]", this.enHowPrepare);
    formdata.append("ar[risks]", this.arRisk);
    formdata.append("en[risks]", this.enRisk);
    formdata.append("ar[interpretation_result]", this.arInterpretationResult);
    formdata.append("en[interpretation_result]", this.enInterpretationResult);
    formdata.append("ar[reasons_high_reading]", this.arReasonReading);
    formdata.append("en[reasons_high_reading]", this.enReasonReading);
    formdata.append("ar[references]", this.arReference);
    formdata.append("en[references]", this.enReference);
    if(this.image) formdata.append("image", this.image);
    
    this.http.post<any>(environment.apiUrl + "lab_services/store", formdata)
            .subscribe((response)=>{
              if(response){
                this.router.navigate(["lab/labservice_list"]);
              }else{
                this.showError();
              }
            }, (error)=>{
              this.showError();
            })
  }
  reset(){
    this.lab_category_id = -1;
    this.arName = "";
    this.enName = "";

    this.arSample ="";
    this.enSample = "";

    this.arRangeF = "";
    this.enRangeF = "";

    this.arRangeM = "";
    this.enRangeM = "";

    this.arRangeF = "";
    this.enRangeF = "";

    this.arMeasruing_unit = "";
    this.enMeasruing_unit = "";
    
    this.arAboutTest = "";
    this.enAboutTest = "";

    this.arUseTo = "";
    this.enUseTo = "";

    this.arReasonFor = "";
    this.enReasonFor = "";

    this.arHowIs = "";
    this.enHowIs = "";

    this.arHowPrepare = "";
    this.enHowPrepare = "";

    this.arRisk = "";
    this.enRisk = "";

    this.arInterpretationResult = "";
    this.enInterpretationResult ="";

    this.arReasonReading = "";
    this.enReasonReading = "";

    this.arReference = "";
    this.enReference = "";
    let image_tmp: any = document.getElementById('image') as HTMLElement;
    image_tmp.style.display="none";
  }
  savenew(){
    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      this.showWarn();
      return;
    }
    const formdata = new FormData();
    formdata.append("lab_category[]", this.lab_category_id.toString());
    
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    formdata.append("ar[sample]", this.arSample);
    formdata.append("en[sample]", this.enSample);
    formdata.append("ar[measruing_unit]", this.arMeasruing_unit);
    formdata.append("en[measruing_unit]", this.enMeasruing_unit);
    formdata.append("ar[measruing_unit_female]", this.arRangeF);
    formdata.append("en[measruing_unit_female]", this.enRangeF);
    formdata.append("ar[normal_range]", this.arRangeM);
    formdata.append("en[normal_range]", this.enRangeM);
    formdata.append("ar[about_test]", this.arAboutTest);
    formdata.append("en[about_test]", this.enAboutTest);
    formdata.append("ar[used_to]", this.arUseTo);
    formdata.append("en[used_to]", this.enUseTo);
    formdata.append("ar[reasons_for]", this.arReasonFor);
    formdata.append("en[reasons_for]", this.enReasonFor);
    formdata.append("ar[how_is]", this.arHowIs);
    formdata.append("en[how_is]", this.enHowIs);
    formdata.append("ar[how_prepare]", this.arHowPrepare);
    formdata.append("en[how_prepare]", this.enHowPrepare);
    formdata.append("ar[risks]", this.arRisk);
    formdata.append("en[risks]", this.enRisk);
    formdata.append("ar[interpretation_result]", this.arInterpretationResult);
    formdata.append("en[interpretation_result]", this.enInterpretationResult);
    formdata.append("ar[reasons_high_reading]", this.arReasonReading);
    formdata.append("en[reasons_high_reading]", this.enReasonReading);
    formdata.append("ar[references]", this.arReference);
    formdata.append("en[references]", this.enReference);
    if(this.image) formdata.append("image", this.image);
    
    this.http.post<any>(environment.apiUrl + "lab_services/store", formdata)
            .subscribe((response)=>{
              if(response){
                this.reset();
              }else{
                this.showError();
              }
            }, (error)=>{
              this.showError();
            });

  }

  showWarn() {
    this.messageService.clear();
    this.messageService.add({ severity: 'warn', summary: 'Warn', detail: 'Please input the parameter correctly!' });
  }
  showError() {
    this.messageService.add({ severity: 'error', summary: 'Error', detail: 'Inserting Data, Error!' });
  }
  showSuccess() {
    this.messageService.add({ severity: 'success', summary: 'Success', detail: 'Success' });
  }

}
