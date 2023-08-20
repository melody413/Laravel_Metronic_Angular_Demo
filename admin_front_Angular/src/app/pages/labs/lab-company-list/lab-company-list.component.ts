import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-lab-company-list',
  templateUrl: './lab-company-list.component.html',
  styleUrls: ['./lab-company-list.component.scss']
})
export class LabCompanyListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "lab_company/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
