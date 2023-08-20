import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-disease-list',
  templateUrl: './disease-list.component.html',
  styleUrls: ['./disease-list.component.scss']
})
export class DiseaseListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}

  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "disease/list").
      subscribe((response) => {        
        this.tabledata = response.data;
        console.log(typeof response.data);
        console.log(this.tabledata);
      });
  }
}
