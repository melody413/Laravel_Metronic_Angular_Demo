import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';
@Component({
  selector: 'app-medicine-name-list',
  templateUrl: './medicine-name-list.component.html',
  styleUrls: ['./medicine-name-list.component.scss']
})
export class MedicineNameListComponent implements OnInit {
  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  pageSize : number ;
  search_result: any[];
  search_index: string = "";
  

  constructor(private http: HttpClient, private cdr: ChangeDetectorRef) {}
  ngOnInit(): void {
    this.http.get<any>(environment.apiUrl + "medicines_sc_name/list").
      subscribe((response) => {        
        this.tableData = response.result["data"];
        this.paginator.pageSize = 10;
        this.pageSize = 10;
        this.paginator.pageIndex = 0;
        this.paginator.length = response.result["recordsTotal"]; 
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
    this.pageChange();
  }

  //search with the index
  search(){
    if(this.search_index == ""){
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "medicines_sc_name/table", {"search_index": this.search_index.toString()})   
          .subscribe((response)=>{
            this.tableData = response.search_result;
            this.paginator.pageSize = response.search_result.length;
            this.paginator.length = response.search_result.length;
            this.paginator.pageIndex = response.search_result["current_page"]-1;
            this.cdr.detectChanges(); // Manually trigger change detection
            
          })   
    }
  }
  pageChange(){
    if(this.paginator.pageIndex == 0 && this.paginator.pageSize == 10){
      this.pageSize = 10;
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "medicines_sc_name/table", {
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
    if(confirm("Do you really delete the data?")){
      this.http.get<any>(environment.apiUrl+ "medicines_sc_name/delete/" + id)
        .subscribe((response)=>{
          this.ngOnInit();
        })
    }
  }
}
