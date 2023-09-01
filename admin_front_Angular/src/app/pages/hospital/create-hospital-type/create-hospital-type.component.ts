import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-create-hospital-type',
  templateUrl: './create-hospital-type.component.html',
  styleUrls: ['./create-hospital-type.component.scss']
})
export class CreateHospitalTypeComponent {

//directive valuable
name_ar: string = "";
name_en: string = "";
is_active: boolean = true;
errorMessage1: string= "";
errorMessage2: string= "";


constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}


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
savenew(){
  if(this.name_ar === "" || this.name_en === "" ){
    if(this.name_ar === "") this.errorMessage1 = "*Please input the ar name";
    if(this.name_en === "") this.errorMessage2 = "*Please input the en name";
    return;
  }
  const formData = new FormData();
  formData.append("ar[name]", this.name_ar);
  formData.append("en[name]", this.name_en);
  formData.append("is_active", this.is_active? "1" : "0");

  this.http.post<any>(environment.apiUrl + "hospital_type/store", formData)
            .subscribe((response)=>{
              if(response.id){
                alert("success!");
                this.reset();
              }else{
                alert("error");
              }
            })
}
create(){
  if(this.name_ar === "" || this.name_en === "" ){
    if(this.name_ar === "") this.errorMessage1 = "*Please input the ar name";
    if(this.name_en === "") this.errorMessage2 = "*Please input the en name";
    return;
  }
  const formData = new FormData();
  formData.append("ar[name]", this.name_ar);
  formData.append("en[name]", this.name_en);
  formData.append("is_active", this.is_active? "1" : "0");

  this.http.post<any>(environment.apiUrl + "hospital_type/store", formData)
            .subscribe((response)=>{
              if(response.id){
                alert("success!");
                this.router.navigate(["/hospital/hospitaltype_list"]);
              }else{
                alert("error");
              }
            })
  
}
}
