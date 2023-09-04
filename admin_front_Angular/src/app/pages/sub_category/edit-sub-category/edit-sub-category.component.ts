import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-sub-category',
  templateUrl: './edit-sub-category.component.html',
  styleUrls: ['./edit-sub-category.component.scss']
})
export class EditSubCategoryComponent {
  //directive valuable
  ar_name: string = "";
  en_name: string = "";

  errorMessage1: string = "";
  errorMessage2: string = "";
  specialty: number[] = [];
  parent_category: number[] = [];
  is_active: boolean = true;
  //response data
  response_specialities: any[] = [];
  parent_categories: any[] = [];
  sub_category: any;
  sub_category_id: number;
  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}


  toggleCheckbox_specialty(event : any){
    
    const index = this.specialty.indexOf(event.target.value);
    if (index === -1) {
      this.specialty.push(event.target.value);
    } else {
      this.specialty.splice(index, 1);
    }
  }

  toggleCheckbox_parent_category(event : any){
    const index = this.parent_category.indexOf(event.target.value);
    if (index === -1) {
      this.parent_category.push(event.target.value);
    } else {
      this.parent_category.splice(index, 1);
    }
  }


  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.sub_category_id = params['id'];
    });
    //get speciallity
    this.http.get<any>(environment.apiUrl + "qanswer/getSpeciality")
        .subscribe((response)=>{
          this.response_specialities = response.specialities ;
          this.cdr.detectChanges();
        });
    this.http.get<any>(environment.apiUrl + "sub_category/edit/" + this.sub_category_id)    
        .subscribe((response)=>{
          this.parent_categories = response.sub_categories;
          this.sub_category = response.item;
          this.specialty = response.specialityIds;
          console.log(this.specialty.toString());

          this.ar_name = this.sub_category.translations[0]['name'];
          this.en_name = this.sub_category.translations[1]['name'];
          this.parent_category = response.sub_categories_parent;
          this.cdr.detectChanges();

        })

    
  }

  create(){
    if(this.ar_name === "" || this.en_name === "" ){
      if(this.ar_name === "") this.errorMessage1 = "*Please input the ar name";
      if(this.en_name === "") this.errorMessage2 = "*Please input the en name";
      return;
    }
    const formData = new FormData();
    formData.append("module_name", "");
    formData.append("ar[name]", this.ar_name);
    formData.append("en[name]", this.en_name);
    formData.append("country_id", "1");
    formData.append("item_id", this.sub_category_id.toString());

      for (let j = 0; j < this.specialty.length; j++) {
        if (this.specialty[j]) 
          formData.append("specialties[]", this.specialty[j].toString());
      }
      
      for (let j = 0; j < this.parent_category.length; j++) {
        if (this.parent_category[j]) 
          formData.append("parent[]", this.parent_category[j].toString());
      }
    formData.append("is_Active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "sub_category/store", formData)
        .subscribe((response)=>{
          if(response.id){
            alert("success");
            this.router.navigate(["/sub_category/list"]);
          }else{
            alert("error");
          }
        });
    

  }
}
