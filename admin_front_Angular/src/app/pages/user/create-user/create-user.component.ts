import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-create-user',
  templateUrl: './create-user.component.html',
  styleUrls: ['./create-user.component.scss']
})
export class CreateUserComponent implements OnInit{

  //reference valuable
  name: string = "";
  email: string = "";
  password: string = "";
  rpassword: string = "";

  drPhone: string = "";
  clinicPhone: string = "";
  gender: number = 0;
  birthday: Date;
  address: string = "";
  speciality: string = "";
  specialityIn: string = "";
  facebook: string = "";
  twitter: string = "";
  instagram: string = "";
  share_approve: boolean;
  live_approve: boolean;
  service_approve: boolean;
  type: number;
  role: number;
  errorMessage1: string = ""; //name empty error message
  errorMessage2: string = ""; //email empty error message
  errorMessage3: string = ""; //password confirm error message
  errorMessage4: string = ""; //email validator error message
  //response data
  roles: any[] = [];

  constructor(
    private http: HttpClient, 
    private cdr: ChangeDetectorRef,
    private router: Router,
  ) {}

  emailRegex: RegExp = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;


  
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl+"role/all")
        .subscribe((response) => {
          this.roles = response.roles;
          this.cdr.detectChanges(); // Manually trigger change detection
        })
  }

  //password confirm
  onInputChange(event : any){
    const repwd = event;
    if(this.rpassword !== this.password){
      this.errorMessage3 = "Confirm the password correctly";
    }else{
      this.errorMessage3 = "";
    }
    this.cdr.detectChanges(); // Manually trigger change detection
  }
  //validate the name and email empty
  onInputChange1(event : any){
    
    const string = event;
    if(string){
      this.errorMessage1 = "";
    }else{
      this.errorMessage1 = "*please enter the name";
    }
    this.cdr.detectChanges(); // Manually trigger change detection
  }
  onInputChange2(event : any){
    const string = event;
    if(string){
      this.errorMessage2 = "";
      if(!this.emailRegex.test(string)){
        this.errorMessage4 = "*Invalid email address";
      }
    }else{
      this.errorMessage2 = "*please enther the email";
      this.errorMessage4 = ""
    }

    
    
    this.cdr.detectChanges(); // Manually trigger change detection
  }
  create(){

    if(this.name === "" || this.email === ""){
      if(this.name === "")
        this.errorMessage1 = "*please enter the name";
      if(this.email === ""){
        this.errorMessage2 = "*please enther the email";
      }
      return;
    }
    if(this.errorMessage3){
      return;
    }


    const formData = new FormData();
    formData.append("name", this.name);
    formData.append("email", this.email);
    formData.append("password", this.password);
    formData.append("dr_phone", this.drPhone);
    formData.append("phone", this.clinicPhone);
    formData.append("gender", this.gender == 0? "male" : "femail");
    formData.append("birthdate", this.birthday? this.birthday.toString() : "");
    formData.append("address", this.address);
    formData.append("specialties", this.speciality);
    formData.append("specialty_in", this.specialityIn);
    formData.append("facebook", this.facebook);
    formData.append("twitter", this.twitter);
    formData.append("share_approved", this.share_approve? "1" : "0");
    formData.append("live_approved", this.live_approve? "1" : "0");
    formData.append("services_approved", this.service_approve? "1" : "0");
    formData.append("type", this.type.toString());
    formData.append("role", this.role.toString());
    console.log(formData);
    this.http.post<any>(environment.apiUrl+"user/store", formData)
        .subscribe((response)=>{
          if(response.id){

          }
        })

  }
}
