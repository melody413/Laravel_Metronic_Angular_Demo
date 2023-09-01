import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-create-medicine-category',
  templateUrl: './create-medicine-category.component.html',
  styleUrls: ['./create-medicine-category.component.scss']
})
export class CreateMedicineCategoryComponent {
  desItems = [{ title: 'Description' }];
   //reference valuable
   errorMessage1: string ="";
   errorMessage2: string ="";
   
   arName: string = "";
   enName: string = "";
  
   country_id: number = -1;
   sub_category_id: number = -1;
   is_active : boolean = true;

    //reponse data
    countries: any[] = [];
    sub_categories: any[] = [];
   constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}
 
   ngOnInit(): void{
    this.http.get<any>(environment.apiUrl + "medicines_category/create")
        .subscribe((response)=>{
          this.countries = Object.entries(response.country);
          this.sub_categories = Object.entries(response.sub_category);
          this.crd.detectChanges();
        });
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
  create(){
    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }
    if(this.is_active == undefined){
      this.is_active = false;
    }
    
    const formdata = new FormData();
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    if(this.country_id) formdata.append("country_id", this.country_id.toString());
    if(this.sub_category_id) formdata.append("parent", this.sub_category_id.toString());

    formdata.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "medicines_category/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          alert("success");
          this.router.navigate(["medicines/category_list"]);
        }
        else alert("error");
      }
    )
  }
  reset(){
    this.arName = "";
    this.enName = "";
    this.is_active = false;
  }
  savenew(){
    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }
    if(this.is_active == undefined){
      this.is_active = false;
    }
    const formdata = new FormData();
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    if(this.country_id) formdata.append("country_id", this.country_id.toString());
    if(this.sub_category_id) formdata.append("parent", this.sub_category_id.toString());
    formdata.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "medicines_category/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          alert("success");
          this.reset();
        }
        else alert("error");
      }
    )
  }

}

