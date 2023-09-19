import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-edit-area',
  templateUrl: './edit-area.component.html',
  styleUrls: ['./edit-area.component.scss'],
  providers: [MessageService]

})
export class EditAreaComponent {
  arName: string = "";
  enName: string = "";
  errorMessage1: string = "";
  errorMessage2: string = "";
  errorMessage3: string = "";
  errorMessage4: string = "";
  is_active : boolean = true;
  country_id: number = 1;
  city_id: number = 1;
  //response data
  response_countries : any[] = [];
  response_cities : any[] = [];

  area: any;
  area_id: number;

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}


  ngOnInit(): void {

    this.http.get<any>(environment.apiUrl + "country/getall")
        .subscribe((response)=>{
          this.response_countries = Object.entries(response.countries);
          console.log(this.response_countries);
          this.country_id = this.response_countries[0][0];
        })
    this.http.get<any>(environment.apiUrl + "country/getAllCity/" + this.country_id)
        .subscribe((response)=>{
          this.response_cities = response.city;
        });

      this.route.params.subscribe(params => {
        this.area_id = params['id'];
      });
      this.http.get<any>(environment.apiUrl + "area/edit/" + this.area_id)
          .subscribe((response)=>{
            this.area = response.item;
            this.arName = this.area.translations[0]['name'];
            this.enName = this.area.translations[1]['name'];
            if(response.country) this.country_id = response.country[0]['id'];
            this.city_id = this.area.city_id;

            this.is_active = this.area.is_active == "1" ? true : false;
            this.cdr.detectChanges();
          })
    this.cdr.detectChanges();

  }

  onCountryChange() {
    this.http.get<any>(environment.apiUrl + "country/getAllCity/" + this.country_id)
        .subscribe((response)=>{
          this.response_cities = response.city;
          this.cdr.detectChanges();
        })
  } 

  create(){
    if(this.arName === "" || this.enName === "" ){
      if(this.arName === "")
        this.errorMessage1 = "*please enter the ar name";
      if(this.enName === ""){
        this.errorMessage2 = "*please enther the en name";
      }
      this.showWarn();
      this.cdr.detectChanges();
      return;
    }

    const formData = new FormData();
    formData.append("item_id", this.area_id.toString());
    formData.append("ar[name]", this.arName);
    formData.append("en[name]", this.enName);
    formData.append("city_id", this.city_id.toString());
    formData.append("is_active", this.is_active? "1" : "0");

    this.http.post<any>(environment.apiUrl+"area/store", formData)
        .subscribe((response)=>{
          if(response.id){
            this.router.navigate(['/area/list']);
          }
        }, (error)=>{
          this.showError();
        });
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

