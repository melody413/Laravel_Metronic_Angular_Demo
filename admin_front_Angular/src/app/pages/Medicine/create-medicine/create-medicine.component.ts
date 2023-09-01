import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { environment } from 'src/environments/environment';
@Component({
  selector: 'app-create-medicine',
  templateUrl: './create-medicine.component.html',
  styleUrls: ['./create-medicine.component.scss']
})
export class CreateMedicineComponent implements OnInit{

  //directive valuable
  name_ar: string = "";
  name_en: string = "";
  excerpt_ar: string = "";
  excerpt_en: string = "";
  model: string = "default";
  description_ar: string = "";
  description_en: string= "";

  ingredient1: number;
  ingredient2: number;
  ingredient3: number;

  concentration: string = "";
  concentration2: string = "";
  concentration3: string = "";

  activeIngredient: string= "";
  maximumIntake: string= "";
  company: number;
  answer_en: string;
  answer_ar: string;
  errorMessage1: string = "";
  errorMessage2: string = "";
  is_proprietary: boolean = true;
  is_available: boolean = true;


  form: string="";
  conc_type: string="";
  doseUnit: string="";
  max_doseValue: string="";
  max_doseUnit: string="";
  en_overdosage: string="";
  dose_ar: string = "";
  dose: string = "";
  frequency: string = "";
  targetPopulation: string = "";
  max_frequency: string = "";
  max_targetPopulation: string = "";


  ar_breastfeedingWarning: string = "";
  en_breastfeedingWarning: string = ""; 
  ar_clinicalPharmacology: string = "";
  en_clinicalPharmacology: string = "";
  ar_foodWarning: string = "";
  en_foodWarning: string = "";
  ar_mechanismOfAction: string = "";
  en_mechanismOfAction: string = "";
  en_pregnancyWarning: string = "";
  ar_pregnancyWarning: string = "";
  ar_prescriptionStatus: string = "";
  en_prescriptionStatus: string= "";
  warning_ar: string = "";
  warning_en: string = "";

  medical_uses_ar: string = "";
  medical_uses: string = "";
  type: string = "";
  suspensie: string = "";
  quantity: number;
  price: string = "";
  made_in: string = "";
  category: number;
  side_effects_ar: string = "";
  side_effects: string = "";
  disease_ar: string = "";
  disease: string = "";
  disease_2_ar: string = "";
  disease_2: string = "";

  disease_3_ar: string = "";
  disease_3: string = "";

  interactions_ar: string = "";
  interactions: string = "";
  bodypart: number;
  country: number;
  image: File;
  is_active: boolean = true;

  //response data
  categories : any[] = [];
  companies : any[] = [];
  medicines_sc_names : any[] = [];
  bodyparts : any[] = [];
  coutries: any[] = [];


  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}



  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "medicines/create")
        .subscribe((response)=>{
          this.categories = response.result['categories'];
          this.companies = response.result['companies'];
          this.medicines_sc_names = response.result["medicines_sc_names"];
          this.bodyparts = response.result['bodyparts'];
        });
      this.http.get<any>(environment.apiUrl + "country/getall")
          .subscribe((response)=>{
            this.coutries = Object.entries(response.countries);
          });
          this.crd.detectChanges();

  }
  //name change function
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

  //image process
  onFileSelected(event: any) {
    this.image = event.target.files[0];
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
    //validation process
    if(this.name_ar == "" || this.name_en == ""){
      if(this.name_ar == "") this.errorMessage1 = "Please input the ar Name";
      if(this.name_en == "") this.errorMessage2 = "Please input the en Name";
      this.crd.detectChanges();
      return;
    }

    const formdata = new FormData();
    formdata.append("ar[name]", this.name_ar);
    formdata.append("en[name]", this.name_en);
    formdata.append("ar[excerpt]", this.excerpt_ar);
    formdata.append("en[excerpt]", this.excerpt_en);
    formdata.append("ar[description]", this.description_ar);
    formdata.append("en[description]", this.description_en);

    formdata.append("scientific_name_1", "")
    if(this.ingredient1) formdata.append("scientific_name_1", this.ingredient1.toString());
    formdata.append("scientific_name_2", "")
    if(this.ingredient2) formdata.append("scientific_name_2", this.ingredient1.toString());
    formdata.append("scientific_name_3", "")
    if(this.ingredient3) formdata.append("scientific_name_3", this.ingredient1.toString());

    if(this.concentration) formdata.append("concentration", this.concentration.toString());
    if(this.concentration2) formdata.append("concentration_2", this.concentration2.toString());
    if(this.concentration3) formdata.append("concentration_3", this.concentration3.toString());

    formdata.append("maximumIntake", this.maximumIntake);
    formdata.append("activeIngredient", this.activeIngredient);

    formdata.append("drug_class", "");
    formdata.append("drug_class", "");

    formdata.append("available_strength", "");
    formdata.append("available_strength", "");

    formdata.append("company", "");
    if(this.company) formdata.append("company", this.company.toString());

    formdata.append("isAvailableGenerically", this.is_available ? "1" : "0");
    formdata.append("isProprietary", this.is_proprietary ? "1" : "0");

    formdata.append("form", this.form);
    formdata.append("form", this.form);

    formdata.append("conc_type", this.conc_type);

    formdata.append("max_doseUnit", this.max_doseUnit);
    formdata.append("max_doseValue", this.max_doseValue);
    formdata.append("doseUnit", this.doseUnit);

    formdata.append("en[overdosage]", this.en_overdosage);
    formdata.append("dose", this.dose);
    formdata.append("dose_ar", this.dose_ar);

    formdata.append("frequency", this.frequency);
    formdata.append("targetPopulation", this.targetPopulation);
    formdata.append("max_frequency", this.max_frequency);
    formdata.append("max_targetPopulation", this.max_targetPopulation);    

    formdata.append("ar[breastfeedingWarning]", this.ar_breastfeedingWarning);
    formdata.append("ar[clinicalPharmacology]", this.ar_clinicalPharmacology);
    formdata.append("ar[foodWarning]", this.ar_foodWarning);
    formdata.append("ar[mechanismOfAction]", this.ar_mechanismOfAction);
    formdata.append("ar[pregnancyWarning]", this.ar_pregnancyWarning);
    formdata.append("ar[prescriptionStatus]", this.ar_prescriptionStatus);    

    formdata.append("en[breastfeedingWarning]", this.en_breastfeedingWarning);
    formdata.append("en[clinicalPharmacology]", this.en_clinicalPharmacology);
    formdata.append("en[foodWarning]", this.en_foodWarning);
    formdata.append("en[mechanismOfAction]", this.en_mechanismOfAction);
    formdata.append("en[pregnancyWarning]", this.en_pregnancyWarning);
    formdata.append("en[prescriptionStatus]", this.en_prescriptionStatus);    
    
    formdata.append("warning_ar", this.warning_ar);
    formdata.append("warning_en", this.warning_en);

    formdata.append("medical_uses_ar", this.medical_uses_ar);
    formdata.append("medical_uses", this.medical_uses);   

    formdata.append("type", this.type);
    formdata.append("suspensie", this.suspensie);  

    if(this.quantity) formdata.append("quantity", this.quantity.toString());
    formdata.append("price", this.price);  

    formdata.append("made_in", this.made_in);
    if(this.category) formdata.append("category[]", this.category.toString());

    formdata.append("side_effects_ar", this.side_effects_ar);
    formdata.append("side_effects", this.side_effects);  
    formdata.append("disease_ar", this.disease_ar);
    formdata.append("disease", this.disease);  
    formdata.append("disease_2_ar", this.disease_2_ar);
    formdata.append("disease_2", this.disease_2);  
    formdata.append("disease_3_ar", this.disease_3_ar);
    formdata.append("disease_3", this.disease_3);  
    formdata.append("interactions_ar", this.interactions_ar);
    formdata.append("interactions", this.interactions);
    
    if(this.bodypart) formdata.append("body_part_ids", this.bodypart.toString());
    if(this.country) formdata.append("country_id", this.bodypart.toString());

    if(this.image) formdata.append("image", this.image);
    formdata.append("is_active", this.is_active ? "1" : "0");

    this.http.post<any>(environment.apiUrl + "medicines/store", formdata)
            .subscribe((response)=>{
              if(response.id){
                alert("success");
                this.router.navigate(['/medicines/list']);
              }else{
                alert("error");
              }
            })
  }
}
