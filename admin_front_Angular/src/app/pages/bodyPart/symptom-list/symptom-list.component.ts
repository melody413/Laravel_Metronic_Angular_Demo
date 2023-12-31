import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';

@Component({
  selector: 'app-symptom-list',
  templateUrl: './symptom-list.component.html',
  styleUrls: ['./symptom-list.component.scss']
})
export class SymptomListComponent implements OnInit{
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  pageSize : number ;

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef){}

  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "symptom/list").
      subscribe((response) => {        
        // console.log(typeof response.symptoms);
        // console.log("adsfad"+response.symptoms["data"] + "size" + response.symptoms["total"]);
        this.tableData = response.symptoms.data;
        this.paginator.pageSize = 10;
        this.paginator.length = response.symptoms["total"];
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
