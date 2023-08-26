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

  chartOptions = {
	  title: {
		  text: "Statics"
	  },
	  data: [{
		type: "column",
		dataPoints: [
      { label: "Users",  y: 149  },
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
