import { HttpClient } from '@angular/common/http';
import { ChangeDetectorRef, Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
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
  constructor(private http: HttpClient, private cdr: ChangeDetectorRef){}
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
          this.cdr.detectChanges();

  }

  //doctor image process
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
}
