import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-create-doctor-branch',
  templateUrl: './create-doctor-branch.component.html',
  styleUrls: ['./create-doctor-branch.component.scss']
})
export class CreateDoctorBranchComponent implements OnInit{
  //reference valuable
  
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
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}

  ngOnInit(): void{
    this.route.params.subscribe(params => {
      this.doctor_id = params['id'];
    });
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


  desItems = [{ title: 'Description' }];


  create(){
    const formdata = new FormData();
    formdata.append("doctor_id", this.doctor_id.toString());
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
    this.http.post<any>(environment.apiUrl + "doctor/branch/store", formdata).subscribe(
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
    const formdata = new FormData();
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

    this.http.post<any>(environment.apiUrl + "doctor/branch/store", formdata).subscribe(
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

