import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-edit-lab-service',
  templateUrl: './edit-lab-service.component.html',
  styleUrls: ['./edit-lab-service.component.scss']
})
export class EditLabServiceComponent {
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
  lab_service_id: number ;
  lab_service : any;
  image_name: string;
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}
  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.lab_service_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "lab_services/create")
        .subscribe((response)=>{
          this.lab_categories = response.categories;
          this.crd.detectChanges();
        })
    this.http.get<any>(environment.apiUrl + "lab_services/edit/" + this.lab_service_id )
            .subscribe((response)=>{
              this.lab_service = response.result.item;
              
              this.lab_category_id = response.result.categories_parent[0];
              console.log(this.lab_service);

              this.arName = this.lab_service.translations[0]['name'];
              this.enName = this.lab_service.translations[1]['name'];

              this.arSample = this.lab_service.translations[0]['sample'];
              this.enSample = this.lab_service.translations[1]['sample'];

              this.arRangeF = this.lab_service.translations[0]['measruing_unit_female'];
              this.enRangeF = this.lab_service.translations[1]['measruing_unit_female'];

              this.arRangeM = this.lab_service.translations[0]['normal_range'];
              this.enRangeM = this.lab_service.translations[1]['normal_range'];

              this.arRangeF = this.lab_service.translations[0]['measruing_unit_female'];
              this.enRangeF = this.lab_service.translations[1]['measruing_unit_female'];

              this.arMeasruing_unit = this.lab_service.translations[0]['measruing_unit'];
              this.enMeasruing_unit = this.lab_service.translations[1]['measruing_unit'];
              
              this.arAboutTest = this.lab_service.translations[0]['about_test'];
              this.enAboutTest = this.lab_service.translations[1]['about_test'];

              this.arUseTo = this.lab_service.translations[0]['used_to'];
              this.enUseTo = this.lab_service.translations[1]['used_to'];

              this.arReasonFor = this.lab_service.translations[0]['reasons_for'];
              this.enReasonFor = this.lab_service.translations[1]['reasons_for'];

              this.arHowIs = this.lab_service.translations[0]['how_is'];
              this.enHowIs = this.lab_service.translations[1]['how_is'];

              this.arHowPrepare = this.lab_service.translations[0]['how_prepare'];
              this.enHowPrepare = this.lab_service.translations[1]['how_prepare'];

              this.arRisk = this.lab_service.translations[0]['risks'];
              this.enRisk = this.lab_service.translations[1]['risks'];

              this.arInterpretationResult = this.lab_service.translations[0]['interpretation_result'];
              this.enInterpretationResult = this.lab_service.translations[1]['interpretation_result'];

              this.arReasonReading = this.lab_service.translations[0]['reasons_high_reading'];
              this.enReasonReading = this.lab_service.translations[1]['reasons_high_reading'];

              this.arReference = this.lab_service.translations[0]['references'];
              this.enReference = this.lab_service.translations[1]['references'];
              if(this.lab_service.image) this.image_name = environment.url + "uploads/lab_services/" + this.lab_service.image;

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
    this.image_name = "";
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

  edit(){
    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }
    const formdata = new FormData();
    formdata.append("item_id", this.lab_service_id.toString());
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
                alert("success!");
                this.router.navigate(["lab/labservice_list"]);
              }else{
                alert("error");
              }
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
    this.image_name = "";
  }

}

