import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';
import { DomSanitizer } from '@angular/platform-browser';

declare var google: any;
@Component({
  selector: 'app-create-doctor',
  templateUrl: './create-doctor.component.html',
  styleUrls: ['./create-doctor.component.scss'],
  providers: [MessageService]

})
export class CreateDoctorComponent implements OnInit{

  //reference valuable
  options: any;
  
  overlays: any[];
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
  image_gallery_count: number;
  image_gallery: File[] = []; 
  image_gallery_names: string[] = [];
  gender : number;
  specialty: number[] = [];
  sepcialty_tag: number[] = [];
  specialty_subc: number[] = [];
  wait_time : number;
  useremail: string ="";
  is_reserve: boolean = true;
  is_active : boolean = true;
  hospital: string = "";
  center: string = "";
  insuranceCompany: string = "";
  facebook: string = "";
  twitter: string = "";
  instagram : string = "";
  youtube: string = "";
  website: string = "";
  user_entry_id: string = "";
  work_days : boolean[] =  Array(7).fill(false);
  time_start: string;
  time_end: string;
  patient_every: number;
  price: string;
  phone: string = "";
  arAddress: string = "";
  enAddress: string = "";
  country_id: number = 0;
  city: number = 0;
  area: number = 0;
  lat_lng: string = "";
  maplink: string = "";
  branch: string = "1";
  entags: string = "";
  artags: string = "";
  enSubCats: string = "";
  arSubCats: string = "";

  mapURL: any;

  //reponse data
  specialities: any[] = [];
  countries: any[] = [];
  cities: any[] = [];
  areas: any[] = [];

  specialty_tags: any[] = [];
  specialty_subs: any[] = [];
  constructor(private sanitizer: DomSanitizer, private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private messageService: MessageService, private primengConfig: PrimeNGConfig) {
  }

  ngOnInit(): void{
    this.mapURL = this.sanitizer.bypassSecurityTrustResourceUrl('http://maps.google.com/maps?q=25.3076008, 51.4803216&z=16&output=embed');

    this.image_gallery_count = 0;
    this.http.get<any>(environment.apiUrl + "doctor/create")
        .subscribe((response)=>{
          this.specialities = Object.entries(response.speciality);
          this.countries = Object.entries(response.country);
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

  onChange_map(event: any){
    const lat_lang = event;
    const url = `http://maps.google.com/maps?q=${lat_lang}&z=16&output=embed`;
    this.mapURL = this.sanitizer.bypassSecurityTrustResourceUrl(url);
    this.crd.detectChanges();
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
  toggleCheckbox_specialty(item: number){
    const index = this.specialty.indexOf(item);
    if (index === -1) {
      this.specialty.push(item);
    } else {
      this.specialty.splice(index, 1);
    }
    this.updateTag_category();
}

toggleCheckbox_specialty_tag(item: number){
  const index = this.sepcialty_tag.indexOf(item);
  if (index === -1) {
    this.sepcialty_tag.push(item);
  } else {
    this.sepcialty_tag.splice(index, 1);
  }
  console.log(this.sepcialty_tag.toString());
}


toggleCheckbox_specialty_subc(item: number){
  const index = this.specialty_subc.indexOf(item);
  if (index === -1) {
    this.specialty_subc.push(item);
  } else {
    this.specialty_subc.splice(index, 1);
  }
  console.log(this.specialty_subc.toString());
}


updateTag_category(){
  this.http.post<any>(environment.apiUrl + "doctor/getTag", this.specialty)
      .subscribe((response)=>{
        this.specialty_tags = response.tags;
        this.specialty_subs = response.sub_categories;
        this.crd.detectChanges();
      });
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

  //multiple image process
  onMultipleFileSelected(event: any) {
    const file: File = event.target.files[0];
    const formdata = new FormData();
    formdata.append("file", file);
    formdata.append("paths", "doctors");

    this.http.post<any>(environment.apiUrl + "data/uploadImages", formdata)
    .subscribe((response)=>{
      const string = response.filename.toString();
      this.image_gallery_names.push(string);
      for(let i = 0 ; i < this.image_gallery_names.length ; i++){
        console.log(this.image_gallery_names[i]);
      }
    })
    this.image_gallery.push(event.target.files[0]);
    this.image_gallery_count = this.image_gallery.length;
  }

  cancelUpload(index: number) {
    this.image_gallery.splice(index, 1);
    this.image_gallery_names.splice(index, 1);
    this.image_gallery_count = this.image_gallery.length;
  }

  getPreviewImage(file: File): string {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    return URL.createObjectURL(file);
  }

  desItems = [{ title: 'Description' }];


  create(){
  
    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.showWarn();
      this.crd.detectChanges();
      return;
    }

    if(this.is_active == undefined){
      this.is_active = false;
    }
    if(this.is_reserve == undefined){
      this.is_reserve = false;
    }

    const formdata = new FormData();
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    formdata.append("ar[title]", this.arTitle);
    formdata.append("en[title]", this.enTitle);
    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    formdata.append("image", this.image);
    formdata.append("image_gallery_count", this.image_gallery_count.toString());
    for (let i = 0; i < this.image_gallery_names.length; i++) {
      formdata.append('image_gallery[]', this.image_gallery_names[i]);
    }
    formdata.append("gender", (this.gender == 1? "Female" : "male"));
    for(let i = 0 ; i < this.specialty.length ; i++){
      if(this.specialty[i]) {
        formdata.append("specialties[]", this.specialty[i].toString());
      }
    }
    formdata.append("facebook", this.facebook);
    formdata.append("twitter", this.twitter);
    formdata.append("instagram", this.instagram);
    formdata.append("youtube", this.youtube);
    formdata.append("website", this.website);
    formdata.append("user_entry_id", this.user_entry_id);
    formdata.append("time_start", this.time_start);
    formdata.append("time_end", this.time_end);
    for (let i = 0; i < this.work_days.length ; i++) {
      if(this.work_days[i]==true)
        formdata.append(`work_days[${i}]`, "1");
    }
    if(this.patient_every){
      formdata.append("patient_every", this.patient_every.toString());
    }
    formdata.append("price", this.price);
    formdata.append("ar[address]", this.arAddress);
    formdata.append("en[address]", this.enAddress);
    formdata.append("country_id", this.country_id.toString());
    formdata.append("city_id", this.city.toString());
    formdata.append("area_id", this.area.toString());
    formdata.append("lat_lng", this.lat_lng);
    formdata.append("phone", this.phone);
    formdata.append("map_link", this.maplink);
    formdata.append("branch", this.branch);
    formdata.append("is_active", this.is_active? "1" : "0");
    formdata.append("is_reserve", this.is_reserve? "1" : "0");
    for(let i = 0 ; i < this.sepcialty_tag.length ; i++){
      if(this.sepcialty_tag[i]) {
        formdata.append("tag_sp", this.sepcialty_tag[i].toString());
      }
    }
  
    for(let i = 0 ; i < this.specialty_subc.length ; i++){
      if(this.specialty_subc[i]) {
        formdata.append("subcp", this.specialty_subc[i].toString());
      }
    }

    formdata.append("tags_en", this.sepcialty_tag.toString());
    formdata.append("sub_cats_en", this.specialty_subc.toString());
    formdata.append("tags_ar", this.sepcialty_tag.toString());
    formdata.append("sub_cats_ar", this.specialty_subc.toString());
    
    this.http.post<any>(environment.apiUrl + "doctor/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          this.showSuccess();
          this.router.navigate(["doctor/list"]);
        }
        else this.showError();
      }, (error)=>{
        this.showWarn();
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
      this.showWarn();
      return;
    }
    if(this.is_active == undefined){
      this.is_active = false;
    }
    if(this.is_reserve == undefined){
      this.is_reserve = false;
    }

    const formdata = new FormData();
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    formdata.append("ar[title]", this.arTitle);
    formdata.append("en[title]", this.enTitle);
    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    formdata.append("image", this.image);
    formdata.append("image_gallery_count", this.image_gallery_count.toString());
    for (let i = 0; i < this.image_gallery_names.length; i++) {
      formdata.append('image_gallery[]', this.image_gallery_names[i]);
    }
    formdata.append("gender", (this.gender == 1? "Female" : "male"));
    for(let i = 0 ; i < this.specialty.length ; i++){
      if(this.specialty[i]) {
        formdata.append("specialties[]", this.specialty[i].toString());
      }
    }
    formdata.append("tags_en", this.sepcialty_tag.toString());
    formdata.append("sub_cats_en", this.specialty_subc.toString());
    formdata.append("tags_ar", this.sepcialty_tag.toString());
    formdata.append("sub_cats_ar", this.specialty_subc.toString());
    formdata.append("facebook", this.facebook);
    formdata.append("twitter", this.twitter);
    formdata.append("instagram", this.instagram);
    formdata.append("youtube", this.youtube);
    formdata.append("website", this.website);
    formdata.append("user_entry_id", this.user_entry_id);
    formdata.append("time_start", this.time_start);
    formdata.append("time_end", this.time_end);
    for (let i = 0; i < this.work_days.length ; i++) {
      if(this.work_days[i]==true)
        formdata.append(`work_days[${i}]`, "1");
    }
    if(this.patient_every){
      formdata.append("patient_every", this.patient_every.toString());
    }
    formdata.append("price", this.price);
    formdata.append("ar[address]", this.arAddress);
    formdata.append("en[address]", this.enAddress);
    formdata.append("country_id", this.country_id.toString());
    formdata.append("city_id", this.city.toString());
    formdata.append("area_id", this.area.toString());
    formdata.append("lat_lng", this.lat_lng);
    formdata.append("phone", this.phone);
    formdata.append("map_link", this.maplink);
    formdata.append("branch", this.branch);
    formdata.append("is_active", this.is_active? "1" : "0");
    formdata.append("is_reserve", this.is_reserve? "1" : "0");
    this.http.post<any>(environment.apiUrl + "doctor/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          this.showSuccess();
          this.router.navigate(["doctor/list"]);
        }
        else this.showError();
      },
      (error)=>{
        this.showWarn();
      }
    )
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
