import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-create-body-part',
  templateUrl: './create-body-part.component.html',
  styleUrls: ['./create-body-part.component.scss'],
})

export class CreateBodyPartComponent implements OnInit {
  arName: string ;
  arExcerpt: string ;
  arDescription: string ;
  enName: string ;
  enExcerpt: string ;
  enDescription: string ;
  countryId: number = 1;
  parent: string ;
  image: File ;
  isActive: boolean ;
  hasError : boolean = false;
  errorMessage : String;
  content: string = '';

  constructor(private http: HttpClient) {}

  ngOnInit(): void {
    this.http.get(environment.apiUrl+'bodypart/create')
    .subscribe((response) => {
      console.log(response);
    })
  }

  items = [
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
  save() {
    console.log(this.content);
  }
  //new body part process
  create(){
    //validation process
    if(this.arName==null || this.enName==null){
      if(this.arName == null) this.errorMessage = "Please input the ar Name";
      if(this.enName == null) this.errorMessage = "Please input the en Name";
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
    formData.append('image', this.image);
    formData.append('is_active', this.isActive ? '1' : '0');

    this.http
    .post('http://localhost:8000/api/api/bodypart/store', formData)
    .subscribe((response) => {
      console.log(response);
    });
  }
  onFileSelected(event: any){
    this.image = event.target.files[0];
    console.log(this.image);
  }
}
