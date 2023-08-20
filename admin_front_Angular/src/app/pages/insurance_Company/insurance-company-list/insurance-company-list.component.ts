import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';


@Component({
  selector: 'app-insurance-company-list',
  templateUrl: './insurance-company-list.component.html',
  styleUrls: ['./insurance-company-list.component.scss']
})
export class InsuranceCompanyListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "hospital_type/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
