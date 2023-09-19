import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-edit-lab',
  templateUrl: './edit-lab.component.html',
  styleUrls: ['./edit-lab.component.scss'],
  providers: [MessageService]

})
export class EditLabComponent {
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
   lab_co_id: number = -1; 
   lab_service_ids: number[] = [];
   //reponse data
   labCos: any[] = [];
   countries: any[] = [];
   cities: any[] = [];
   areas: any[] = [];
    lab_services : any[] = [];
    lab_id: number;
    lab: any;
    image_name: string;
   constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}
 
   ngOnInit(): void{
      this.route.params.subscribe(params => {
        this.lab_id = params['id'];
      });
     this.http.get<any>(environment.apiUrl + "lab/create")
         .subscribe((response)=>{
          this.labCos = response.lab_company;
          this.countries = Object.entries(response.country);
          this.lab_services = Object.entries(response.lab_service);
          this.crd.detectChanges();
         })
    this.http.get<any>(environment.apiUrl + "lab/edit/" + this.lab_id)
            .subscribe((response)=>{
              this.lab = response.item;
              this.lab_co_id = this.lab.parent_id;
              this.arName = this.lab.translations[0]['name'];
              this.enName = this.lab.translations[1]['name'];
              this.arExcerpt = this.lab.translations[0]['excerpt'];
              this.enExcerpt = this.lab.translations[1]['excerpt'];
              this.arDescription = this.lab.translations[0]['description'];
              this.enDescription = this.lab.translations[1]['description'];
              this.arAddress = this.lab.translations[0]['address'];
              this.enAddress = this.lab.translations[1]['address'];
              if(this.lab.image) this.image_name = environment.url + "uploads/labs/" +  this.lab.image;
              this.phone = this.lab.phone;
              this.insuranceCompany = response.insuranceCompanies.toString();
              this.country_id = this.lab.country_id;
              this.http.get<any>(environment.apiUrl + "country/getAllCity/" + this.country_id)
                .subscribe((response)=>{
                  this.cities = response.city;
                  this.crd.detectChanges();
                })
              this.city = this.lab.city_id;
              this.http.get<any>(environment.apiUrl + "city/getAllArea/" + this.city)
              .subscribe((response)=>{
                this.areas = response.area;
                this.crd.detectChanges();
              })
              this.area = this.lab.area_id;
              this.lat_lng = this.lab.lat_lng;
              this.is_active = this.lab.is_active == "1" ? true: false;
              this.maplink = this.lab.map_link;
              this.lab_service_ids = response.labServicesId;


              this.crd.detectChanges();
            })
   }
 
   toggleCheckbox_lab_service_ids(id: number){
      const index = this.lab_service_ids.indexOf(id);
      if (index === -1) {
        this.lab_service_ids.push(id);
      } else {
        this.lab_service_ids.splice(index, 1);
      }
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
 
 
 
   edit(){
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
     formdata.append("item_id", this.lab_id.toString());
     formdata.append("parent_id", this.lab_co_id.toString());
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
     for(let i = 0; i < this.lab_service_ids.length ;  i++){
      if(this.lab_service_ids[i]) {
        formdata.append('lab_services[]', this.lab_service_ids[i].toString());
      }
     }
     formdata.append("lat_lng", this.lat_lng);
     formdata.append("phone", this.phone);
     formdata.append("map_link", this.maplink);
     formdata.append("is_active", this.is_active? "1" : "0");
     this.http.post<any>(environment.apiUrl + "lab/store", formdata).subscribe(
       (response) => {
         if(response.next) {
           this.router.navigate(["lab/lab_list"]);
         }
         else this.showError();
       }, (error)=>{
        this.showError();
       }
     )
   }
 
   reset(){
    this.lab_co_id = -1;
    this.arName = "";
    this.enName = "";
    this.arExcerpt = "";
    this.enExcerpt = "";
    this.arDescription = "";
    this.enDescription = "";
    this.arAddress = "";
    this.enAddress = "";
    this.image_name = "";
    this.phone = "";
    this.insuranceCompany = "";
    this.country_id = -1;
    this.city = -1;
    this.area = -1;
    this.lat_lng = "";
    this.is_active = true;
    this.maplink = "";
    this.lab_service_ids = [];

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