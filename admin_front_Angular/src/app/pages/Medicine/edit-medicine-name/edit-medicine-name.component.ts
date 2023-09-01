import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';

@Component({
  selector: 'app-edit-medicine-name',
  templateUrl: './edit-medicine-name.component.html',
  styleUrls: ['./edit-medicine-name.component.scss']
})
export class EditMedicineNameComponent {
  desItems = [{ title: 'Description' }];
   //reference valuable
   errorMessage1: string ="";
   errorMessage2: string ="";
   
   arName: string = "";
   enName: string = "";
  
   arExcerpt: string = "";
   enExcerpt: string = "";
   arDescription: string = "";
   enDescription: string = "";
   country_id: number = -1;

   image :File;
   is_active : boolean = true;

    //reponse data
    countries: any[] = [];

   medicine_name: any;
   medicine_name_id: number;
   constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}
 
   ngOnInit(): void{
    this.route.params.subscribe(params => {
      this.medicine_name_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "pharmacy/create")
        .subscribe((response)=>{
          this.countries = Object.entries(response.country);
          this.crd.detectChanges();
        });
    this.http.get<any>(environment.apiUrl + "medicines_sc_name/edit/" + this.medicine_name_id)
        .subscribe((response)=>{
          this.medicine_name = response.item;
          this.arName = this.medicine_name.translations[0]['name'];
          this.enName = this.medicine_name.translations[1]['name'];
          this.arExcerpt = this.medicine_name.translations[0]['excerpt'];
          this.enExcerpt = this.medicine_name.translations[1]['excerpt'];
          this.arDescription = this.medicine_name.translations[0]['description'];
          this.enDescription = this.medicine_name.translations[1]['description'];
          this.country_id = this.medicine_name.country_id;
          this.crd.detectChanges();
        });
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
    
    const formdata = new FormData();
    formdata.append("item_id", this.medicine_name_id.toString());
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    if(this.country_id) formdata.append("country_id", this.country_id.toString());
    formdata.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "medicines_sc_name/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          alert("success");
          this.router.navigate(["medicines/sname_list"]);
        }
        else alert("error");
      }
    )
  }
  reset(){
    this.arName = "";
    this.enName = "";
    this.arExcerpt = "";
    this.enExcerpt = "";
    this.arDescription ="";
    this.enDescription = "";
    this.country_id = -1;
    this.is_active = false;
  }


}

