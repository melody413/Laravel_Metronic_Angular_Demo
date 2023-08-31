import { Component, OnInit, OnChanges, Input, ChangeDetectorRef, ViewChild, AfterViewChecked, AfterViewInit   } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { environment } from 'src/environments/environment';
import { MatPaginator,PageEvent } from '@angular/material/paginator';
import { ActivatedRoute, Router } from '@angular/router';
@Component({
  selector: 'app-doctor-rate',
  templateUrl: './doctor-rate.component.html',
  styleUrls: ['./doctor-rate.component.scss']
})
export class DoctorRateComponent {

  @ViewChild(MatPaginator) paginator: MatPaginator;
  @Input() tableData: any[];
  pageSize : number ;
  search_result: any[];
  search_index: string = "";
  doctor_id: number;
  constructor(private http: HttpClient, private crd: ChangeDetectorRef,private router: Router, private route: ActivatedRoute,) {}

  ngOnInit(): void {
    this.route.params.subscribe(params => {
      this.doctor_id = params['id'];
    });
    this.http.get<any>(environment.apiUrl + "doctor/rate/" + this.doctor_id).
      subscribe((response) => {       
        if(response.data){
          this.tableData = response.data["data"];
          this.paginator.pageSize = response.data["recordsTotal"];
          this.paginator.length = response.data["recordsTotal"];
          this.paginator.pageIndex = 0;
          this.crd.detectChanges(); // Manually trigger change detection
        } 
        console.log(this.tableData);
        
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
      this.http.post<any>(environment.apiUrl + "doctor/table", {"search_index": this.search_index.toString()})   
          .subscribe((response)=>{
            this.tableData = response.search_result;
            this.paginator.pageSize = response.search_result.length;
            this.paginator.length = response.search_result.length;
            this.paginator.pageIndex = response.search_result["current_page"]-1;
            this.crd.detectChanges(); // Manually trigger change detection
            
          })   
    }
  }
  pageChange(){
    if(this.paginator.pageIndex == 0 && this.paginator.pageSize == 10){
      this.pageSize = 10;
      this.ngOnInit();
    }else{
      this.http.post<any>(environment.apiUrl + "doctor/table", {
        params: new HttpParams()
          .set('pageSize', this.paginator.pageSize.toString())
          .set('pageIndex', this.paginator.pageIndex.toString())
      }).subscribe((response)=>{
        this.tableData = response.search_result["data"];
        this.paginator.pageSize = response.search_result["per_page"];
        this.paginator.length = response.search_result["total"];
        this.paginator.pageIndex = response.search_result["current_page"]-1;
        this.crd.detectChanges(); // Manually trigger change detection
      })
    }
  }

  //delete the data
  delete(id: number){
    if(confirm("Are your really delete this data?")){
      this.http.get<any>(environment.apiUrl+ "doctor/rate/delete/" + id)
      .subscribe((response)=>{
        this.ngOnInit();
      })
    }
    
  }
}
