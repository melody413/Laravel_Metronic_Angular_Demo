import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';
import { Router } from '@angular/router';

@Component({
  selector: 'app-bodypart-list',
  templateUrl: './bodypart-list.component.html',
  styleUrls: ['./bodypart-list.component.scss'],
})
export class BodypartListComponent implements OnInit, AfterViewInit{
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  search_result: any[];
  pageSize : number = 10;
  search_index: string = "";

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef,private router: Router,) {}
  ngOnInit(){
    this.http.get<any>(environment.apiUrl + "bodypart/list").
      subscribe((response) => {        
        this.tableData = response.data;
        this.paginator.pageSize = 10;
        this.paginator.length = response.recordsTotal;
        this.paginator.pageIndex = 0;
        this.pageSize = 10;
        this.cdr.detectChanges(); // Manually trigger change detection
      });
  }

  onPageChange(event: any) {
    this.pageChange();
  }

  onSelectChange(event : any) {
    this.pageSize = event.target.value;
    this.paginator.pageSize = event.target.value;
    this.paginator.pageIndex = 0;
    this.ngAfterViewInit();
    this.pageChange();
  }

  ngAfterViewInit() {
    this.paginator.pageSize = this.pageSize;
  }

  //search with the index
  search(){
    if(this.search_index == ""){
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "bodypart/table", {"search_index": this.search_index.toString()})   
          .subscribe((response)=>{
            this.tableData = response.search_result;
            this.paginator.length = response.search_result.length;
            this.paginator.pageSize = response.search_result.length;
            this.cdr.detectChanges(); // Manually trigger change detection
            
          })   
    }
  }

  pageChange(){
    if(this.paginator.pageIndex == 0 && this.paginator.pageSize == 10){
      this.pageSize = 10;
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "bodypart/table", {
        params: new HttpParams()
          .set('pageSize', this.paginator.pageSize.toString())
          .set('pageIndex', this.paginator.pageIndex.toString())
      }).subscribe((response)=>{
        this.tableData = response.search_result;
        this.cdr.detectChanges(); // Manually trigger change detection
      })
    }
  }

  //delete the data
  delete(id: number){
    if(confirm("Are you sure to delete?")) {
      this.http.get<any>(environment.apiUrl+ "bodypart/delete/" + id)
      .subscribe((response)=>{
        this.ngOnInit();
      })
    }
    
  }
  //edit the data
  edit(bodyPartId: number) {
    this.router.navigate(['bodypart', 'edit', bodyPartId]);
  }
}