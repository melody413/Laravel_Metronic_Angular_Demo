import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';
@Component({
  selector: 'app-create-faq',
  templateUrl: './create-faq.component.html',
  styleUrls: ['./create-faq.component.scss'],
  providers: [MessageService]

})
export class CreateFaqComponent {

  //directive component
  title_ar: string = "";
  title_en: string = "";
  errorMessage1: string = "";
  errorMessage2: string = "";
  content_ar: string = "";
  content_en: string = "";
  meta_title_ar: string = "";
  meta_title_en: string = "";
  meta_description_ar: string = "";
  meta_description_en: string = "";
  meta_keywords_ar: string = "";
  meta_keywords_en: string = "";
  slug: string;
  image: File;
  is_active: boolean = true;


  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}
  //image process
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
    if(this.title_ar === "" || this.title_en === "" ){
      if(this.title_ar === "") this.errorMessage1 = "*Please input the ar name";
      if(this.title_en === "") this.errorMessage2 = "*Please input the en name";
      this.showWarn();
      return;
    }
    const formData = new FormData();
    formData.append("ar[title]", this.title_ar);
    formData.append("en[title]", this.title_en);
    formData.append("ar[meta_title]", this.meta_title_ar);
    formData.append("en[meta_title]", this.meta_title_en);
    formData.append("ar[meta_description]", this.meta_description_ar);
    formData.append("en[meta_description]", this.meta_description_en);
    formData.append("ar[meta_keywords]", this.meta_keywords_ar);
    formData.append("en[meta_keywords]", this.meta_keywords_en);
    formData.append("ar[content]", this.content_ar);
    formData.append("en[content]", this.content_en);
    formData.append("slug", this.slug);
    formData.append("image", this.image);
    formData.append("is_active", this.is_active? "1" : "0");
    formData.append("image", "");
    formData.append("is_active", this.is_active? "1" : "0");

    this.http.post<any>(environment.apiUrl + "faqs/store", formData)
        .subscribe((response)=>{
            if(response.id){
              this.router.navigate(['/faq/list']);
            }
        }, (error)=>{
          this.showError();
        })


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
