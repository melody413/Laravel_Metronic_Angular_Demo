import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-create-pharmacy',
  templateUrl: './create-pharmacy.component.html',
  styleUrls: ['./create-pharmacy.component.scss'],
})
export class CreatePharmacyComponent {
  desItems = [{ title: 'Description' }];
   //reference valuable
   errorMessage1: string ="";
   errorMessage2: string ="";
   
   arName: string = "";
   enName: string = "";
   arTitle: string = "";
   enTitle: string = "";
   arExcerpt: string = "";
   enExcerpt: string = "";
   arDescription: string = "";
   enDescription: string = "";
   image :File;
   arAddress: string = "";
   enAddress: string = "";
   is_active : boolean = true;
   insuranceCompany: string = "";
   facebook: string = "";
   twitter: string = "";
   instagram : string = "";
   youtube: string = "";
   website: string = "";

   phone: string = "";
   open_hours: string ;
   country_id: number = -1;
   city: number = -1;
   area: number = -1;
   lat_lng: string = "";
   maplink: string = "";
   entags: string;
   artags: string;
   enSubCats: string;
   arSubCats: string;
   Pharmacy_co_id: number = -1; 
   //reponse data
   pharmacyCos: any[] = [];
   countries: any[] = [];
   cities: any[] = [];
   areas: any[] = [];
 
   constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}
 
   ngOnInit(): void{
     this.http.get<any>(environment.apiUrl + "pharmacy/create")
         .subscribe((response)=>{
          this.pharmacyCos = response.pharmacyCo;
           this.countries = Object.entries(response.country);
          //  // this.cities = Object.entries(response.city);
          //  this.areas = Object.entries(response.area);
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
   onCountryChange() {
     this.http.get<any>(environment.apiUrl + "country/getAllCity/" + this.country_id)
         .subscribe((response)=>{
           this.cities = response.city;
           this.crd.detectChanges();
         })
   } 
 
   onCityChange(){
     this.http.get<any>(environment.apiUrl + "city/getAllArea/" + this.city)
         .subscribe((response)=>{
           this.areas = response.area;
           this.crd.detectChanges();
         })
   }

   //doctor image process
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
 
   
   getPreviewImage(file: File): string {
     const reader = new FileReader();
     reader.readAsDataURL(file);
     
     return URL.createObjectURL(file);
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
     formdata.append("parent_id", this.Pharmacy_co_id.toString());
     formdata.append("ar[name]", this.arName);
     formdata.append("en[name]", this.enName);
     formdata.append("ar[title]", this.arTitle);
     formdata.append("en[title]", this.enTitle);
     formdata.append("ar[excerpt]", this.arExcerpt);
     formdata.append("en[excerpt]", this.enExcerpt);
     formdata.append("ar[description]", this.arDescription);
     formdata.append("en[description]", this.enDescription);
     formdata.append("ar[address]", this.arAddress);
     formdata.append("en[address]", this.enAddress);
     formdata.append("image", this.image);
  
     formdata.append("facebook", this.facebook);
     formdata.append("twitter", this.twitter);
     formdata.append("instagram", this.instagram);
     formdata.append("youtube", this.youtube);
     formdata.append("website", this.website);
     formdata.append("country_id", this.country_id.toString());
     formdata.append("city_id", this.city.toString());
     formdata.append("area_id", this.area.toString());
     formdata.append("lat_lng", this.lat_lng);
     formdata.append("phone", this.phone);
     formdata.append("is_active", this.is_active? "1" : "0");
     this.http.post<any>(environment.apiUrl + "pharmacy/store", formdata).subscribe(
       (response) => {
         if(response.next) {
           alert("success");
           this.router.navigate(["pharmecy/list"]);
         }
         else alert("error");
       }
     )
   }
 
   reset(){}
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
     formdata.append("parent_id", this.Pharmacy_co_id.toString());
     formdata.append("ar[name]", this.arName);
     formdata.append("en[name]", this.enName);
     formdata.append("ar[title]", this.arTitle);
     formdata.append("en[title]", this.enTitle);
     formdata.append("ar[excerpt]", this.arExcerpt);
     formdata.append("en[excerpt]", this.enExcerpt);
     formdata.append("ar[description]", this.arDescription);
     formdata.append("en[description]", this.enDescription);
     formdata.append("ar[address]", this.arAddress);
     formdata.append("en[address]", this.enAddress);
     formdata.append("image", this.image);
  
     formdata.append("facebook", this.facebook);
     formdata.append("twitter", this.twitter);
     formdata.append("instagram", this.instagram);
     formdata.append("youtube", this.youtube);
     formdata.append("website", this.website);
     formdata.append("country_id", this.country_id.toString());
     formdata.append("city_id", this.city.toString());
     formdata.append("area_id", this.area.toString());
     formdata.append("lat_lng", this.lat_lng);
     formdata.append("phone", this.phone);
     formdata.append("is_active", this.is_active? "1" : "0");
     this.http.post<any>(environment.apiUrl + "pharmacy/store", formdata).subscribe(
       (response) => {
         if(response.next) {
           alert("success");
           this.router.navigate(["pharmecy/list"]);
         }
         else alert("error");
       },
       (error)=>{
         alert("error: input the parameter correctly!");
       }
     )
   }
 }
 