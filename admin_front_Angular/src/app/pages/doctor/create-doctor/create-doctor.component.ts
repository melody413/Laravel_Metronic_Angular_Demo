import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-create-doctor',
  templateUrl: './create-doctor.component.html',
  styleUrls: ['./create-doctor.component.scss'],
})
export class CreateDoctorComponent implements OnInit{

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
  image_gallery_count: number;
  image_gallery: File[] = []; 
  image_gallery_names: string[] = [];
  gender : number;
  specialty: number[] = [];
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
  country_id: number = -1;
  city: number = -1;
  area: number = -1;
  lat_lng: string = "";
  maplink: string = "";
  branch: string = "1";
  entags: string;
  artags: string;
  enSubCats: string;
  arSubCats: string;

  //reponse data
  specialities: any[] = [];
  countries: any[] = [];
  cities: any[] = [];
  areas: any[] = [];
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}

  ngOnInit(): void{
    this.image_gallery_count = 0;
    this.http.get<any>(environment.apiUrl + "doctor/create")
        .subscribe((response)=>{
          this.specialities = Object.entries(response.speciality);
          this.countries = Object.entries(response.country);
          // this.cities = Object.entries(response.city);
          this.areas = Object.entries(response.area);
          this.crd.detectChanges();
          console.log(this.specialities);
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
  toggleCheckbox_specialty(item: number){
    const index = this.specialty.indexOf(item);
    if (index === -1) {
      this.specialty.push(item);
    } else {
      this.specialty.splice(index, 1);
    }
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
    formdata.append("tags_en", "");
    formdata.append("sub_cats_en", "");
    formdata.append("tags_ar", "");
    formdata.append("sub_cats_ar", "");
    formdata.append("is_active", this.is_active? "1" : "0");
    formdata.append("is_reserve", this.is_reserve? "1" : "0");
    this.http.post<any>(environment.apiUrl + "doctor/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          alert("success");
          this.router.navigate(["doctor/list"]);
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
    formdata.append("tags_en", "");
    formdata.append("sub_cats_en", "");
    formdata.append("tags_ar", "");
    formdata.append("sub_cats_ar", "");
    formdata.append("is_active", this.is_active? "1" : "0");
    formdata.append("is_reserve", this.is_reserve? "1" : "0");
    this.http.post<any>(environment.apiUrl + "doctor/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          alert("success");
          this.router.navigate(["doctor/list"]);
        }
        else alert("error");
      },
      (error)=>{
        alert("error: input the parameter correctly!");
      }
    )
  }
}
