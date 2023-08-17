import { Component, ViewChild, OnInit } from '@angular/core';
import { ModalConfig, ModalComponent } from '../../_metronic/partials';
import { HttpClient, HttpHeaders } from '@angular/common/http';
import { environment } from 'src/environments/environment';


const API_USERS_URL = `${environment.apiUrl}/api`;


@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss'],
})
export class DashboardComponent {
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
  @ViewChild('modal') private modalComponent: ModalComponent;
  constructor(private http: HttpClient) {}

  async openModal() {
    return await this.modalComponent.open();
  }
  ngOnInit(): void {
    this.http.get<any>(`${API_USERS_URL}/dashboard`);
    this.getData();
  }

  getData(): void {
  }
}
