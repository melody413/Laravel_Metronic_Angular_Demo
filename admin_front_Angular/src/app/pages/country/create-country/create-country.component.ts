import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { environment } from 'src/environments/environment';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-create-country',
  templateUrl: './create-country.component.html',
  styleUrls: ['./create-country.component.scss'],
  providers: [MessageService]

})
export class CreateCountryComponent {

  //directive valuable
  image :File;
  arName: string = "";
  enName: string = "";
  errorMessage1: string = "";
  errorMessage2: string = "";
  errorMessage3: string = "";
  errorMessage4: string = "";
  countryCode: string = "";
  currencyCode: string = "";

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}



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

  create(){
    if(this.arName === "" || this.enName === "" || this.countryCode === "" || this.currencyCode === ""){
      if(this.arName === "")
        this.errorMessage1 = "*please enter the ar name";
      if(this.enName === ""){
        this.errorMessage2 = "*please enther the en name";
      }
      if(this.countryCode === ""){
        this.errorMessage3 = "*please enther the country code";
      }
      if(this.currencyCode === ""){
        this.errorMessage4 = "*please enther the currency code";
      }
      this.showWarn();
      return;
    }
    const formData = new FormData();
    formData.append("ar[name]", this.arName);
    formData.append("en[name]", this.enName);
    formData.append("code", this.countryCode);
    formData.append("currency_code", this.currencyCode);
    formData.append("image", this.image);
    this.http.post<any>(environment.apiUrl+"country/store", formData)
        .subscribe((response)=>{
          this.showSuccess();
          this.router.navigate(["country/list"]);
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
