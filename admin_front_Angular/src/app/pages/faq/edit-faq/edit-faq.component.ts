import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';
@Component({
  selector: 'app-edit-faq',
  templateUrl: './edit-faq.component.html',
  styleUrls: ['./edit-faq.component.scss'],
  providers: [MessageService]

})
export class EditFaqComponent implements OnInit{
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

faq: any;
faq_id: number;
image_name: string;
constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}
ngOnInit(): void {
  this.route.params.subscribe(params => {
    this.faq_id = params['id'];
  });
  this.http.get<any>(environment.apiUrl + "faqs/edit/" + this.faq_id)
      .subscribe((response)=>{
        this.faq = response.item;
        this.title_ar = this.faq.translations[0]['title'];
        this.title_en = this.faq.translations[1]['title'];

        this.content_ar = this.faq.translations[0]['content'];
        this.content_en = this.faq.translations[1]['content'];

        this.meta_title_ar = this.faq.translations[0]['meta_title'];
        this.meta_title_en = this.faq.translations[1]['meta_title'];

        this.meta_description_ar = this.faq.translations[0]['meta_description'];
        this.meta_description_en = this.faq.translations[1]['meta_description'];

        this.meta_keywords_ar = this.faq.translations[0]['meta_keywords'];
        this.meta_keywords_en = this.faq.translations[1]['meta_keywords'];
        this.slug = this.faq.slug;
        if(this.faq.image) this.image_name = environment.url + "uploads/faqs/" + this.faq.image;
        this.is_active = this.faq.is_active == "1" ? true : false;
        this.cdr.detectChanges();
      })
}



  //image process
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
    if(this.title_ar === "" || this.title_en === "" ){
      if(this.title_ar === "") this.errorMessage1 = "*Please input the ar name";
      if(this.title_en === "") this.errorMessage2 = "*Please input the en name";
      this.showWarn();
      return;
    }
    const formData = new FormData();
    formData.append("item_id", this.faq_id.toString());
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
    if(this.image) formData.append("image", this.image);
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

