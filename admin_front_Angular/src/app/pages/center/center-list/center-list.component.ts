import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';


@Component({
  selector: 'app-center-list',
  templateUrl: './center-list.component.html',
  styleUrls: ['./center-list.component.scss']
})
export class CenterListComponent {
  tabledata : any[];

  constructor(private http: HttpClient){}

  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "center/list").
      subscribe((response) => {        
        this.tabledata = response.data;
        console.log(typeof response.data);
        console.log(this.tabledata);
      });
  }
}
