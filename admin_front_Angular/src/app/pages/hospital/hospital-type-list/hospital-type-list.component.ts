import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
@Component({
  selector: 'app-hospital-type-list',
  templateUrl: './hospital-type-list.component.html',
  styleUrls: ['./hospital-type-list.component.scss']
})
export class HospitalTypeListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "hospital_type/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
