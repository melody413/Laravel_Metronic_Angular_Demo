import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PharmecyCompanyListComponent } from './pharmecy-company-list.component';

describe('PharmecyCompanyListComponent', () => {
  let component: PharmecyCompanyListComponent;
  let fixture: ComponentFixture<PharmecyCompanyListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [PharmecyCompanyListComponent]
    });
    fixture = TestBed.createComponent(PharmecyCompanyListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
