import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Router, ActivatedRoute  } from '@angular/router';
@Component({
  selector: 'app-edit-body-part',
  templateUrl: './edit-body-part.component.html',
  styleUrls: ['./edit-body-part.component.scss']
})
export class EditBodyPartComponent {
  arName: string = "";
  arExcerpt: string = "";
  arDescription: string = "";
  enName: string = "";
  enExcerpt: string = "";
  enDescription: string = "";
  countryId: number = 1;
  parent: string = "";
  image: File;
  isActive: boolean ;
  hasError : boolean = false;
  errorMessage1 : String = "";
  errorMessage2 : String = "";
  content: string = '';

  bodypart_id : number ;
  selectedItemIndex: number;
  image_name : string;
  //response data
  bodypart_parent : any[] = [];
  bodypart: any;
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute) {}

  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl+'bodypart/create')
    .subscribe((response) => {
      this.bodypart_parent = response.body_parts;
      this.crd.detectChanges();
    })
    this.route.params.subscribe(params => {
      this.bodypart_id = params['id'];
    });
    if(this.bodypart_id){
      this.http.get<any>(environment.apiUrl+'bodypart/edit/' + this.bodypart_id)
      .subscribe((response) => {
        this.bodypart = response.item;
        this.arName = this.bodypart['translations'][0]['name'];
        this.enName = this.bodypart['translations'][1]['name'];
        this.arExcerpt = this.bodypart['translations'][0]['excerpt'];
        this.enExcerpt = this.bodypart['translations'][1]['excerpt'];
        this.arDescription = this.bodypart['translations'][0]['description'];
        this.enDescription = this.bodypart['translations'][1]['description'];
        this.selectedItemIndex = this.bodypart['parent'];
        if(this.bodypart['image']) this.image_name = environment.url + "uploads/body_parts//" + this.bodypart['image'];
        this.isActive = this.bodypart["is_active"] === 1 ? true : false;
        this.crd.detectChanges();
      })
    }
  }

  save() {
    console.log(this.content);
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

  //doctor image process
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

  //save btn 
  create(){
    console.log("create btn clicked!~");

    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }

    if(this.isActive == undefined){
      this.isActive = false;
    }

    const formData = new FormData();
    formData.append('module_name', ''); // Add the appropriate value based on your requirement
    formData.append('ar[name]', this.arName);
    formData.append('ar[excerpt]', this.arExcerpt);
    formData.append('ar[description]', this.arDescription);
    formData.append('en[name]', this.enName);
    formData.append('en[excerpt]', this.enExcerpt);
    formData.append('en[description]', this.enDescription);
    formData.append('country_id', this.countryId.toString());
    formData.append('parent[]', this.parent);
    if(this.image) formData.append('image', this.image);
    formData.append('is_active', this.isActive ? '1' : '0');
    formData.append("item_id", this.bodypart_id.toString());

    this.http
    .post<any>(environment.apiUrl+'bodypart/store', formData)
    .subscribe((response) => {
      if(response.result['flash_type'] === "success"){
        alert("Success!");
        this.router.navigate(["/bodypart/list"]);
      }else{
        alert("Error!");
      }
    });
  }
  reset(){
    this.arName = "";
    this.enName = "";
    this.arExcerpt = "";
    this.enExcerpt = "";
    this.enDescription = "";
    this.arDescription = "";
    this.countryId = 1;
    this.parent = "";
    this.isActive = false;
    let image_tmp: any = document.getElementById('image') as HTMLElement;
    image_tmp.style.display="none";
    this.crd.detectChanges();
  }
  savenew(){
    console.log("savenew btn clicked!~");
    //validation process
    if(this.arName == "" || this.enName == ""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }

    if(this.isActive == undefined){
      this.isActive = false;
    }

    const formData = new FormData();
    formData.append('module_name', ''); // Add the appropriate value based on your requirement
    formData.append('ar[name]', this.arName);
    formData.append('ar[excerpt]', this.arExcerpt);
    formData.append('ar[description]', this.arDescription);
    formData.append('en[name]', this.enName);
    formData.append('en[excerpt]', this.enExcerpt);
    formData.append('en[description]', this.enDescription);
    formData.append('country_id', this.countryId.toString());
    formData.append('parent[]', this.parent);
    if(this.image) formData.append('image', this.image);
    formData.append('is_active', this.isActive ? '1' : '0');
    formData.append("item_id", this.bodypart_id.toString());
    this.http
    .post<any>(environment.apiUrl+'bodypart/store', formData)
    .subscribe((response) => {
      if(response.result['flash_type'] === "success"){
        alert("Success!");
        this.reset();
      }else{
        alert("Error!");
      }
    });
  }
}
