import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { ActivatedRoute, Router } from '@angular/router';
@Component({
  selector: 'app-edit-disease',
  templateUrl: './edit-disease.component.html',
  styleUrls: ['./edit-disease.component.scss']
})
export class EditDiseaseComponent {
  desItems = [
    { title: 'Description' },
    { title: 'Symptoms' },
    { title: 'Causes' },
    { title: 'Complications' },
    { title: 'Diagnosis' },
    { title: 'Treatment' },
    { title: 'Protection' },
    { title: 'Alternative Therapies' },
  ];
  //reference valuable
  module_name: string;
  arName: string ="" ;  
  enName: string = "";
  arExcerpt: string = "";
  enExcerpt: string = ""; 
  arDescription: string = ""; 
  arSymptoms: string = "";
  arCauses: string = "";
  arComplications:string = ""; 
  arDiagnosis: string = ""; 
  arTreatment:string = ""; 
  arProtection: string = ""; 
  arAlternative_therapies: string = ""; 
  enDescription: string = "";
  enSymptoms: string = ""; 
  enCauses: string = "";
  enComplications: string = ""; 
  enDiagnosis: string = "";
  enTreatment :string = ""; 
  enProtection: string = "";
  enAlternative_therapies :string = ""; 
  countryid: number;
  parent_ids: number[] = [];
  body_part_ids: number[] = [];
  is_active: boolean = true;
  errorMessage1: string = "";
  errorMessage2: string = "";

  image: File;

  disease_id: number;
  //response data
  bodyparts : any [] = [];
  parent_disease: any[] = [];
  disease: any;
  
  bodyparts_index: number[];
  parent_disease_index: number[];
  image_name: string;
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute) {}
  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.disease_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "disease/create")
        .subscribe((response)=>{
          this.bodyparts = response.body_parts;
          this.parent_disease = response.diseases;
          this.crd.detectChanges();
        })
    if(this.disease_id){
      this.http.get<any>(environment.apiUrl+'disease/edit/' + this.disease_id)
      .subscribe((response) => {

        this.disease = response.item;
        this.arName = this.disease['translations'][0]['name'];
        this.enName = this.disease['translations'][1]['name'];
        this.arExcerpt = this.disease['translations'][0]['excerpt'];
        this.enExcerpt = this.disease['translations'][1]['excerpt'];
        this.arDescription = this.disease['translations'][0]['description'];
        this.enDescription = this.disease['translations'][1]['description'];
        this.arSymptoms = this.disease['translations'][0]['symptoms'];
        this.enSymptoms = this.disease['translations'][1]['symptoms'];
        this.arCauses = this.disease['translations'][0]['causes'];
        this.enCauses = this.disease['translations'][1]['causes'];
        this.arComplications = this.disease['translations'][0]['complications'];
        this.enComplications = this.disease['translations'][1]['complications'];
        this.arDiagnosis = this.disease['translations'][0]['diagnosis'];
        this.enDiagnosis = this.disease['translations'][1]['diagnosis'];
        this.arTreatment = this.disease['translations'][0]['treatment'];
        this.enTreatment = this.disease['translations'][1]['treatment'];
        this.arProtection = this.disease['translations'][0]['protection'];
        this.enProtection = this.disease['translations'][1]['protection'];
        this.arAlternative_therapies = this.disease['translations'][0]['alternative_therapies'];
        this.enAlternative_therapies = this.disease['translations'][1]['alternative_therapies'];
        this.body_part_ids = response.bps_parent;
        this.parent_ids = response.diseases_parent;
        if(this.disease['image']) this.image_name = environment.url + "uploads/diseases//" + this.disease['image'];
        this.is_active = this.disease['is_active'] === 1? true: false;
        this.crd.detectChanges();
      })
    }
  }

  toggleCheckbox_parent_ids(item: number) {
    const index = this.parent_ids.indexOf(item);
    if (index === -1) {
      this.parent_ids.push(item);
    } else {
      this.parent_ids.splice(index, 1);
    }
  }

  toggleCheckbox_body_part_ids(item: number) {
    const index = this.parent_ids.indexOf(item);
    if (index === -1) {
      this.body_part_ids.push(item);
    } else {
      this.body_part_ids.splice(index, 1);
    }
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
  reset(){
    this.arName = "";
    this.enName = "";
    this.arExcerpt = "";
    this.enExcerpt = "";
    this.arDescription = "";
    this.enDescription = "";
    this.arSymptoms = "";
    this.enSymptoms = "";
    this.arCauses = "";
    this.enCauses = "";
    this.arComplications = "";
    this.enComplications = "";
    this.arDiagnosis = "";
    this.enDiagnosis = "";
    this.arTreatment = "";
    this.enTreatment = "";
    this.arProtection = "";
    this.enProtection = "";
    this.arAlternative_therapies = "";
    this.enAlternative_therapies = "";
    this.body_part_ids = [];
    this.parent_ids = [];
    this.image_name = "";
    this.is_active = false;
    this.crd.detectChanges();

  }

  create(){
    //validation process
    if(this.arName=="" || this.enName==""){
      if(this.arName == "") this.errorMessage1 = "Please input the ar Name";
      if(this.enName == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }

    if(this.is_active == undefined){
      this.is_active = false;
    }
    const formData = new FormData();
    formData.append('module_name', ''); // Add the appropriate value based on your requirement
    formData.append('ar[name]', this.arName);
    formData.append('ar[excerpt]', this.arExcerpt);
    formData.append('ar[description]', this.arDescription);
    formData.append('ar[symptoms]', this.arSymptoms);
    formData.append('ar[causes]', this.arCauses);
    formData.append('ar[complications]', this.arComplications);
    formData.append('ar[diagnosis]', this.arDiagnosis);
    formData.append('ar[treatment]', this.arTreatment);
    formData.append('ar[protection]', this.arTreatment);
    formData.append('ar[alternative_therapies]', this.arAlternative_therapies);
    formData.append('en[name]', this.enName);
    formData.append('en[excerpt]', this.enExcerpt);
    formData.append('en[description]', this.enDescription);
    formData.append('en[symptoms]', this.enSymptoms);
    formData.append('en[causes]', this.enCauses);
    formData.append('en[complications]', this.enComplications);
    formData.append('en[diagnosis]', this.enDiagnosis);
    formData.append('en[treatment]', this.enTreatment);
    formData.append('en[protection]', this.enProtection);
    formData.append('en[alternative_therapies]', this.enAlternative_therapies);
    formData.append('country_id', "");
    formData.append('parent_ids', JSON.stringify(this.parent_ids));
    formData.append('body_part_ids', JSON.stringify(this.body_part_ids));
    if(this.image) formData.append('image', this.image);
    formData.append('is_active', this.is_active ? '1' : '0');
    formData.append('item_id', this.disease_id.toString());
    this.http
    .post(environment.apiUrl + 'disease/store', formData)
    .subscribe((response) => {
      alert("Success!");
      this.router.navigate(["/disease/list"]);
    });
  }

}
