import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-page',
  templateUrl: './edit-page.component.html',
  styleUrls: ['./edit-page.component.scss']
})
export class EditPageComponent implements OnInit{
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
  
  page: any;
  page_id: number;
  image_name: string;
  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}
  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.page_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "pages/edit/" + this.page_id)
        .subscribe((response)=>{
          this.page = response.item;
          this.title_ar = this.page.translations[0]['title'];
          this.title_en = this.page.translations[1]['title'];

          this.content_ar = this.page.translations[0]['content'];
          this.content_en = this.page.translations[1]['content'];

          this.meta_title_ar = this.page.translations[0]['meta_title'];
          this.meta_title_en = this.page.translations[1]['meta_title'];

          this.meta_description_ar = this.page.translations[0]['meta_description'];
          this.meta_description_en = this.page.translations[1]['meta_description'];

          this.meta_keywords_ar = this.page.translations[0]['meta_keywords'];
          this.meta_keywords_en = this.page.translations[1]['meta_keywords'];
          this.slug = this.page.slug;
          if(this.page.image) this.image_name = environment.url + "uploads/pages/" + this.page.image;
          this.is_active = this.page.is_active == "1" ? true : false;
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
      console.log("create btn clicked-----");
      if(this.title_ar === "" || this.title_en === "" ){
        if(this.title_ar === "") this.errorMessage1 = "*Please input the ar name";
        if(this.title_en === "") this.errorMessage2 = "*Please input the en name";
        return;
      }
      const formData = new FormData();
      formData.append("item_id", this.page_id.toString());
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
              alert("success");
              this.router.navigate(['/faq/list']);
            }else{
              alert("error");
            }
          })
  
  
    }
  }
  
