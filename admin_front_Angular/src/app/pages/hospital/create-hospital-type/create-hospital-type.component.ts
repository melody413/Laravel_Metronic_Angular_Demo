import { HttpClient } from '@angular/common/http';
import { Component } from '@angular/core';
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


constructor(private http: HttpClient){

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
              
            })
  
}
}
