import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, SimpleChanges  } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';

@Component({
  selector: 'app-bodypart-list',
  templateUrl: './bodypart-list.component.html',
  styleUrls: ['./bodypart-list.component.scss']
})
export class BodypartListComponent implements OnInit{
  @Input() tableData: any[];
  tabledata1 : any[];
  tmp1 : string ;
  constructor(private http: HttpClient, private cdr: ChangeDetectorRef) { 
  }

  ngOnInit(){
    this.http.get<any>(environment.apiUrl + "bodypart/list").
      subscribe((response) => {        
        this.tableData = response.data;
        this.cdr.detectChanges(); // Manually trigger change detection
      });
  }
}