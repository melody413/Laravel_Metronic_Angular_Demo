import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-edit-medicine-company',
  templateUrl: './edit-medicine-company.component.html',
  styleUrls: ['./edit-medicine-company.component.scss'],
  providers: [MessageService]

})
export class EditMedicineCompanyComponent {

//reference valuable
errorMessage1: string ="";
errorMessage2: string ="";

arName: string = "";
enName: string = "";
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
country_id: number = -1;
city: number = -1;
area: number = -1;

//reponse data
countries: any[] = [];
cities: any[] = [];
areas: any[] = [];

medicine_company_id: number;
medicine_company: any;
image_name: string;
constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}

ngOnInit(): void{
  this.route.params.subscribe(params => {
    this.medicine_company_id = params['id'];
  });

  this.http.get<any>(environment.apiUrl + "medicines_company/edit/" + this.medicine_company_id)
      .subscribe((response)=>{
        this.countries = Object.entries(response.country);
        this.crd.detectChanges();
        this.medicine_company = response.item;
        this.arName = this.medicine_company.translations[0]['name'];
        this.enName = this.medicine_company.translations[1]['name'];
        this.facebook = this.medicine_company.facebook;
        this.twitter = this.medicine_company.twitter;
        this.instagram = this.medicine_company.instagram;
        this.youtube = this.medicine_company.youtube;
        this.website= this.medicine_company.website;
        this.phone = this.medicine_company.phone;
        this.country_id = this.medicine_company.country_id;
        this.http.get<any>(environment.apiUrl + "country/getAllCity/" + this.country_id)
          .subscribe((response)=>{
            this.cities = response.city;
            this.crd.detectChanges();
          })
        this.city = this.medicine_company.city_id;
        this.http.get<any>(environment.apiUrl + "city/getAllArea/" + this.city)
        .subscribe((response)=>{
          this.areas = response.area;
          this.crd.detectChanges();
        })
        this.area = this.medicine_company.area_id;
        this.is_active = this.medicine_company.is_active == "1" ? true: false;
        if(this.medicine_company.image) this.image_name = environment.url + "uploads/medicines_company/" +this.medicine_company.image;

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



create(){
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
  formdata.append("item_id", this.medicine_company_id.toString());
  formdata.append("ar[name]", this.arName);
  formdata.append("en[name]", this.enName);
  formdata.append("ar[address]", this.arAddress);
  formdata.append("en[address]", this.enAddress);
  if(this.image) formdata.append("image", this.image);

  formdata.append("facebook", this.facebook);
  formdata.append("twitter", this.twitter);
  formdata.append("instagram", this.instagram);
  formdata.append("youtube", this.youtube);
  formdata.append("website", this.website);
  formdata.append("country_id", this.country_id.toString());
  formdata.append("city_id", this.city.toString());
  formdata.append("area_id", this.area.toString());
  formdata.append("phone", this.phone);
  formdata.append("is_active", this.is_active? "1" : "0");
  this.http.post<any>(environment.apiUrl + "medicines_company/store", formdata).subscribe(
    (response) => {
      if(response.id) {
        this.router.navigate(["medicines/company_list"]);
      }
      else this.showError();
    }, (error)=>{
      this.showError();
    }
  )
}

reset(){}
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