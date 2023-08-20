import { Component, OnInit } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-symptom-list',
  templateUrl: './symptom-list.component.html',
  styleUrls: ['./symptom-list.component.scss']
})
export class SymptomListComponent implements OnInit{
  tabledata : any[];

  constructor(private http: HttpClient){}

  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "symptom/list").
      subscribe((response) => {        
        this.tabledata = response.data;
        console.log(typeof response.data);
        console.log(this.tabledata);
      });
  }

}
