import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { environment } from 'src/environments/environment';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-create-city',
  templateUrl: './create-city.component.html',
  styleUrls: ['./create-city.component.scss'],
  providers: [MessageService]

})
export class CreateCityComponent implements OnInit{
  arName: string = "";
  enName: string = "";
  errorMessage1: string = "";
  errorMessage2: string = "";
  errorMessage3: string = "";
  errorMessage4: string = "";
  is_active : boolean = true;
  country_id: number ;
  //response data
  response_countries : any[] = [];

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router,private messageService: MessageService, private primengConfig: PrimeNGConfig) {}


  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "country/getall")
        .subscribe((response)=>{
          this.response_countries = Object.entries(response.countries);
          console.log(this.response_countries);
          this.country_id = this.response_countries[0][0];
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
      this.cdr.detectChanges();
      this.showWarn();
      return;
    }

    const formData = new FormData();
    formData.append("ar[name]", this.arName);
    formData.append("en[name]", this.enName);
    formData.append("country_id", this.country_id.toString());
    formData.append("is_active", this.is_active? "1" : "0");

    this.http.post<any>(environment.apiUrl+"city/store", formData)
        .subscribe((response)=>{
          if(response.id){
            this.router.navigate(["/city/list"]);
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
