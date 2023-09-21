import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';
import { DomSanitizer } from '@angular/platform-browser';

@Component({
  selector: 'app-edit-insurance-company',
  templateUrl: './edit-insurance-company.component.html',
  styleUrls: ['./edit-insurance-company.component.scss'],
  providers: [MessageService]

})
export class EditInsuranceCompanyComponent {
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
   image :File;
   arAddress: string = "";
   enAddress: string = "";
   is_active : boolean = true;
   insuranceCompany: string = "";
   

   phone: string = "";
   country_id: number = -1;
   city: number = -1;
   area: number = -1;
   lat_lng: string = "";
   maplink: string = "";
   entags: string;
   artags: string;
   enSubCats: string;
   arSubCats: string;
   parent_branch_id: number = -1; 
   mapURL: any;
   //reponse data
   parent_branches: any[] = [];
   countries: any[] = [];
   cities: any[] = [];
   areas: any[] = [];

   insurance_co_id: number ;
   insurance_co : any ;
   image_name: string;
   constructor(private sanitizer: DomSanitizer, private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}
 
   ngOnInit(): void{
    this.route.params.subscribe((params)=>{
      this.insurance_co_id = params['id'];
    })
     this.http.get<any>(environment.apiUrl + "insurance_company/create")
         .subscribe((response)=>{
          this.parent_branches = Object.entries(response.parent_branches);
          this.countries = Object.entries(response.country);
          this.crd.detectChanges();
         })
    this.http.get<any>(environment.apiUrl + "insurance_company/edit/" + this.insurance_co_id)
          .subscribe((response)=>{
            this.insurance_co = response.item;
            console.log(this.insurance_co);
            this.parent_branch_id = this.insurance_co.parent_id;
            this.arName = this.insurance_co.translations[0]['name'];
            this.enName = this.insurance_co.translations[1]['name'];
            this.arExcerpt = this.insurance_co.translations[0]['excerpt'];
            this.enExcerpt = this.insurance_co.translations[1]['excerpt'];
            this.arDescription = this.insurance_co.translations[0]['description'];
            this.enDescription = this.insurance_co.translations[1]['description'];
            this.arAddress = this.insurance_co.translations[0]['address'];
            this.enAddress = this.insurance_co.translations[1]['address'];
            if(this.insurance_co.image) this.image_name = environment.url + "uploads/insurance_companies/" +  this.insurance_co.image;
            this.phone = this.insurance_co.phone;
            this.country_id = this.insurance_co.country_id;
            this.http.get<any>(environment.apiUrl + "country/getAllCity/" + this.country_id)
              .subscribe((response)=>{
                this.cities = response.city;
                this.crd.detectChanges();
              })
            this.city = this.insurance_co.city_id;
            this.http.get<any>(environment.apiUrl + "city/getAllArea/" + this.city)
            .subscribe((response)=>{
              this.areas = response.area;
              this.crd.detectChanges();
            })
            this.area = this.insurance_co.area_id;
            this.lat_lng = this.insurance_co.lat_lng;
            const url = `http://maps.google.com/maps?q=${this.lat_lng}&z=16&output=embed`;
            this.mapURL = this.sanitizer.bypassSecurityTrustResourceUrl(url);
            this.is_active = this.insurance_co.is_active == "1" ? true: false;

          })
   }
   onChange_map(event: any){
    const lat_lang = event;
    const url = `http://maps.google.com/maps?q=${lat_lang}&z=16&output=embed`;
    this.mapURL = this.sanitizer.bypassSecurityTrustResourceUrl(url);
    this.crd.detectChanges();
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
 
   
   getPreviewImage(file: File): string {
     const reader = new FileReader();
     reader.readAsDataURL(file);
     
     return URL.createObjectURL(file);
   }
 
 
 
   Edit(){
    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      this.showWarn();
      return;
    }
     if(this.is_active == undefined){
       this.is_active = false;
     }

     const formdata = new FormData();
     formdata.append("item_id", this.insurance_co_id.toString());
     formdata.append("parent_id", this.parent_branch_id.toString());
     formdata.append("ar[name]", this.arName);
     formdata.append("en[name]", this.enName);

     formdata.append("ar[excerpt]", this.arExcerpt);
     formdata.append("en[excerpt]", this.enExcerpt);

     formdata.append("ar[description]", this.arDescription);
     formdata.append("en[description]", this.enDescription);

     formdata.append("ar[address]", this.arAddress);
     formdata.append("en[address]", this.enAddress);

     if(this.image) formdata.append("image", this.image);

     formdata.append("country_id", this.country_id.toString());
     formdata.append("city_id", this.city.toString());
     formdata.append("area_id", this.area.toString());
 
     formdata.append("lat_lng", this.lat_lng);
     formdata.append("phone", this.phone);
     formdata.append("map_link", this.maplink);
     formdata.append("is_active", this.is_active? "1" : "0");
     this.http.post<any>(environment.apiUrl + "insurance_company/store", formdata).subscribe(
       (response) => {
         if(response.id) {
           this.router.navigate(["insurance/list"]);
         }
         else this.showError();
       }, (error)=>{
        this.showError();
       }
     )
   }
 
   reset(){
    this.parent_branch_id = -1;
    this.arName = "";
    this.enName = "";
    this.arExcerpt = "";
    this.enExcerpt = "";
    this.arDescription = "";
    this.enDescription = "";
    this.arAddress = "";
    this.enAddress = "";
    let image_tmp: any = document.getElementById('image') as HTMLElement;
    image_tmp.style.display="none";
    this.phone = "";
    this.insuranceCompany = "";
    this.country_id = -1;
    this.city = -1;
    this.area = -1;
    this.lat_lng = "";
    this.is_active = true;
    this.maplink = "";
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
