import { ComponentFixture, TestBed } from '@angular/core/testing';

import { DoctorBranchComponent } from './doctor-branch.component';

describe('DoctorBranchComponent', () => {
  let component: DoctorBranchComponent;
  let fixture: ComponentFixture<DoctorBranchComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [DoctorBranchComponent]
    });
    fixture = TestBed.createComponent(DoctorBranchComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
