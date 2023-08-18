import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators, FormsModule } from '@angular/forms';

@Component({
  selector: 'app-create-body-part',
  templateUrl: './create-body-part.component.html',
  styleUrls: ['./create-body-part.component.scss'],
})
export class CreateBodyPartComponent {
  arName: string ;
  arExcerpt: string ;
  arDescription: string ;
  enName: string ;
  enExcerpt: string ;
  enDescription: string ;
  countryId: number ;
  parent: string ;
  image: File ;
  isActive: boolean ;
  hasError : boolean = false;

  content: string = '';
  constructor() {}
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
  create(){
    if(this.arName==null || this.enName==null){
      this.hasError = true;
      return;
    }
    if(this.isActive == undefined){
      this.isActive = false;
    }
    console.log(this.arName + this.parent + this.arDescription + this.isActive );
  }
  onFileSelected(event: any){
    this.image = event.target.files[0];
    console.log(this.image);

  }
}
