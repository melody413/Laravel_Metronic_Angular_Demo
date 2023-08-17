import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateHospitalTypeComponent } from './create-hospital-type.component';

describe('CreateHospitalTypeComponent', () => {
  let component: CreateHospitalTypeComponent;
  let fixture: ComponentFixture<CreateHospitalTypeComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateHospitalTypeComponent]
    });
    fixture = TestBed.createComponent(CreateHospitalTypeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
