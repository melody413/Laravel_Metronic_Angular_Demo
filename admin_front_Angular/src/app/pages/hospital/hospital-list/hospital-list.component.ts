import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-hospital-list',
  templateUrl: './hospital-list.component.html',
  styleUrls: ['./hospital-list.component.scss']
})
export class HospitalListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}

  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "hospital/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
