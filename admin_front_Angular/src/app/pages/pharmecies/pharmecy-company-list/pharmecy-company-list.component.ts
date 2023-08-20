import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-pharmecy-company-list',
  templateUrl: './pharmecy-company-list.component.html',
  styleUrls: ['./pharmecy-company-list.component.scss']
})
export class PharmecyCompanyListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "pharmacy_company/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
