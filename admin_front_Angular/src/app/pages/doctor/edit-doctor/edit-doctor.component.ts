import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, booleanAttribute } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';
@Component({
  selector: 'app-edit-doctor',
  templateUrl: './edit-doctor.component.html',
  styleUrls: ['./edit-doctor.component.scss']
})
export class EditDoctorComponent {
//reference valuable
arName: string = "";
enName: string = "";
arTitle: string = "";
enTitle: string = "";
arExcerpt: string = "";
enExcerpt: string = "";
arDescription: string = "";
enDescription: string = "";
image :File;
image_gallery_count: number = 0;
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

doctor_id: number;
doctor: any;
image_name: string;
workdays: string;
constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}

ngOnInit(): void{
  this.route.params.subscribe(params => {
    this.doctor_id = params['id'];
  });
  this.http.get<any>(environment.apiUrl + "doctor/edit/" + this.doctor_id)
      .subscribe((response)=>{
        this.doctor = response.item;
        this.specialty = response.specialityIds;
        this.arName = this.doctor['translations'][0]['name'];
        this.enName = this.doctor['translations'][1]['name'];
        this.arExcerpt = this.doctor['translations'][0]['excerpt'];
        this.enExcerpt = this.doctor['translations'][1]['excerpt'];
        this.arDescription = this.doctor['translations'][0]['description'];
        this.enDescription = this.doctor['translations'][1]['description'];
        this.arTitle = this.doctor['translations'][0]['title'];
        this.enTitle = this.doctor['translations'][1]['title'];
        if(this.doctor['image']) this.image_name = environment.url + "uploads/doctors/" + this.doctor['image'];
        this.gender = this.doctor.gender === "male"? 0 : 1;
        this.specialities = response.speciality;
        this.countries = Object.entries(response.country);


        this.wait_time = this.doctor.wait_time;
        this.useremail = this.doctor.user_id;
        this.is_active = this.doctor.is_active === "1" ? true: false;
        this.is_reserve = this.doctor.is_reserve === "1" ? true: false;
        this.hospital = response.hospitals.toString();
        this.center= response.centers.toString();
        this.insuranceCompany = response.insuranceCompanies.toString();
        this.facebook = this.doctor.facebook;
        this.twitter = this.doctor.twitter;
        this.instagram = this.doctor.instagram;
        this.website = this.doctor.website;
        this.youtube = this.doctor.youtube;
        this.user_entry_id = this.doctor.user_entry_id;
        this.price = this.doctor.price;
        this.phone = this.doctor.phone;
        this.workdays = response.branch.day_of_week;
        this.work_days = this.workdays.split("").map(char => char === "1");
        this.time_start = response.branch.time_start;
        this.time_end = response.branch.time_end;
        this.patient_every =response.branch.patient_every;
        this.enAddress = response.branch.translations[1]['address'];
        this.arAddress = response.branch.translations[0]['address'];
        this.country_id = this.doctor.country_id;
        this.http.get<any>(environment.apiUrl + "country/getAllCity/" + this.country_id)
          .subscribe((response)=>{
            this.cities = response.city;
            this.crd.detectChanges();
          })

        this.city = this.doctor.city_id;
        this.http.get<any>(environment.apiUrl + "city/getAllArea/" + this.city)
          .subscribe((response)=>{
            this.areas = response.area;
            this.crd.detectChanges();
          })
        this.area = this.doctor.area_id;
        this.lat_lng = response.branch.lat_lng;
        this.maplink = this.doctor.map_link;

        this.crd.detectChanges();
      })
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

toggleCheckbox_work_day(id: number){
  this.work_days[id] = this.work_days[id ]? false: true;
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


edit(){
  if(this.is_active == undefined){
    this.is_active = false;
  }
  if(this.is_reserve == undefined){
    this.is_reserve = false;
  }

  const formdata = new FormData();
  formdata.append('item_id', this.doctor_id.toString());
  formdata.append("ar[name]", this.arName);
  formdata.append("en[name]", this.enName);
  formdata.append("ar[title]", this.arTitle);
  formdata.append("en[title]", this.enTitle);
  formdata.append("ar[excerpt]", this.arExcerpt);
  formdata.append("en[excerpt]", this.enExcerpt);
  formdata.append("ar[description]", this.arDescription);
  formdata.append("en[description]", this.enDescription);
  if(this.image) formdata.append("image", this.image);
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
  formdata.append("country_id", this.country_id ? this.country_id.toString() : "");
  formdata.append("city_id", this.city? this.city.toString(): "");
  formdata.append("area_id", this.area? this.area.toString(): "");
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

}
