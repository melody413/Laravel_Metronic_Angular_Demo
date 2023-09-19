import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router  } from '@angular/router';
import { Location  } from '@angular/common';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-edit-doctor-branch',
  templateUrl: './edit-doctor-branch.component.html',
  styleUrls: ['./edit-doctor-branch.component.scss'],
  providers: [MessageService]

})
export class EditDoctorBranchComponent implements OnInit{
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
  branch: string = "1";
  workdays: string;

  //reponse data
  countries: any[] = [];
  cities: any[] = [];
  areas: any[] = [];

  doctor_branch_id: number;
  doctor_branch: any;
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private location: Location, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}

  ngOnInit(): void{
    this.route.params.subscribe(params => {
      this.doctor_branch_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "doctor/create")
        .subscribe((response)=>{
          this.countries = Object.entries(response.country);
          this.crd.detectChanges();
        });
    this.http.get<any>(environment.apiUrl + "doctor/branch/edit/" + this.doctor_branch_id)
        .subscribe((response)=>{
          this.doctor_branch = response.item;
          this.price = this.doctor_branch.price;
          this.phone = this.doctor_branch.phone;
          this.workdays = this.doctor_branch.day_of_week;
          this.work_days = this.workdays.split("").map(char => char === "1");
          this.time_start = this.doctor_branch.time_start;
          this.time_end = this.doctor_branch.time_end;
          this.patient_every =this.doctor_branch.patient_every;
          this.enAddress = this.doctor_branch.translations[1]['address'];
          this.arAddress = this.doctor_branch.translations[0]['address'];
          this.lat_lng = this.doctor_branch.lat_lng;
  
          this.country_id = this.doctor_branch.country_id;
          this.http.get<any>(environment.apiUrl + "country/getAllCity/" + this.country_id)
            .subscribe((response)=>{
              this.cities = response.city;
              this.crd.detectChanges();
            })

          this.city = this.doctor_branch.city_id;
          this.http.get<any>(environment.apiUrl + "city/getAllArea/" + this.city)
            .subscribe((response)=>{
              this.areas = response.area;
              this.crd.detectChanges();
            })
          this.area = this.doctor_branch.area_id;
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


  desItems = [{ title: 'Description' }];


  create(){
    const formdata = new FormData();
    formdata.append("item_id", this.doctor_branch_id.toString());
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
          this.showSuccess();
          this.location.back();
          // this.router.navigate(["doctor/branch/" + this.]);
        }
        else this.showError();
      },
      (error)=>{
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
