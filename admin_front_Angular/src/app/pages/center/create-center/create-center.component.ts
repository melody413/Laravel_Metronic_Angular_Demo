import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-create-center',
  templateUrl: './create-center.component.html',
  styleUrls: ['./create-center.component.scss'],
  providers: [MessageService]

})
export class CreateCenterComponent {
  //reference valuables
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
  countries: any[] = [];
  cities: any[] = [];
  areas: any[] = [];
  specialities: any[] = [];

  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}

  ngOnInit(): void{
    this.image_gallery_count = 0;
    this.http.get<any>(environment.apiUrl + "hospital/create")
         .subscribe((response)=>{
          this.specialities = Object.entries(response.specialty);
          this.countries = Object.entries(response.country);
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
    formdata.append("parent_id", "0");
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
    formdata.append("phone", this.phone);
    if(this.country_id)  formdata.append("country_id", this.country_id.toString());
    if(this.city) formdata.append("city_id", this.city.toString());
    if(this.area) formdata.append("area_id", this.area.toString());
    formdata.append("lat_lng", this.lat_lng);

    for(let i = 0 ; i < this.specialty.length ; i++){
      if(this.specialty[i]) {
        formdata.append("specialties[]", this.specialty[i].toString());
      }
    }

    formdata.append("map_link", this.maplink);
    formdata.append("is_active", this.is_active? "1" : "0");


    this.http.post<any>(environment.apiUrl + "center/store", formdata).subscribe(
      (response) => {
        if(response.id){
          this.router.navigate(['/center/list']);
        }else{
          this.showError();
        }
      }, (error)=>{
        this.showError();
      }
    )
  }

  savenew(){
    if(this.is_active == undefined){
      this.is_active = false;
    }

    const formdata = new FormData();

    //language data
    formdata.append("parent_id", "0");
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
    formdata.append("phone", this.phone);
    if(this.country_id)  formdata.append("country_id", this.country_id.toString());
    if(this.city) formdata.append("city_id", this.city.toString());
    if(this.area) formdata.append("area_id", this.area.toString());
    formdata.append("lat_lng", this.lat_lng);

    for(let i = 0 ; i < this.specialty.length ; i++){
      if(this.specialty[i]) {
        formdata.append("specialties[]", this.specialty[i].toString());
      }
    }

    formdata.append("map_link", this.maplink);
    formdata.append("is_active", this.is_active.toString());


    this.http.post<any>(environment.apiUrl + "center/store", formdata).subscribe(
      (response) => {
        if(response.id){
          this.reset();
        }else{
          this.showError();
        }
      },(error)=>{
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