import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';
import { DomSanitizer } from '@angular/platform-browser';

@Component({
  selector: 'app-edit-pharmacy',
  templateUrl: './edit-pharmacy.component.html',
  styleUrls: ['./edit-pharmacy.component.scss'],
  providers: [MessageService]

})
export class EditPharmacyComponent {
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
  image_name: string="";
  pharmacy_id: number;
  pharmacy: any;
  mapURL: any;
  //reponse data
  pharmacyCos: any[] = [];
  countries: any[] = [];
  cities: any[] = [];
  areas: any[] = [];

  constructor(private sanitizer: DomSanitizer, private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}

  ngOnInit(): void{
    this.route.params.subscribe(params => {
      this.pharmacy_id = params['id'];
    });

    this.http.get<any>(environment.apiUrl + "pharmacy/create")
    .subscribe((response)=>{
    this.pharmacyCos = response.pharmacyCo;
      this.countries = Object.entries(response.country);
      this.crd.detectChanges();
    })

    this.http.get<any>(environment.apiUrl + "pharmacy/edit/" + this.pharmacy_id)
        .subscribe((response)=>{
          this.pharmacy = response.result.item;

          this.Pharmacy_co_id = this.pharmacy.parent_id;
          this.arName = this.pharmacy.translations[0]['name'];
          this.enName = this.pharmacy.translations[1]['name'];
          this.arExcerpt = this.pharmacy.translations[0]['excerpt'];
          this.enExcerpt = this.pharmacy.translations[1]['excerpt'];
          this.arDescription = this.pharmacy.translations[0]['description'];
          this.enDescription = this.pharmacy.translations[1]['description'];
          this.arAddress = this.pharmacy.translations[0]['address'];
          this.enAddress = this.pharmacy.translations[1]['address'];
          this.facebook = this.pharmacy.facebook;
          this.twitter = this.pharmacy.twitter;
          this.instagram = this.pharmacy.instagram;
          this.youtube = this.pharmacy.youtube;
          this.website= this.pharmacy.website;
          if(this.pharmacy.image) this.image_name = environment.url + "uploads/pharmacies/" +this.pharmacy.image;
          this.phone = this.pharmacy.phone;
          this.open_hours = this.pharmacy.open_hours;
          this.insuranceCompany = response.result.insuranceCompanies;
          this.country_id = this.pharmacy.country_id;
          this.http.get<any>(environment.apiUrl + "country/getAllCity/" + this.country_id)
            .subscribe((response)=>{
              this.cities = response.city;
              this.crd.detectChanges();
            })
          this.city = this.pharmacy.city_id;
          this.http.get<any>(environment.apiUrl + "city/getAllArea/" + this.city)
          .subscribe((response)=>{
            this.areas = response.area;
            this.crd.detectChanges();
          })
          this.area = this.pharmacy.area_id;
          this.lat_lng = this.pharmacy.lat_lng;
          const url = `http://maps.google.com/maps?q=${this.lat_lng}&z=16&output=embed`;
          this.mapURL = this.sanitizer.bypassSecurityTrustResourceUrl(url);
          this.is_active = this.pharmacy.is_active == "1" ? true: false;
          this.crd.detectChanges();

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
    formdata.append("item_id", this.pharmacy_id.toString());
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
    if(this.image) formdata.append("image", this.image);

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
          this.showSuccess();
          this.router.navigate(["pharmecy/list"]);
        }
        else this.showError();
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

