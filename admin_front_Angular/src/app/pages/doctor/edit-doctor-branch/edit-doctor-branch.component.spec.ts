import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditDoctorBranchComponent } from './edit-doctor-branch.component';

describe('EditDoctorBranchComponent', () => {
  let component: EditDoctorBranchComponent;
  let fixture: ComponentFixture<EditDoctorBranchComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditDoctorBranchComponent]
    });
    fixture = TestBed.createComponent(EditDoctorBranchComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
