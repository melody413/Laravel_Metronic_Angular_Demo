import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-edit-medicine-category',
  templateUrl: './edit-medicine-category.component.html',
  styleUrls: ['./edit-medicine-category.component.scss'],
  providers: [MessageService]

})
export class EditMedicineCategoryComponent {
  desItems = [{ title: 'Description' }];
   //reference valuable
   errorMessage1: string ="";
   errorMessage2: string ="";
   
   arName: string = "";
   enName: string = "";
  
   country_id: number = -1;
   sub_category_id: number = -1;
   is_active : boolean = true;

    //reponse data
    countries: any[] = [];
    sub_categories: any[] = [];

    medicine_category: any;
    medicine_category_id: number;
   constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,  private messageService: MessageService, private primengConfig: PrimeNGConfig) {}
 
   ngOnInit(): void{
    this.route.params.subscribe(params => {
      this.medicine_category_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "medicines_category/edit/" + this.medicine_category_id)
        .subscribe((response)=>{
          this.countries = Object.entries(response.country);
          this.sub_categories = Object.entries(response.sub_category);
          this.medicine_category = response.item;
          this.arName = this.medicine_category.translations[0]['name'];
          this.enName = this.medicine_category.translations[1]['name'];
          this.country_id = this.medicine_category.country_id;
          this.sub_category_id = this.medicine_category.parent;
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
      this.showWarn();
      return;
    }
    if(this.is_active == undefined){
      this.is_active = false;
    }
    
    const formdata = new FormData();
    formdata.append("item_id", this.medicine_category_id.toString());
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    if(this.country_id) formdata.append("country_id", this.country_id.toString());
    if(this.sub_category_id) formdata.append("parent", this.sub_category_id.toString());

    formdata.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "medicines_category/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          this.router.navigate(["medicines/category_list"]);
        }
        else this.showError();
      }, (error)=>{
        this.showError();
      }
    )
  }
  reset(){
    this.arName = "";
    this.enName = "";
    this.is_active = false;
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
