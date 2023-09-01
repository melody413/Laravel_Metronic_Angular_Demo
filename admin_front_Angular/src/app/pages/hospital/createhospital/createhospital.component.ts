import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-createhospital',
  templateUrl: './createhospital.component.html',
  styleUrls: ['./createhospital.component.scss']
})
export class CreatehospitalComponent {

  //reference valuables
  parent_id: number = -1;
  arName: string = "";
  enName: string = "";
  arExcerpt: string = "";
  enExcerpt: string = "";
  arDescription: string = "";
  enDescription: string = "";
  arAddress: string = "";
  enAddress: string = "";
  image: File;
  image_gallery_count: number;
  image_gallery: File[] = []; 
  image_gallery_names: string[] = [];
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
  lat_lng: string = "";
  maplink: string = "";
  is_active : boolean;
  entags: string = "";
  artags: string = "";
  enSubCats: string = "";
  arSubCats: string = "";
  specialty: number[] = [];
  hospital_types: number[] = [];


  //reponse data
  parent_branches: any[] = [];
  countries: any[] = [];
  cities: any[] = [];
  areas: any[] = [];
  specialities: any[] = [];
  hospital_types_items : any[] = [];

  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}

  ngOnInit(): void{
    this.image_gallery_count = 0;
    this.http.get<any>(environment.apiUrl + "hospital/create")
         .subscribe((response)=>{
          this.parent_branches = Object.entries(response.parent_branches);
          this.specialities = Object.entries(response.specialty);
          this.countries = Object.entries(response.country);
          this.hospital_types_items = response.hospital_type;
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

  toggleCheckbox_type(item: number){
    const index = this.hospital_types.indexOf(item);
    if (index === -1) {
      this.hospital_types.push(item);
    } else {
      this.hospital_types.splice(index, 1);
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
    formdata.append("paths", "hospitals");

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


  create(){
    if(this.is_active == undefined){
      this.is_active = false;
    }

    const formdata = new FormData();

    //language data
    formdata.append("parent_id", this.parent_id.toString());
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    formdata.append("ar[address]", this.arAddress);
    formdata.append("en[address]", this.enAddress);

    //other data
    formdata.append("image", this.image);
    formdata.append("image_gallery_count", this.image_gallery_count.toString());
    for (let i = 0; i < this.image_gallery_names.length; i++) {
      formdata.append('image_gallery[]', this.image_gallery_names[i]);
    }

    formdata.append("insurance_company", this.insuranceCompany);
    formdata.append("facebook", this.facebook);
    formdata.append("twitter", this.twitter);
    formdata.append("instagram", this.instagram);
    formdata.append("youtube", this.youtube);
    formdata.append("website", this.website);
    formdata.append("phone", this.phone);
    formdata.append("country_id", this.country_id.toString());
    formdata.append("city_id", this.city.toString());
    formdata.append("area_id", this.area.toString());
    formdata.append("lat_lng", this.lat_lng);

    for(let i = 0 ; i < this.specialty.length ; i++){
      if(this.specialty[i]) {
        formdata.append("specialties[]", this.specialty[i].toString());
      }
    }

    for(let i = 0 ; i < this.hospital_types.length ; i++){
      if(this.hospital_types[i]) {
        formdata.append("hospital_types[]", this.hospital_types[i].toString());
      }
    }
    formdata.append("map_link", this.maplink);
    formdata.append("is_active", this.is_active.toString());


    this.http.post<any>(environment.apiUrl + "hospital/store", formdata).subscribe(
      (response) => {
        if(response.id){
          alert("success");
          this.router.navigate(['/hospital/list']);
        }else{
          alert("error");
        }
      }
    )
  }
  savenew(){
    if(this.is_active == undefined){
      this.is_active = false;
    }

    const formdata = new FormData();

    //language data
    formdata.append("parent_id", this.parent_id.toString());
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    formdata.append("ar[address]", this.arAddress);
    formdata.append("en[address]", this.enAddress);

    //other data
    formdata.append("image", this.image);
    formdata.append("image_gallery_count", this.image_gallery_count.toString());
    for (let i = 0; i < this.image_gallery_names.length; i++) {
      formdata.append('image_gallery[]', this.image_gallery_names[i]);
    }

    formdata.append("insurance_company", this.insuranceCompany);
    formdata.append("facebook", this.facebook);
    formdata.append("twitter", this.twitter);
    formdata.append("instagram", this.instagram);
    formdata.append("youtube", this.youtube);
    formdata.append("website", this.website);
    formdata.append("phone", this.phone);
    formdata.append("country_id", this.country_id.toString());
    formdata.append("city_id", this.city.toString());
    formdata.append("area_id", this.area.toString());
    formdata.append("lat_lng", this.lat_lng);

    for(let i = 0 ; i < this.specialty.length ; i++){
      if(this.specialty[i]) {
        formdata.append("specialties[]", this.specialty[i].toString());
      }
    }

    for(let i = 0 ; i < this.hospital_types.length ; i++){
      if(this.hospital_types[i]) {
        formdata.append("hospital_types[]", this.hospital_types[i].toString());
      }
    }
    formdata.append("map_link", this.maplink);
    formdata.append("is_active", this.is_active.toString());


    this.http.post<any>(environment.apiUrl + "hospital/store", formdata).subscribe(
      (response) => {
        if(response.id){
          alert("success");
          this.reset();
        }else{
          alert("error");
        }
      }
    )
  }
  reset(){
    
  }
}
