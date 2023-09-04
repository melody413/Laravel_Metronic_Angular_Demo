import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-edit-user',
  templateUrl: './edit-user.component.html',
  styleUrls: ['./edit-user.component.scss']
})
export class EditUserComponent {
  //reference valuable
  name: string = "";
  email: string = "";
  password: string = "";
  rpassword: string = "";

  drPhone: string = "";
  clinicPhone: string = "";
  gender: number = 0;
  birthday: string;
  address: string = "";
  speciality: string = "";
  specialityIn: string = "";
  facebook: string = "";
  twitter: string = "";
  instagram: string = "";
  ppassword: string = "";
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


  user: any;
  user_id: number;
  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}


  emailRegex: RegExp = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;


  
  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.user_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl+"role/all")
        .subscribe((response) => {
          this.roles = response.roles;
          this.cdr.detectChanges(); // Manually trigger change detection
        })
    this.http.get<any>(environment.apiUrl + "user/edit/" + this.user_id)
    .subscribe((response)=>{
      this.user = response.item;
      this.name = this.user.name;
      this.email = this.user.email;
      this.address = this.user.address;
      this.drPhone = this.user.dr_phone;
      this.clinicPhone = this.user.phone;
      this.gender = this.user.gender == "male" ? 1 : 0;
      this.birthday = this.user.birthdate;
      this.speciality = this.user.specialties;
      this.specialityIn = this.user.specialty_in;
      this.facebook = this.user.facebook;
      this.twitter = this.user.twitter;
      this.instagram = this.user.instagram;
      this.share_approve = this.user.share_approved == "1" ? true : false;
      this.live_approve = this.user.live_approved == "1" ? true : false;
      this.service_approve = this.user.services_approved == "1" ? true : false;
      this.type = this.user.type;
      this.role = this.user.role;

      this.ppassword = this.user.password;



      this.cdr.detectChanges();
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
    formData.append("item_id", this.user_id.toString());
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
            this.router.navigate(['/user/list']);
          }else{
            alert("error");
          }
        })

  }
}

