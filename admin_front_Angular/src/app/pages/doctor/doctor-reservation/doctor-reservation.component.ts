import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
@Component({
  selector: 'app-doctor-reservation',
  templateUrl: './doctor-reservation.component.html',
  styleUrls: ['./doctor-reservation.component.scss']
})
export class DoctorReservationComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}

  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "reservation/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
