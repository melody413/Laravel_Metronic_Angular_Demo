import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Time } from '@angular/common';

@Component({
  selector: 'app-create-doctor',
  templateUrl: './create-doctor.component.html',
  styleUrls: ['./create-doctor.component.scss'],
})
export class CreateDoctorComponent implements OnInit{

  //reference valuable
  arName: string;
  enName: string;
  arTitle: string;
  enTitle: string;
  arExcerpt: string;
  enExcerpt: string;
  arDescription: string;
  enDescription: string;
  image :File;
  image_gallery_count: number;
  image_gallery: File[] = []; 
  image_gallery_names: string[] = [];
  gender : number;
  specialty: number[] = [];
  wait_time : number;
  useremail: string;
  is_reserve: boolean;
  is_active : boolean;
  hospital: string;
  center: string;
  insuranceCompany: string;
  facebook: string;
  twitter: string;
  instagram : string;
  youtube: string;
  website: string;
  user_entry_id: string;
  work_days : boolean[] =  Array(7).fill(false);
  time_start: Time;
  time_end: Time;
  patient_every: number;
  price: number;
  phone: string;
  arAddress: string;
  enAddress: string;
  country_id: number;
  city: number;
  area: number;
  lat_lng: string;
  maplink: string = "";
  branch: string = "1";
  entags: string;
  artags: string;
  enSubCats: string;
  arSubCats: string;

  constructor(private http: HttpClient,) {}

  ngOnInit(): void{
    this.image_gallery_count = 0;
  }

  


  toggleCheckbox_specialty(item: number){
    const index = this.specialty.indexOf(item);
    if (index === -1) {
      this.specialty.push(item);
    } else {
      this.specialty.splice(index, 1);
    }
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

  //multiple image process
  onMultipleFileSelected(event: any) {
    const file: File = event.target.files[0];
    const formdata = new FormData();
    formdata.append("file", file);
    formdata.append("paths", "doctors");

    this.http.post<any>(environment.apiUrl + "data/uploadImages", formdata)
    .subscribe((response)=>{
      const string = response.filename.toString();
      this.image_gallery_names.push(string);
      for(let i = 0 ; i < this.image_gallery_names.length ; i++){
        console.log(this.image_gallery_names[i]);
      }
    })
    this.image_gallery.push(event.target.files[0]);
    this.image_gallery_count = this.image_gallery.length;
  }

  cancelUpload(index: number) {
    this.image_gallery.splice(index, 1);
    this.image_gallery_names.splice(index, 1);
    this.image_gallery_count = this.image_gallery.length;
  }

  getPreviewImage(file: File): string {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    
    return URL.createObjectURL(file);
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


  create(){
    if(this.is_active == undefined){
      this.is_active = false;
    }
    if(this.is_reserve == undefined){
      this.is_reserve = false;
    }

    const formdata = new FormData();
    formdata.append("ar[name]", this.arName);
    formdata.append("en[name]", this.enName);
    formdata.append("ar[title]", this.arTitle);
    formdata.append("en[title]", this.enTitle);
    formdata.append("ar[excerpt]", this.arExcerpt);
    formdata.append("en[excerpt]", this.enExcerpt);
    formdata.append("ar[description]", this.arDescription);
    formdata.append("en[description]", this.enDescription);
    formdata.append("image", this.image);
    formdata.append("image_gallery_count", this.image_gallery_count.toString());
    for (let i = 0; i < this.image_gallery_names.length; i++) {
      formdata.append('image_gallery[]', this.image_gallery_names[i]);
    }
    formdata.append("gender", (this.gender == 1? "Female" : "male"));
    for(let i = 0 ; i < this.specialty.length ; i++){
      if(this.specialty[i]) {
        formdata.append("specialties[]", this.specialty[i].toString());
      }
    }
    formdata.append("facebook", this.facebook);
    formdata.append("twitter", this.twitter);
    formdata.append("instagram", this.instagram);
    formdata.append("youtube", this.youtube);
    formdata.append("website", this.website);
    formdata.append("user_entry_id", this.user_entry_id);
    for (let i = 0; i < this.work_days.length ; i++) {
      if(this.work_days[i]==true)
        formdata.append(`work_days[${i}]`, "1");
    }
    // if(this.time_start){
    //   const starTime = this.time_start.hours.toString + ":" + this.time_start.minutes.toString +":00"; 
    //   formdata.append("time_start", starTime);
    // }
    // if(this.time_end){
    //   const endTime = this.time_end.hours.toString + ":" + this.time_end.minutes.toString +":00"; 
    //   formdata.append("time_end", endTime);
    // }
    // if(this.patient_every){
    //   formdata.append("patient_every", this.patient_every.toString());
    // }
    // formdata.append("price", this.price.toString());
    formdata.append("ar[address]", this.arAddress);
    formdata.append("en[address]", this.enAddress);
    // formdata.append("country_id", this.country_id.toString());
    formdata.append("lat_lng", this.lat_lng);
    formdata.append("phone", this.phone);
    formdata.append("map_link", this.maplink);
    formdata.append("branch", this.branch);
    formdata.append("tags_en", "");
    formdata.append("sub_cats_en", "");
    formdata.append("tags_ar", "");
    formdata.append("sub_cats_ar", "");

    this.http.post<any>(environment.apiUrl + "doctor/store", formdata).subscribe(
      (response) => {
        console.log(response);
      }
    )
  }
}
