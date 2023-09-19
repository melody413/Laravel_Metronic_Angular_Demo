import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { param } from 'jquery';
import { environment } from 'src/environments/environment';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-edit-hospital-type',
  templateUrl: './edit-hospital-type.component.html',
  styleUrls: ['./edit-hospital-type.component.scss'],
  providers: [MessageService]

})
export class EditHospitalTypeComponent implements OnInit{

  //directive valuable
  name_ar: string = "";
  name_en: string = "";
  is_active: boolean = true;
  errorMessage1: string= "";
  errorMessage2: string= "";

  //response data
  hospital_type_id: number ;
  hospital_type: any;

  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}

  ngOnInit(): void {
    this.route.params.subscribe(
      (param) => {
        this.hospital_type_id = param['id'];
      }
    )
    this.http.get<any>(environment.apiUrl + "hospital_type/edit/  " + this.hospital_type_id)
          .subscribe((response)=>{
            this.hospital_type = response.item;
            this.name_ar = this.hospital_type.translations[0]['name'];
            this.name_en = this.hospital_type.translations[1]['name'];
            this.is_active = this.hospital_type.is_active == "1" ? true : false;
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

  reset(){
    this.name_ar = "";
    this.name_en = "";
    this.crd.detectChanges();
  }
  edit(){
    if(this.name_ar === "" || this.name_en === "" ){
      if(this.name_ar === "") this.errorMessage1 = "*Please input the ar name";
      if(this.name_en === "") this.errorMessage2 = "*Please input the en name";
      return;
    }
    const formData = new FormData();
    formData.append("item_id", this.hospital_type_id.toString());
    formData.append("ar[name]", this.name_ar);
    formData.append("en[name]", this.name_en);
    formData.append("is_active", this.is_active? "1" : "0");

    this.http.post<any>(environment.apiUrl + "hospital_type/store", formData)
              .subscribe((response)=>{
                if(response.id){
                  this.router.navigate(["/hospital/hospitaltype_list"]);
                }else{
                  this.showError();
                }
              }, (error)=>{
                this.showError();
              })
    
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
