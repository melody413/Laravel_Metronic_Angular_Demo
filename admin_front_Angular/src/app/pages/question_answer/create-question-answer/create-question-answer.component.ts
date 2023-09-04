import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component } from '@angular/core';
import { Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-create-question-answer',
  templateUrl: './create-question-answer.component.html',
  styleUrls: ['./create-question-answer.component.scss']
})
export class CreateQuestionAnswerComponent {
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

  constructor(
    private http: HttpClient, 
    private cdr: ChangeDetectorRef,
    private router: Router,
  ) {}
  
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
    console.log(this.category.toString());
  }
  
  ngOnInit(): void {
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
  }

  create(){
    if(this.question_ar === "" || this.question_en === "" ){
      if(this.question_ar === "") this.errorMessage1 = "*Please input the ar question";
      if(this.question_en === "") this.errorMessage2 = "*Please input the en question";
      return;
    }
    const formData = new FormData();
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
            alert("success");
            this.router.navigate(["/question_answer/list"]);
          }else{
            alert("error");
          }
        });
    

  }

}
