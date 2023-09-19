import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';
import { MessageService } from 'primeng/api';
import { PrimeNGConfig } from 'primeng/api';

@Component({
  selector: 'app-edit-question-answer',
  templateUrl: './edit-question-answer.component.html',
  styleUrls: ['./edit-question-answer.component.scss'],
  providers: [MessageService]

})
export class EditQuestionAnswerComponent {
  //directive valuable
  question_ar: string = "";
  question_en: string = "";
  model: string = "default";
  answer_ar: string = "";
  answer_en: string= "";
  errorMessage1: string = "";
  errorMessage2: string = "";
  country_id: number = 1 ;
  specialty: number[] = [];
  category: number[] = [];
  is_active: boolean = true;
  //response data
  response_countries : any[] = [];
  response_specialities: any[] = [];
  response_categories: any[] = [];

  qanswer: any;
  qanswer_id: number;

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute, private messageService: MessageService, private primengConfig: PrimeNGConfig) {}
  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.qanswer_id = params['id'];
    });

    //get country
    this.http.get<any>(environment.apiUrl + "country/getall")
        .subscribe((response)=>{
          this.response_countries = Object.entries(response.countries);
          this.country_id = this.response_countries[0][0];
          this.cdr.detectChanges();
        });

    //get speciallity
    this.http.get<any>(environment.apiUrl + "qanswer/getSpeciality")
        .subscribe((response)=>{
          this.response_specialities = response.specialities ;
          this.cdr.detectChanges();
        });
    
    //get category
    this.http.get<any>(environment.apiUrl + "qanswer/getCategory")
    .subscribe((response)=>{
      this.response_categories = response.categories ;
      this.cdr.detectChanges();
    });
    this.http.get<any>(environment.apiUrl + "qanswer/edit/" + this.qanswer_id)
        .subscribe((response)=>{
          this.qanswer = response.item;
          this.answer_ar = this.qanswer.translations[0]['description'];
          this.answer_en = this.qanswer.translations[1]['description'];
          this.question_ar = this.qanswer.translations[0]['name'];
          this.question_en = this.qanswer.translations[1]['name'];
          if(response.categoryIds) this.category = response.categoryIds;
          if(response.specialityIds) this.specialty = response.specialityIds;

          this.country_id = this.qanswer.country_id;
          this.model = this.qanswer.module_name;
          this.is_active = this.qanswer.is_active == "1" ? true : false;
          this.cdr.detectChanges();
        })
  }
  
  toggleCheckbox_specialty(event : any){
    const index = this.specialty.indexOf(event.target.value);
    if (index === -1) {
      this.specialty.push(event.target.value);
    } else {
      this.specialty.splice(index, 1);
    }
    console.log(this.specialty.toString());
  }

  toggleCheckbox_category(event : any){
    const index = this.category.indexOf(event.target.value);
    if (index === -1) {
      this.category.push(event.target.value);
    } else {
      this.category.splice(index, 1);
    }
  }
  
  

  create(){
    if(this.question_ar === "" || this.question_en === "" ){
      if(this.question_ar === "") this.errorMessage1 = "*Please input the ar question";
      if(this.question_en === "") this.errorMessage2 = "*Please input the en question";
      this.cdr.detectChanges();
      this.showWarn();
      return;
    }
    const formData = new FormData();
    formData.append("item_id", this.qanswer_id.toString());
    formData.append("module_name", this.model);
    formData.append("ar[name]", this.question_ar);
    formData.append("en[name]", this.question_en);
    formData.append("ar[excerpt]", "");
    formData.append("en[excerpt]", "");
    formData.append("ar[description]", this.answer_ar);
    formData.append("en[description]", this.answer_en);
    if(this.country_id) formData.append("country_id", this.country_id.toString());

    if(this.model == "medicine"){
      console.log(this.category.length + ":" + this.specialty.length);
      for(let i = 0 ; i < this.category.length ; i++)
        if (this.category[i]) 
          formData.append("medicine_categories[]", this.category[i].toString());
    }else{
      console.log(this.response_categories.length + ":" + this.specialty.length);
      for (let j = 0; j < this.specialty.length; j++) {
        if (this.specialty[j]) 
          formData.append("specialties[]", this.specialty[j].toString());
      }
    }
    formData.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "qanswer/store", formData)
        .subscribe((response)=>{
          if(response.id){
            this.router.navigate(["/question_answer/list"]);
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

