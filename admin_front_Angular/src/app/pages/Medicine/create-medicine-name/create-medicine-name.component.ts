import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-create-medicine-name',
  templateUrl: './create-medicine-name.component.html',
  styleUrls: ['./create-medicine-name.component.scss']
})
export class CreateMedicineNameComponent implements OnInit{
  desItems = [{ title: 'Description' }];
   //reference valuable
   errorMessage1: string ="";
   errorMessage2: string ="";
   
   arName: string = "";
   enName: string = "";
  
   arExcerpt: string = "";
   enExcerpt: string = "";
   arDescription: string = "";
   enDescription: string = "";
   country_id: number = -1;

   image :File;
   is_active : boolean = true;

    //reponse data
    countries: any[] = [];
   constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}
 
   ngOnInit(): void{
    this.http.get<any>(environment.apiUrl + "pharmacy/create")
        .subscribe((response)=>{
          this.countries = Object.entries(response.country);
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
    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    formdata.append("image", this.image);
    formdata.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "medicines_sc_name/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          alert("success");
          this.router.navigate(["medicines/sname_list"]);
        }
        else alert("error");
      }
    )
  }
  reset(){
    this.arName = "";
    this.enName = "";
    this.arExcerpt = "";
    this.enExcerpt = "";
    this.arDescription ="";
    this.enDescription = "";
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
    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    formdata.append("image", this.image);
    formdata.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "medicines_sc_name/store", formdata).subscribe(
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
