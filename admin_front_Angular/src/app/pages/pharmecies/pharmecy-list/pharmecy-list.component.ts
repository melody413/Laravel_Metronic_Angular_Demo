import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';


@Component({
  selector: 'app-pharmecy-list',
  templateUrl: './pharmecy-list.component.html',
  styleUrls: ['./pharmecy-list.component.scss']
})
export class PharmecyListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "pharmacy/list").
      subscribe((response) => {        
        this.tabledata = response.data;
      });
  }
}
