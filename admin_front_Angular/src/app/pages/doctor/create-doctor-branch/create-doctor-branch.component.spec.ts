import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateDoctorBranchComponent } from './create-doctor-branch.component';

describe('CreateDoctorBranchComponent', () => {
  let component: CreateDoctorBranchComponent;
  let fixture: ComponentFixture<CreateDoctorBranchComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateDoctorBranchComponent]
    });
    fixture = TestBed.createComponent(CreateDoctorBranchComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
