import { Component, ViewChild, OnInit, Renderer2, ChangeDetectorRef  } from '@angular/core';
import { ModalConfig, ModalComponent } from '../../_metronic/partials';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { interval } from 'rxjs'; 
import { trigger, transition, style, animate } from '@angular/animations';



@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss'],
  animations: [
    trigger('slideAnimation', [
      transition(':enter', [
        style({ transform: 'translateX(100%)', opacity: 0 }),
        animate('500ms', style({ transform: 'translateX(0)', opacity: 1 }))
      ]),
      transition(':leave', [
        animate('500ms', style({ transform: 'translateX(-100%)', opacity: 0 }))
      ])
    ])
  ]
})
export class DashboardComponent implements OnInit{
  today: string;
  center_count: number;
  doctor_branches_count: number;
  doctors_count: number;
  hospital_count:number;
  insurance_company_count: number;
  lab: number;
  medicine_count:number;
  pharmacy_count: number;
  user_admin_count: number;
  user_count: number;
  user_doctor_count: number;
  user_moderator_count: number;
  user_normal_count: number;

  chartOptions = {
	  title: {
		  text: "Statics"
	  },
	  data: [{
		type: "column",
		dataPoints: [
      { label: "Users",  y: 123 },
      { label: "Doctors", y: 471  },
      { label: "Moderator", y: 25  },
      { label: "Admin",  y: 30  },
      ]
	  }]                
  };

  modalConfig: ModalConfig = {
    modalTitle: 'Modal title',
    dismissButtonLabel: 'Submit',
    closeButtonLabel: 'Cancel'
  };

  src: string = "http://localhost:8000/images/imageslider/";
  imageUrls: string[] = ['1.jpg', '2.jpg', '3.jpg']; // Replace these with your image URLs
  currentImageIndex = 0;
  
  @ViewChild('modal') private modalComponent: ModalComponent;
  constructor(private http: HttpClient, private renderer: Renderer2, private cdr: ChangeDetectorRef) {
  }

  async openModal() {
    return await this.modalComponent.open();
  }
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "dashboard")
        .subscribe((response)=>{
          this.doctors_count = response.doctors_count;
          this.center_count = response.center_count;
          this.doctor_branches_count = response.doctor_branches_count;
          this.hospital_count = response.hospital_count;
          this.user_normal_count = response.user_normal_count;
          this.insurance_company_count = response.insurance_company_count;
          this.lab = response.lab;
          this.medicine_count = response.medicine_count;
          this.pharmacy_count = response.pharmacy_count;
          this.user_admin_count = response.user_admin_count
          this.user_moderator_count = response.user_moderator_count;
          this.user_count = response.user_count;
          this.user_doctor_count = response.user_doctor_count;
          this.chartOptions.data[0]['dataPoints'][0]['y'] = this.user_normal_count;
          this.chartOptions.data[0]['dataPoints'][1]['y'] = this.user_doctor_count;
          this.chartOptions.data[0]['dataPoints'][2]['y'] = this.user_moderator_count;
          this.chartOptions.data[0]['dataPoints'][3]['y'] = this.user_admin_count;
          this.cdr.detectChanges();
        });
    interval(4000).subscribe(() => {
      this.slideNext();
      this.cdr.detectChanges();
    });
    this.today = new Date().toLocaleDateString();
  }

  slideNext() {
    this.currentImageIndex++;
    if (this.currentImageIndex >= this.imageUrls.length) {
      this.currentImageIndex = 0;
    }
  }

  slidePrev() {
    this.currentImageIndex--;
    if (this.currentImageIndex < 0) {
      this.currentImageIndex = this.imageUrls.length - 1;
    }
  }
}
