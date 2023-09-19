import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Router } from '@angular/router';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-create-body-part', 
  templateUrl: './create-body-part.component.html',
  styleUrls: ['./create-body-part.component.scss'],
  providers: [MessageService]

})

export class CreateBodyPartComponent implements OnInit {
  arName: string = "";
  arExcerpt: string = "";
  arDescription: string = "";
  enName: string = "";
  enExcerpt: string = "";
  enDescription: string = "";
  countryId: number = 1;
  parent: string = "";
  image: File;
  isActive: boolean = true;
  hasError : boolean = false;
  errorMessage1 : String = "";
  errorMessage2 : String = "";
  content: string = '';

  //response data
  bodyparts: any[] = [];
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}

  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl+'bodypart/create')
    .subscribe((response) => {
      this.bodyparts = response.body_parts;
      this.crd.detectChanges();
    })
    this.primengConfig.ripple = true;

  }

  save() {
    console.log(this.content);
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

  //save btn 
  create(){
    //validation process
    if(this.arName == "" || this.enName == ""){
      this.showWarn();
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }

    if(this.isActive == undefined){
      this.isActive = false;
    }

    const formData = new FormData();
    formData.append('module_name', ''); // Add the appropriate value based on your requirement
    formData.append('ar[name]', this.arName);
    formData.append('ar[excerpt]', this.arExcerpt);
    formData.append('ar[description]', this.arDescription);
    formData.append('en[name]', this.enName);
    formData.append('en[excerpt]', this.enExcerpt);
    formData.append('en[description]', this.enDescription);
    formData.append('country_id', this.countryId.toString());
    formData.append('parent[]', this.parent);
    formData.append('image', this.image);
    formData.append('is_active', this.isActive ? '1' : '0');

    this.http
    .post<any>(environment.apiUrl+'bodypart/store', formData)
    .subscribe((response) => {
      if(response.result['flash_type'] === "success"){
        this.showSuccess();
        this.router.navigate(["/bodypart/list"])
      }else{
        this.showError();
      }
    });
  }
  reset(){
    this.arName = "";
    this.enName = "";
    this.arExcerpt = "";
    this.enExcerpt = "";
    this.enDescription = "";
    this.arDescription = "";
    this.countryId = 1;
    this.parent = "";
    this.isActive = false;
    let image_tmp: any = document.getElementById('image') as HTMLElement;
    image_tmp.style.display="none";
    this.crd.detectChanges();
  }
  savenew(){
    //validation process
    if(this.arName == "" || this.enName == ""){
      this.showWarn();
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }

    if(this.isActive == undefined){
      this.isActive = false;
    }

    const formData = new FormData();
    formData.append('module_name', ''); // Add the appropriate value based on your requirement
    formData.append('ar[name]', this.arName);
    formData.append('ar[excerpt]', this.arExcerpt);
    formData.append('ar[description]', this.arDescription);
    formData.append('en[name]', this.enName);
    formData.append('en[excerpt]', this.enExcerpt);
    formData.append('en[description]', this.enDescription);
    formData.append('country_id', this.countryId.toString());
    formData.append('parent[]', this.parent);
    formData.append('image', this.image);
    formData.append('is_active', this.isActive ? '1' : '0');

    this.http
    .post<any>(environment.apiUrl+'bodypart/store', formData)
    .subscribe((response) => {
      if(response.result['flash_type'] === "success"){
        this.showSuccess();
        this.reset();
      }else{
        this.showError();
      }
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
