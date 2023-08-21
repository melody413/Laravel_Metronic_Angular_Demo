import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
@Component({
  selector: 'app-create-disease',
  templateUrl: './create-disease.component.html',
  styleUrls: ['./create-disease.component.scss'],
})
export class CreateDiseaseComponent {

  //reference valuable
  module_name: string;
  arName: string ;  
  enName: string;
  arExcerpt: string;
  enExcerpt: string; 
  arDescription: string; 
  arSymptoms: string;
  arCauses: string;
  arComplications:string; 
  arDiagnosis: string; 
  arTreatment:string; 
  arProtection: string; 
  arAlternative_therapies: string; 
  enDescription: string;
  enSymptoms: string; 
  enCauses: string;
  enComplications: string; 
  enDiagnosis: string;
  enTreatment :string; 
  enProtection: string;
  enAlternative_therapies :string; 
  countryid: number;
  parent_ids: number[] = [];
  body_part_ids: number[] = [];
  is_active: boolean;
  errorMessage: string;

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

  parentdisease = [
    { name : "الدوالي" }
  ];

  parentBodyIds = [
    { name: 'الجهاز الدوري' },
    { name: 'الأوعية الدموية' },
    { name: 'القلب' },
    { name: 'الشرايين' },
    { name: 'الأوردة' },
    { name: 'الشعيرات الدموية' },
    { name: 'الجهاز العضلي الهيكلي' },
    { name: 'العظام' },
    { name: 'المفاصل' },
    { name: 'العضلات' },
    { name: 'الأوتار' },
    { name: 'الأربطة' },
    { name: 'الغضاريف' },
    { name: 'الجهاز الهضمي' },
    { name: 'المريء' },
    { name: 'الفم' },
    { name: 'البلعوم' },
    { name: 'الغدد اللعابية' },
    { name: 'المعدة' },
    { name: 'الكبد' },
    { name: 'الأمعاء الدقيقة' },
    { name: 'الأمعاء الغليظة' },
    { name: 'المرارة' },
    { name: 'المستقيم' },
    { name: 'فتحة الشرج' },
    { name: 'الزائدة الدودية' },
    { name: 'اللسان' },
    { name: 'الجهاز التنفسي' },
    { name: 'الرئتين' },
    { name: 'القصبة الهوائية' },
    { name: 'الأنف' },
    { name: 'الجيوب الأنفية' },
    { name: 'الحنجرة' },
    { name: 'الحجاب الحاجز' },
    { name: 'الشعب الهوائية' },
    { name: 'الجهاز البولي' },
    { name: 'الكلى' },
    { name: 'الحالب' },
    { name: 'المثانة' },
    { name: 'الجهاز التناسلي' },
    { name: 'الجهاز التناسلي الانثوي' },
    { name: 'المهبل' },
    { name: 'الرحم' },
    { name: 'عنق الرحم' },
    { name: 'المبيض' },
    { name: 'قناة فالوب' },
    { name: 'الجهاز التناسلي الذكري' },
    { name: 'البروستاتا' },
    { name: 'القضيب' },
    { name: 'الخصية' },
    { name: 'كيس الصفن' },
    { name: 'الأسهر' },
    { name: 'الإحليل' },
    { name: 'الحويصلات المنوية' },
    { name: 'الجهاز اللمفاوي' },
    { name: 'الأوعية اللمفاوية' },
    { name: 'العقد اللمفاوية' },
    { name: 'نخاع العظم' },
    { name: 'الطحال' },
    { name: 'الجهاز العصبي' },
    { name: 'الدماغ' },
    { name: 'الحبل الشوكي' },
    { name: 'الأعصاب' },
    { name: 'العيون' },
    { name: 'الأذن' },
    { name: 'جهاز الغدد الصماء' },
    { name: 'البنكرياس' },
    { name: 'الغدة النخامية' },
    { name: 'الغدة الدرقية' },
    { name: 'الغدة الكظرية' },
    { name: 'الغدد جارات الدرقية' },
    { name: 'الغدة الصنوبرية' },
    { name: 'الجهاز اللحافي' },
    { name: 'الجلد' },
    { name: 'الأظافر' },
    { name: 'الشعر' },
    { name: 'الغدد العرقية' },
  ];
  constructor(private http: HttpClient) {}

  create(){
    //validation process
    if(this.arName==null || this.enName==null){
      if(this.arName == null) this.errorMessage = "Please input the ar Name";
      if(this.enName == null) this.errorMessage = "Please input the en Name";
      return;
    }

    if(this.is_active == undefined){
      this.is_active = false;
    }

    console.log("create Action: " + this.arName);
    console.log("create Action: " + this.arExcerpt);
    console.log("create Action: " + this.arDescription);
    console.log("create Action: " + this.arSymptoms);
    console.log("create Action: " + this.arCauses);
    console.log("create Action: " + this.arComplications);
    console.log("create Action: " + this.arDiagnosis);
    console.log("create Action: " + this.arTreatment);
    console.log("create Action: " + this.arProtection);
    console.log("create Action: " + this.enAlternative_therapies);
    console.log("create Action: " + this.countryid);
    console.log("create Action: " + this.parent_ids);
    console.log("create Action: " + this.body_part_ids);


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

    // this.parent_ids.forEach(id => formData.append('parent_ids', id.toString()));
    // this.body_part_ids.forEach(id => formData.append('body_part_ids', id.toString()));
    formData.append('is_active', this.is_active ? '1' : '0');

    this.http
    .post('http://localhost:8000/api/api/disease/store', formData)
    .subscribe((response) => {
      console.log(response);
    });
  }

}
