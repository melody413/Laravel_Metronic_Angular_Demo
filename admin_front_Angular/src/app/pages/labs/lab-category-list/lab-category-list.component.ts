import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';


@Component({
  selector: 'app-lab-category-list',
  templateUrl: './lab-category-list.component.html',
  styleUrls: ['./lab-category-list.component.scss']
})
export class LabCategoryListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "lab_category/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
