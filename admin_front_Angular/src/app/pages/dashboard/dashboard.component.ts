import { Component, ViewChild } from '@angular/core';
import { ModalConfig, ModalComponent } from '../../_metronic/partials';

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
  constructor() {}

  async openModal() {
    return await this.modalComponent.open();
  }
}
