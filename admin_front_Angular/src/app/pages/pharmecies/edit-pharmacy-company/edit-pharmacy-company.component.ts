import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
@Component({
  selector: 'app-edit-pharmacy-company',
  templateUrl: './edit-pharmacy-company.component.html',
  styleUrls: ['./edit-pharmacy-company.component.scss']
})
export class EditPharmacyCompanyComponent implements OnInit {
  desItems = [{ title: 'Description' }];
   //reference valuable
   errorMessage1: string ="";
   errorMessage2: string ="";
   
   arName: string = "";
   enName: string = "";
   arExcerpt: string = "";
   enExcerpt: string = "";
   arDescription: string = "";
   enDescription: string = "";
   image :File;
   is_active : boolean = true;

   pharmacy_co_id: number;
   pharmacy_company: any;
   image_name: string = "";
   constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}

    ngOnInit(): void {
      this.route.params.subscribe(params => {
        this.pharmacy_co_id = params['id'];
      });
      this.http.get<any>(environment.apiUrl + "pharmacy_company/edit/" + this.pharmacy_co_id)
          .subscribe((response)=>{
            this.pharmacy_company = response.result.item;
            console.log()
            this.arName = this.pharmacy_company.translations[0]['name'];
            this.enName = this.pharmacy_company.translations[1]['name'];
            this.arExcerpt = this.pharmacy_company.translations[0]['excerpt'];
            this.enExcerpt = this.pharmacy_company.translations[1]['excerpt'];
            this.arDescription = this.pharmacy_company.translations[0]['description'];
            this.enDescription = this.pharmacy_company.translations[1]['description'];
            if(this.pharmacy_company.image) this.image_name = environment.url+ "uploads/pharmacy_companies/" +this.pharmacy_company.image;
            this.crd.detectChanges();
          })  
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

  
  getPreviewImage(file: File): string {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    
    return URL.createObjectURL(file);
  }

  reset(){

  }
  edit(){
    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }
    if(this.is_active == undefined){
      this.is_active = false;
    }
    const formdata = new FormData();
    formdata.append("item_id", this.pharmacy_co_id.toString());
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);

    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    if(this.image) formdata.append("image", this.image);
    formdata.append("is_active", this.is_active? "1" : "0");
    this.http.post<any>(environment.apiUrl + "pharmacy_company/store", formdata).subscribe(
      (response) => {
        if(response.next) {
          alert("success");
          this.router.navigate(["pharmecy/companylist"]);
        }
        else alert("error");
      }
    )
  }

}

