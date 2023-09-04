import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-country',
  templateUrl: './edit-country.component.html',
  styleUrls: ['./edit-country.component.scss']
})
export class EditCountryComponent implements OnInit{

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

  country: any;
  country_id: number;
  image_name: string;
  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}
  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.country_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "country/edit/" + this.country_id)
        .subscribe((response)=>{
          this.country = response.item;
          this.arName = this.country.translations[0]['name'];
          this.enName = this.country.translations[1]['name'];
          this.countryCode = this.country.code;
          this.currencyCode = this.country.currency_code;
          if(this.country.image) this.image_name = environment.url + "uploads/countrys/" + this.country.image;
          
     
          this.cdr.detectChanges();
        })
  }



  //doctor image process
  onFileSelected(event: any) {
    this.image = event.target.files[0];
    this.image_name = "";
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
    console.log("btn clicked!");
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
      return;
    }
    const formData = new FormData();
    formData.append("item_id", this.country_id.toString());
    formData.append("ar[name]", this.arName);
    formData.append("en[name]", this.enName);
    formData.append("code", this.countryCode);
    formData.append("currency_code", this.currencyCode);
    if(this.image) formData.append("image", this.image);
    this.http.post<any>(environment.apiUrl+"country/store", formData)
        .subscribe((response)=>{
          if(response.id){
            alert("success");
            this.router.navigate(["/country/list"]);
          }
        });
  }
}

