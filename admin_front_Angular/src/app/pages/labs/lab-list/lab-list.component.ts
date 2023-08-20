import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-lab-list',
  templateUrl: './lab-list.component.html',
  styleUrls: ['./lab-list.component.scss']
})
export class LabListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "lab/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
