import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-edit-lab-category',
  templateUrl: './edit-lab-category.component.html',
  styleUrls: ['./edit-lab-category.component.scss'],
  providers: [MessageService]

})
export class EditLabCategoryComponent {
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
   image :File;
   is_active : boolean = true;

   category_id: number;
   lab_category: any;
   image_name: string = "";
   constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}

    ngOnInit(): void {
      this.route.params.subscribe(params => {
        this.category_id = params['id'];
      });
      this.http.get<any>(environment.apiUrl + "lab_category/edit/" + this.category_id)
          .subscribe((response)=>{
            this.lab_category = response.result.item;
            console.log()
            this.arName = this.lab_category.translations[0]['name'];
            this.enName = this.lab_category.translations[1]['name'];
            this.arExcerpt = this.lab_category.translations[0]['excerpt'];
            this.enExcerpt = this.lab_category.translations[1]['excerpt'];
            this.arDescription = this.lab_category.translations[0]['description'];
            this.enDescription = this.lab_category.translations[1]['description'];
            if(this.lab_category.image) this.image_name = environment.url+ "uploads/lab_categories/" +this.lab_category.image;
            this.crd.detectChanges();
          })  
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

  
  getPreviewImage(file: File): string {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    
    return URL.createObjectURL(file);
  }

  reset(){
    this.arName = "";
    this.enName = "";
    this.arExcerpt = "";
    this.enExcerpt = "";
    this.arDescription ="";
    this.enDescription = "";
    let image_tmp: any = document.getElementById('image') as HTMLElement;
    image_tmp.style.display="none";
    this.image_name = "";
    this.is_active = false;
    this.crd.detectChanges();
  }
  edit(){
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
    formdata.append("item_id", this.category_id.toString());
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);

    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    if(this.image) formdata.append("image", this.image);
    formdata.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "lab_category/store", formdata).subscribe(
      (response) => {
        if(response.id) {
          this.router.navigate(["lab/labCategory_list"]);
        }
        else this.showError();
      }, (error)=>{
        this.showError();
      }
    )
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