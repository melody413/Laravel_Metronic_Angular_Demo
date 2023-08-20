import { Component, OnInit, OnChanges, Input, ChangeDetectorRef } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { Observable } from 'rxjs';

@Component({
  selector: 'app-bodypart-list',
  templateUrl: './bodypart-list.component.html',
  styleUrls: ['./bodypart-list.component.scss']
})
export class BodypartListComponent implements OnInit{
  tabledata : any[];
  tmp1 : string ;
  constructor(private http: HttpClient, private cdr: ChangeDetectorRef) { }

  ngOnInit(){
    this.http.get<any>(environment.apiUrl + "bodypart/list").
      subscribe((response) => {        
        this.tabledata = response.data;
        this.tmp1 = "1231231";
        console.log(typeof response.data);
        console.log(this.tabledata);
      });
    this.tmp1 = "1231231";    
    this.updateData();
  }

  updateData() {
    this.cdr.detectChanges(); // Manually trigger change detection
  }

}