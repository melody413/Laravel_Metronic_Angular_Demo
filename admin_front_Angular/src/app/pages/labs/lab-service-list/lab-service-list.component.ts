import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-lab-service-list',
  templateUrl: './lab-service-list.component.html',
  styleUrls: ['./lab-service-list.component.scss']
})

export class LabServiceListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "lab_services/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
