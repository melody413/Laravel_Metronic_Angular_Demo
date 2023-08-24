import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';

@Component({
  selector: 'app-bodypart-list',
  templateUrl: './bodypart-list.component.html',
  styleUrls: ['./bodypart-list.component.scss'],
})
export class BodypartListComponent implements OnInit, AfterViewInit{
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  pageSize : number ;

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef) {}
  ngOnInit(){
    this.http.get<any>(environment.apiUrl + "bodypart/list").
      subscribe((response) => {        
        this.tableData = response.data;
        this.paginator.pageSize = 10;
        this.paginator.length = response.recordsTotal;
        this.cdr.detectChanges(); // Manually trigger change detection
      });
  }

  onPageChange(event: any) {
    console.log("--------" + this.paginator.length);
  }

  onSelectChange(event : any) {
    this.pageSize = event.target.value;
    this.ngAfterViewInit();
  }
  onSearchChange(event : any){
    const searchTerm = event.target.value.toLowerCase();
    this.tableData = this.tableData.filter(item => {
      return item[2].toLowerCase().includes(searchTerm) || item[3].toLowerCase().includes(searchTerm);
    });
    this.cdr.detectChanges();
    // console.log(event.target.value);
  }

  ngAfterViewInit() {
    this.paginator.pageSize = this.pageSize;
  }
}