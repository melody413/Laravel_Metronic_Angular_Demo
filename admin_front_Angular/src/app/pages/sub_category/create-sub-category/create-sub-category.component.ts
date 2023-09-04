import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component } from '@angular/core';
import { Router } from '@angular/router';
import { environment } from 'src/environments/environment';
@Component({
  selector: 'app-create-sub-category',
  templateUrl: './create-sub-category.component.html',
  styleUrls: ['./create-sub-category.component.scss']
})
export class CreateSubCategoryComponent {
  //directive valuable
  ar_name: string = "";
  en_name: string = "";

  errorMessage1: string = "";
  errorMessage2: string = "";
  specialty: number[] = [];
  parent_category: number[] = [];

  is_active: boolean = true;
  //response data
  response_specialities: any[] = [];
  parent_categories: any[] = [];


  constructor(
    private http: HttpClient, 
    private cdr: ChangeDetectorRef,
    private router: Router,
  ) {}

  toggleCheckbox_specialty(event : any){
    
    const index = this.specialty.indexOf(event.target.value);
    if (index === -1) {
      this.specialty.push(event.target.value);
    } else {
      this.specialty.splice(index, 1);
    }
  }

  toggleCheckbox_parent_category(event : any){
    const index = this.parent_category.indexOf(event.target.value);
    if (index === -1) {
      this.parent_category.push(event.target.value);
    } else {
      this.parent_category.splice(index, 1);
    }
  }

  ngOnInit(): void {
    //get speciallity
    this.http.get<any>(environment.apiUrl + "qanswer/getSpeciality")
        .subscribe((response)=>{
          this.response_specialities = response.specialities ;
          this.cdr.detectChanges();
        });
    this.http.get<any>(environment.apiUrl + "sub_category/create")
      .subscribe((response)=>{
        this.parent_categories = response.sub_categories ;
        this.cdr.detectChanges();
      });
    
  }

  create(){
    console.log("create btn clicked-----");
    if(this.ar_name === "" || this.en_name === "" ){
      if(this.ar_name === "") this.errorMessage1 = "*Please input the ar name";
      if(this.en_name === "") this.errorMessage2 = "*Please input the en name";
      return;
    }
    const formData = new FormData();
    formData.append("module_name", "");
    formData.append("ar[name]", this.ar_name);
    formData.append("en[name]", this.en_name);
    formData.append("country_id", "1");

    // formData.append('speciality[]', JSON.stringify(this.specialty));
    // formData.append('parent[]', JSON.stringify(this.parent_category));
    for (let j = 0; j < this.specialty.length; j++) {
      if (this.specialty[j]) 
        formData.append("specialties[]", this.specialty[j].toString());
    }
    
    for (let j = 0; j < this.parent_category.length; j++) {
      if (this.parent_category[j]) 
        formData.append("parent[]", this.parent_category[j].toString());
    }
    formData.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "sub_category/store", formData)
        .subscribe((response)=>{
          if(response.id){
            alert("success");
            this.router.navigate(['/sub_category/list']);
          }else{
            alert("error");
          }
        });
    

  }

  savenew(){
    console.log("create btn clicked-----");
    if(this.ar_name === "" || this.en_name === "" ){
      if(this.ar_name === "") this.errorMessage1 = "*Please input the ar name";
      if(this.en_name === "") this.errorMessage2 = "*Please input the en name";
      return;
    }
    const formData = new FormData();
    formData.append("module_name", "");
    formData.append("ar[name]", this.ar_name);
    formData.append("en[name]", this.en_name);
    formData.append("country_id", "1");


      for (let j = 0; j < this.specialty.length; j++) {
        if (this.specialty[j] !== undefined) 
          formData.append("speciality[]", this.specialty[j].toString());
      }
      // for (let j = 0; j < this.parent_category.length; j++) {
      //   if (this.parent_category[j]) 
      //     formData.append("parent[]", this.parent_category[j].toString());
      // }
    formData.append("is_Active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "sub_category/store", formData)
        .subscribe((response)=>{
          if(response.id){
            alert("success");
            
          }else{
            alert("error");
          }
        });
    

  }
}
