import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-specialty',
  templateUrl: './edit-specialty.component.html',
  styleUrls: ['./edit-specialty.component.scss']
})
export class EditSpecialtyComponent implements OnInit{
  
  //directive valuable
  name_ar: string = "";
  name_en: string = "";
  is_active: boolean = true;
  errorMessage1: string= "";
  errorMessage2: string= "";

  specialty: any;
  specialty_id: number;

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}
  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.specialty_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "specialty/edit/" + this.specialty_id)
        .subscribe((response)=>{
          this.specialty = response.item;
          this.name_ar = this.specialty.translations[0]['name'];
          this.name_en = this.specialty.translations[1]['name'];
          this.is_active = this.specialty.is_active == "1" ? true : false;
          this.cdr.detectChanges();
        })
  this.cdr.detectChanges();
  }

  

  create(){
    if(this.name_ar === "" || this.name_en === "" ){
      if(this.name_ar === "") this.errorMessage1 = "*Please input the ar name";
      if(this.name_en === "") this.errorMessage2 = "*Please input the en name";
      return;
    }
    const formData = new FormData();
    formData.append("item_id", this.specialty_id.toString());
    formData.append("ar[name]", this.name_ar);
    formData.append("en[name]", this.name_en);
    formData.append("is_active", this.is_active? "1" : "0");

    this.http.post<any>(environment.apiUrl + "specialty/store", formData)
              .subscribe((response)=>{
                if(response.id){
                  alert('success');
                  this.router.navigate(["/speciality/list"])
                }else{
                  alert('error');
                }
              })
    
  }
  savenew(){
    if(this.name_ar === "" || this.name_en === "" ){
      if(this.name_ar === "") this.errorMessage1 = "*Please input the ar name";
      if(this.name_en === "") this.errorMessage2 = "*Please input the en name";
      return;
    }
    const formData = new FormData();
    formData.append("ar[name]", this.name_ar);
    formData.append("en[name]", this.name_en);
    formData.append("is_active", this.is_active? "1" : "0");

    this.http.post<any>(environment.apiUrl + "specialty/store", formData)
              .subscribe((response)=>{
                if(response.id){
                  alert('success');
                }else{
                  alert('error');
                }
              })
    
  }
  reset(){
  
  }
}

