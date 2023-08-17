import { Component, HostBinding, HostListener } from '@angular/core';

@Component({
  selector: 'app-create-doctor',
  templateUrl: './create-doctor.component.html',
  styleUrls: ['./create-doctor.component.scss'],
})
export class CreateDoctorComponent {
  fileName = '';
  // constructor(private http: HttpClient) {}
  onFileSelected(event: any) {
    const file: File = event.target.files[0];

    if (file) {
      this.fileName = file.name;
      console.log(this.fileName);
      const formData = new FormData();
      formData.append('thumbnail', file);
      // const upload$ = this.http.post('/api/thumbnail-upload', formData);
      // upload$.subscribe();
    }
  }
  desItems = [{ title: 'Description' }];
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
}
